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

    /**
     * @param int $baleoOrderId
     * @param string $baleoStatus
     * @return void
     */
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

    /**
     * @param int $orderId
     * @param string $username
     * @param int $memberId
     * @return void
     */
    public function createPdf(int $orderId, string $username, int $memberId)
    {
        try {
            $this->channel->queue_declare('create_pdf_order', false, true, false, false);
            $messageObject = [
                "orderId" => $orderId,
                "memberId"=> $memberId,
                "username"=> $username
            ];

            $msg = new AMQPMessage(json_encode($messageObject));
            $this->channel->basic_publish($msg, '', 'create_pdf_order');
        } catch (\Exception $exception){

        }

    }

    /**
     * @param int $memberId
     * @param string $username
     * @param string $year
     * @param string $month
     * @return void
     */
    public function prosesPeringkat(int $memberId, string $username, string $year, string $month)
    {
        try {
            $this->channel->queue_declare('peringkat', false, true, false, false);
            $messageObject = [
                "memberId"=> $memberId,
                "username"=> $username,
                "year" => $year,
                "month" => $month
            ];

            $msg = new AMQPMessage(json_encode($messageObject));
            $this->channel->basic_publish($msg, '', 'peringkat');
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
