<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


class webSocket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    const SETJOBID = 1;
    const BROADCASTIF = 2;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $server = new \Hoa\Websocket\Server(
            new \Hoa\Socket\Server('tcp://127.0.0.1:8889')
        );

        $server->getConnection()->setNodeName('\App\Models\AnsibleNode');

        $server->on('open', function (\Hoa\Event\Bucket $bucket) {
            $this->info('new connection');
            return;
        });
        $server->on('message', function (\Hoa\Event\Bucket $bucket) {
            $data = json_decode($bucket->getData()['message']);

            switch ($data->command) {
                case webSocket::SETJOBID:
                    $node = $bucket->getSource()->getConnection()->getCurrentNode();
                    $node->setJobID($data->jobid);
                    break;
                case webSocket::BROADCASTIF:
                    $this->info($data->jobid);
                    $bucket->getSource()->broadcastIf(function ($node) use ($data) {
                        return ($node->getJobID() == 0 || ($node->getJobID() == $data->jobid));
                    }, $data->msg);
                    break;
                default:
                    $bucket->getSource()->broadcast($data->msg);
            }

            //$this->info('message: ' . json_encode($data));


            return;
        });
        $server->on('close', function (\Hoa\Event\Bucket $bucket) {
            $this->info('connection closed');

            return;
        });

        $server->run();
    }
}
