<?php

require_once __DIR__.'/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMq{

    //Add into queue of Rabbitmq
    public static function Add_to_RabbitMq($ToEmail,$title,$msg){
         //connection of AMQP
       $connection = new AMQPConnection('127.0.0.1', 5672, 'admin', 'admin');
       $channel = $connection->channel();
    
       //Added into Queue
       $channel->queue_declare('email_queue', false, false, false, false);
    
       //storing inot array
       $data_msg = array('ToEmail' => $ToEmail,'Title' => $title,'Message' => $msg);
    
       //encoded inot JSON
       $data = json_encode($data_msg);
    
       //Creating message object and store that data
       $msg = new AMQPMessage($data, array('delivery_mode' => 2));
       $channel->basic_publish($msg, '', 'email_queue');
    }
}