<?php
/**
 * Created by PhpStorm.
 * User: hieunt
 * Date: 2/1/16
 * Time: 6:35 AM
 */
namespace App\Http\Controllers;


use App\Console\Commands\webSocket;
use App\Libraries\Utils;
use App\Models\Inventories;
use App\Models\Tasks;
use App\Models\Templates;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index()
    {
        $tasks = Tasks::orderBy('id', 'desc')->paginate(12);
        $invs = Inventories::select("name", "id")->get();
        $templates = Templates::select("name", "id")->get();
        return view("jobs.index", compact("invs", "templates", "tasks"));
    }

    public function template()
    {
        $roles = Tasks::getRoles();
        return view("jobs.template", compact("invs", "roles"));
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'iid' => 'required',
            'tid' => 'required',
            'sudo' => 'required',
            'vars' => 'required',
        ]);

        $id = Tasks::createJob($request);
        return \Redirect::to(route("jobs"))->with('success', "Profile updated success.");
    }

    public function run($id)
    {
        $task = Tasks::findOrFail($id);

        if ($task->status == Tasks::RUN)
            $task->content = file_get_contents(storage_path("tmp/log" . $id . ".txt"));
        return view("jobs.run", compact("id", "task"));
    }

    public function run_post(Request $request, $id)
    {
        $msg = Utils::output($request);

        file_put_contents(storage_path("tmp/log" . $id . ".txt"), $msg, FILE_APPEND | LOCK_EX);

        $client = new \Hoa\Websocket\Client(
            new \Hoa\Socket\Client('tcp://127.0.0.1:8889')
        );
        $client->connect();
        $client->send(json_encode([
            "command" => webSocket::BROADCASTIF,
            "jobid" => $id,
            "msg" => $msg
        ]));
        $client->close();
    }
}