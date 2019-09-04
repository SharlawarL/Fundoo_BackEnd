<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__.'/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;


class Dqueue_mail extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
	}
    public function index()
    {
        //connection AMQP connection
        $connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        
        //creating queue for it
        $channel->queue_declare('email_queue', false, false, false, false);
         
        echo ' * Waiting for messages. To exit press CTRL+C', "\n";
         
        //call that every msg in the queue
        $callback = function($msg){
         
            echo " * Message received", "\n";

            // decoding that data of  user
            $data = json_decode($msg->body, true);

            print_r($data);
         
            //set into formate
            $from = 'from';
            $from_email = 'sharlawar66@gmail.com';
            $to_email = $data['ToEmail'];
            $subject = $data['Title'];
            $message = $data['Message'];
         
            //sending into the SMTP format
            $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                                            ->setUsername('clickytl@gmail.com')
                                            ->setPassword('ytl@12345');
        
            $mailer = new Swift_Mailer($transport);
        
            $message =(new Swift_Message($transport))
                ->setSubject($subject)
                ->setFrom([$from_email => 'Bridgelabz'])
                ->setTo([$to_email => 'Recipient'])
                ->setBody($message, 'text/html');
        
            // genereting the result
            $result = $mailer->send($message);

            echo " * Message was sent", "\n";
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };
         
        $channel->basic_qos(null, 1, null);
        $channel->basic_consume('email_queue', '', false, false, false, false, $callback);
         
         while(count($channel->callbacks)) {
             $channel->wait();
        }

        //redirect the user
       // $this->Rest_API->page_redirect(base_url().'Home/Verify_mail');
    }
    
}
