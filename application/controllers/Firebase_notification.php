<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define( 'API_ACCESS_KEY', 'AAAALOQAMkY:APA91bFrihgc8rlTadXw_te4pXlZxMXgD9KCFCKIXWnl5gk9nwenz9DdUUVWK0DkK3CiOy0byFGote9wstwuWtFUfxQCOVa0LKKTICFTo7TtW-Gamb1FAOnlhnBkW1mb6dRZt6xMYto3' );

class Firebase_notification extends CI_Controller {
    public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->model('Notes_Model');
        $this->load->model('User_model');
    }

    public function index()
    {
        echo "Firebase Notification";

        //retrive total number of user
        $total_user = $this->User_model->total_user();

        //retrive total number of Notes
        $total_notes = $this->Notes_Model->total_notes();

        //current date and time
        date_default_timezone_set('Asia/Kolkata');
        $current_date = date("m/d/Y, H:i");

        echo "Current Date:".$current_date."\n";


        foreach($total_user as $user)
        {
            $user_id = $user['id'];
            $firebase_token = $user['Firebase_token'];
            if($firebase_token)
            {
                foreach($total_notes as $notes)
                {
                    if($notes['user_id'] == $user_id)
                    {
                        if($notes['reminder'] == $current_date)
                        {
                            echo "## Success ##";
                            $data = array("to" => $firebase_token,
                            "notification" => array( "title" => $notes['title'], "body" => $notes['Notes'],"icon" => "https://www.google.com/images/icons/product/keep-512.png", "click_action" => "https://localhost:4200/"));                                                                    
                            $data_string = json_encode($data); 

                            echo "The Json Data : ".$data_string; 

                            $headers = array
                            (
                                'Authorization: key=' . API_ACCESS_KEY, 
                                'Content-Type: application/json'
                            );                                                                                 
                                                                                                                                                
                            $ch = curl_init();
                            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );                                                                  
                            curl_setopt( $ch,CURLOPT_POST, true );  
                            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                            curl_setopt( $ch,CURLOPT_POSTFIELDS, $data_string);                                                                  
                                                                                                                                                
                            $result = curl_exec($ch);

                            curl_close ($ch);

                            echo "<p>&nbsp;</p>";
                            echo "The Result : ".$result;
                        }else{
                            echo "** Not Done **";
                        }
                        
                    }
                }
            }
        }
    }

}