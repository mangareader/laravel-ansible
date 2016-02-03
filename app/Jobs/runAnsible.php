<?php

namespace App\Jobs;

use App\Console\Commands\webSocket;
use App\Models\Tasks;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Symfony\Component\Process\ProcessBuilder;

class runAnsible extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    var $job_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($job_id)
    {
        $this->job_id = $job_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo "Run task: #" . $this->job_id, "\n";
        $task = Tasks::find($this->job_id);
        $task->status = Tasks::RUN;
        $task->save();

        $client = new \Hoa\Websocket\Client(
            new \Hoa\Socket\Client('tcp://127.0.0.1:8889')
        );
        $client->setHost('127.0.0.1');
        $client->connect();
        $client->send(json_encode([
            "command" => webSocket::BROADCASTIF,
            "jobid" => $this->job_id,
            "msg" => json_encode(["jid" => $this->job_id, "status" => Tasks::RUN])
        ]));

        $builder = new ProcessBuilder();
        $builder->setPrefix('ansible-playbook');
        $builder->setArguments([
            "-i", "inv" . $this->job_id,
            "yml" . $this->job_id
        ]);
        $builder->setWorkingDirectory(storage_path("roles"));
        $process = $builder->getProcess();

        $process->run();
        //echo $process->getOutput() . "\n";
        $client->send(json_encode([
            "command" => webSocket::BROADCASTIF,
            "jobid" => $this->job_id,
            "msg" => json_encode(["jid" => $this->job_id, "status" => Tasks::FINISH])
        ]));
        $client->close();
        $task->status = Tasks::FINISH;
        $task->content = file_get_contents(storage_path("tmp/log" . $this->job_id . ".txt"));
        $task->save();
        unlink(storage_path("roles/yml" . $this->job_id));
        unlink(storage_path("roles/inv" . $this->job_id));
        unlink(storage_path("tmp/log" . $this->job_id . ".txt"));
        echo "End task: #" . $this->job_id, "\n";
    }
}
