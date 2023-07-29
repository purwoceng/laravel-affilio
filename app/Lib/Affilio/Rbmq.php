<?php

namespace App\Lib\Affilio;

use Illuminate\Support\Facades\Config;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
class Rbmq
{

    private $connection = null;
    private $channel = null;

    public function __construct()
    {
        try {
            $configs = Config::get('app');
            $rabbitConnection = new AMQPStreamConnection(
                $configs['rabbit_mq_host'],
                $configs['rabbit_mq_port'],
                $configs['rabbit_mq_user'],
                $configs['rabbit_mq_password'],
                $configs['rabbit_mq_vhost']
            );
            $this->connection = $rabbitConnection;
            $this->channel = $rabbitConnection->channel();
        } catch (\Exception $exception) {
        }

    }

    public function updateOrder(int $baleoOrderId, string $baleoStatus)
    {
       try {
            $this->channel->queue_declare('order', false, true, false, false);
            $messageObject = [
                "orderId" => $baleoOrderId,
                "status" => $baleoStatus
            ];

            $msg = new AMQPMessage(json_encode($messageObject));
            $this->channel->basic_publish($msg, '', 'order');
        } catch (\Exception $exception){

       }

    }

    public function __desctruct()
    {
        try {
            $this->connection->close();
            $this->channel->close();
            $this->channel = null;
            $this->connection = null;
        } catch (\Exception $exception){

        }
    }

}
