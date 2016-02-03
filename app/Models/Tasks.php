<?php

/**
 * Created by PhpStorm.
 * User: hieunt
 * Date: 2/1/16
 * Time: 2:50 PM
 */
namespace App\Models;

use App\Jobs\runAnsible;
use File;
use Illuminate\Database\Eloquent\Model;
use View;

class Tasks extends Model
{
    protected $table = "tasks";

    const WAIT = 0;
    const RUN = 1;
    const FINISH = 2;


    public static function getRoles()
    {
        return collect(File::directories(storage_path("roles")))->map(function ($name) {
            return str_replace(storage_path("roles/"), "", $name);
        })->reject(function ($name) {
            return ($name == "callback_plugins");
        });
    }

    public function getStatus()
    {
        switch ($this->status) {
            case Tasks::WAIT:
                return "waitting";
            case Tasks::RUN:
                return "running";
            case Tasks::FINISH:
                return "completed";
        }
    }

    public function inventory()
    {
        return $this->hasOne('App\Models\Inventories', "id", "iid");
    }

    public function template()
    {
        return $this->hasOne('App\Models\Templates', "id", "tid");
    }

    public static function createJob($request)
    {
        $inv = Inventories::find($request->iid);
        $job = new Tasks();
        $job->iid = $request->iid;
        $job->tid = $request->tid;
        $job->vars = $request->vars;
        $job->sudo = $request->sudo;
        $job->save();

        $pid = $job->id;

        $vars = json_decode($job->vars);
        file_put_contents(storage_path("roles/inv$pid"), $inv->content);
        file_put_contents(storage_path("roles/yml$pid"), View::make("jobs.yml", compact("job", "pid", "vars"))->render());
        file_put_contents(storage_path("tmp/log" . $pid . ".txt"), "");

        dispatch(new runAnsible($job->id));

        return $job->id;
    }
}