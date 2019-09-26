<?php
header('Access-Control-Allow-Origin: *');
header('Origin: http://localhost:4200');
header('Access-Control-Allow-Methods: POST, GET, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Auth-Token, X-PINGOTHER, Content-Type,X-Requested-With,Access-Control-Allow-Origin, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 86400');
header('Content-Type: application/json'); 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/JWT.php';

class Notes extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->model('Notes_Model');
        //load redis cache
        $this->load->library('redis');
        //load the Doctrine file
        $this->load->library('Doctrine');
    }
    function index()
    {
        //$this->load->view('Home_page');
        $id = '165';
        $Notes = $this->Notes_Model->get_labels_option($id);
        print_r($Notes);

    }

    // function for Creating notes
    function Create_notes(){
        //redis cache
        $redis = $this->redis->config();

        // Getting data from front End
        //$_POST = json_decode(file_get_contents('php://input'),true);
        $Note_data = $this->input->post();
        
        //user id asign to the instance
        $user_token = $Note_data['user_id']; //$this->input->post('user_id');

        //checking that token will into the redius
        if($redis->get($user_token))
        {
            //decode the user id from JWT
            $jwtToken_decode = JWT::decode($user_token, "", array('HS256'));
            $id = (array) $jwtToken_decode;

            // the array value getting from JWT and seperate UserID From the list
            $Note_data['user_id']=$id[0];

            // if the title will be null then user not create any notes
            if($this->input->post('title') != null)
            {
                // inserting into database
                $this->Notes_Model->insertNote($Note_data);

                //return value to the frontend
                $data['success'] = true;
                $data['message'] = 'Notes Created..';
                echo json_encode($data);
            }
        }else{
                //return value to the frontend
                $data['success'] = false;
                $data['message'] = 'Anuthorised User';
                echo json_encode($data);
        }
        
       
    }

    //retriving notes data
    function Get_notes(){
        //redis cache
        $redis = $this->redis->config();

        //getiing datat from the angular
        $token = $this->input->get('User_token', TRUE);
        
        //if the the token prenent then retirve data
        if($redis->get($token))
        {
            //decoding the JWT token
            $jwtToken_decode = JWT::decode($token, "", array('HS256'));
            $id = (array) $jwtToken_decode;
            //getting from database
            $Notes = $this->Notes_Model->get_Notes($id[0]);
            $Json = json_encode($Notes);
            print_r($Json);
        }else{
            //return value to the frontend
            $data['success'] = false;
            $data['message'] = 'Anuthorised User';
            echo json_encode($data);
        }
    }   

    //updating notes
    function Update_notes()
    {
        //geting data from front end
        header('Content-Type: application/json'); 
        $Note_data = $this->input->post();

        $result = $this->Notes_Model->update($Note_data);

        if($result)
        {
            //return value to the frontend
            $data['success'] = true;
            $data['message'] = 'Notes updated..';
            echo json_encode($data);
        }else{
            //return value to the frontend
            $data['success'] = false;
            $data['message'] = 'Error in Notes updation..';
            echo json_encode($data);
        }
    }


    //update reminder date
    function Update_reminderdate()
    {
        //redis cache
        $redis = $this->redis->config();

        header('Content-Type: application/json'); 
        $Note_data = $this->input->post();

        //checking that token will into the redius
        if($redis->get($Note_data['token']))
        {
            $result = $this->Notes_Model->update_reminder($Note_data);

            if($result)
            {
                //return value to the frontend
                $data['success'] = true;
                $data['message'] = 'Remionder will be updated...';
                echo json_encode($data);
            }else{
                //return value to the frontend
                $data['success'] = false;
                $data['message'] = 'Error in updeting reminder...';
                echo json_encode($data);
            }
        }

    }

    //update notes background color
    function Update_color()
    {
        //redis cache
        $redis = $this->redis->config();

        header('Content-Type: application/json'); 
        $Note_data = $this->input->post();

        //checking that token will into the redius
        if($redis->get($Note_data['token']))
        {
            $result = $this->Notes_Model->update_color($Note_data);

            if($result)
            {
                //return value to the frontend
                $data['success'] = true;
                $data['message'] = 'Color will be changed..';
                echo json_encode($data);
            }else{
                //return value to the frontend
                $data['success'] = false;
                $data['message'] = 'Error in error in changing color..';
                echo json_encode($data);
            }
        }

    }
    //update indexing change on drag and drop
    function Update_notesindex()
    {
        header('Content-Type: application/json'); 
        $Note_data = $this->input->post();

    }

    //add to trash
    function Add_trash()
    {
        //redis cache
        $redis = $this->redis->config();

        header('Content-Type: application/json'); 
        $Note_data = $this->input->post();

        //checking that token will into the redius
        if($redis->get($Note_data['token']))
        {
            $result = $this->Notes_Model->is_trash($Note_data['note_id']);

            if($result)
            {
                //return value to the frontend
                $data['success'] = true;
                $data['message'] = 'Notes are added into trash..';
                echo json_encode($data);
            }else{
                //return value to the frontend
                $data['success'] = false;
                $data['message'] = 'Failed to add into trash';
                echo json_encode($data);
            }
        }
        
    }

    //restore to trash
    function Restore_trash()
    {
        //redis cache
        $redis = $this->redis->config();

        header('Content-Type: application/json'); 
        $Note_data = $this->input->post();

        //checking that token will into the redius
        if($redis->get($Note_data['token']))
        {
            $result = $this->Notes_Model->restore_trash($Note_data['note_id']);

            if($result)
            {
                //return value to the frontend
                $data['success'] = true;
                $data['message'] = 'Notes will  be restored from trash..';
                echo json_encode($data);
            }else{
                //return value to the frontend
                $data['success'] = false;
                $data['message'] = 'Error in Notes trash..';
                echo json_encode($data);
            }
        }
        
    }

    //Delete to trash
    function Delete_trash()
    {
        //redis cache
        $redis = $this->redis->config();

        header('Content-Type: application/json'); 
        $Note_data = $this->input->post();

        //checking that token will into the redius
        if($redis->get($Note_data['token']))
        {
            $result = $this->Notes_Model->delete_trash($Note_data['note_id']);

            if($result)
            {
                //return value to the frontend
                $data['success'] = true;
                $data['message'] = 'Notes will be permentntly deleted...';
                echo json_encode($data);
            }else{
                //return value to the frontend
                $data['success'] = false;
                $data['message'] = 'Error in Notes deletion..';
                echo json_encode($data);
            }
        }
        
    }

    //add to archive
    function Add_archive()
    {
        //redis cache
        $redis = $this->redis->config();

        header('Content-Type: application/json'); 
        $Note_data = $this->input->post();

        //checking that token will into the redius
        if($redis->get($Note_data['token']))
        {
            $result = $this->Notes_Model->is_archive($Note_data['note_id']);

            if($result)
            {
                //return value to the frontend
                $data['success'] = true;
                $data['message'] = 'Notes will be added in Archive..';
                echo json_encode($data);
            }else{
                //return value to the frontend
                $data['success'] = false;
                $data['message'] = 'Error in Notes Archive..';
                echo json_encode($data);
            }
        }
        
    }

    //add to archive
    function Get_archive()
    {
        //redis cache
        $redis = $this->redis->config();

        header('Content-Type: application/json'); 
        $Note_data = $this->input->post();

        //checking that token will into the redius
        if($redis->get($Note_data['token']))
        {
            $result = $this->Notes_Model->get_archive($Note_data['note_id']);

            if($result)
            {
                //return value to the frontend
                $data['success'] = true;
                $data['message'] = 'Notes will be restored from archive..';
                echo json_encode($data);
            }else{
                //return value to the frontend
                $data['success'] = false;
                $data['message'] = 'Error in Notes restoring from archive..';
                echo json_encode($data);
            }
        }
    }

    //add to archive
    function Add_lebel()
    {
        //redis cache
        $redis = $this->redis->config();

        header('Content-Type: application/json'); 
        $lebel_data = $this->input->post();

        //checking that token will into the redius
        if($redis->get($lebel_data['token']))
        {
            if($lebel_data['lebel'] != '')
            {
                // decoding JWT Token
                $jwtToken_decode = JWT::decode($lebel_data['token'], "", array('HS256'));
                $id = (array) $jwtToken_decode;
                $lebel['lebel'] = $lebel_data['lebel'];
                $lebel['user_id'] = $id[0];
                $result = $this->Notes_Model->add_lebel($lebel);

                if($result)
                {
                    //return value to the frontend
                    $data['success'] = true;
                    $data['message'] = 'label will be created..';
                    echo json_encode($data);
                }else{
                    //return value to the frontend
                    $data['success'] = false;
                    $data['message'] = 'Error in label creation..';
                    echo json_encode($data);
                }
            }
        }
        
    }

    // deleting lebels
    function Delete_lebel()
    {
        //redis cache
        $redis = $this->redis->config();

        header('Content-Type: application/json'); 
        $lebel_data = $this->input->post();

        //checking that token will into the redius
        if($redis->get($lebel_data['token']))
        {
                $id = $lebel_data['lebel'];
                $result = $this->Notes_Model->delete_lebel($id);

                if($result)
                {
                    //return value to the frontend
                    $data['success'] = true;
                    $data['message'] = 'label will be deleted successfully..';
                    echo json_encode($data);
                }else{
                    //return value to the frontend
                    $data['success'] = false;
                    $data['message'] = 'Error in label deletion..';
                    echo json_encode($data);
                }
            }
    }

    //getting that labels
    function Get_lebels(){
        //redis cache
        $redis = $this->redis->config();

        //getiing datat from the angular
        $token = $this->input->get('User_token', TRUE);
        
        //if the the token prenent then retirve data
        if($redis->get($token))
        {
            $jwtToken_decode = JWT::decode($token, "", array('HS256'));
            $id = (array) $jwtToken_decode;
            //getting from database
            //$Notes = $this->Notes_Model->get_labels($id[0]);
            $Notes = $this->Notes_Model->with('lebel_id');
            $Json = json_encode($Notes);
            print_r($Json);
        }else{
            //return value to the frontend
            $data['success'] = false;
            $data['message'] = 'Anuthorised User';
            echo json_encode($data);
        }
    }   

    //add to lebel added to notes
    function Add_lebelnotes()
    {
        //redis cache
        $redis = $this->redis->config();

        header('Content-Type: application/json'); 
        $lebel_data = $this->input->post();

        //checking that token will into the redius
        if($redis->get($lebel_data['token']))
        {
            // decoding JWT Token
            $jwtToken_decode = JWT::decode($lebel_data['token'], "", array('HS256'));
            $id = (array) $jwtToken_decode;
            $lebel['user_id'] = $id[0];
            $lebel['note_id'] = $lebel_data['note_id'];
            $lebel['lebel_id'] = $lebel_data['lebel_id'];
            $result = $this->Notes_Model->add_lebelnotes($lebel);

            if($result)
            {
                //return value to the frontend
                $data['success'] = true;
                $data['message'] = 'label will be added to notes..';
                echo json_encode($data);
            }else{
                //return value to the frontend
                $data['success'] = false;
                $data['message'] = 'Error in label creation..';
                echo json_encode($data);
            }
        }
        
    }

    //getting that labels
    function Get_lebelsnote(){
        //redis cache
        $redis = $this->redis->config();

        //getiing datat from the angular
        $token = $this->input->get('User_token', TRUE);
        
        //if the the token prenent then retirve data
        if($redis->get($token))
        {
            $jwtToken_decode = JWT::decode($token, "", array('HS256'));
            $id = (array) $jwtToken_decode;
            //getting from database
            $Notes = $this->Notes_Model->get_labelsnote($id[0]);
            $Json = json_encode($Notes);
            print_r($Json);
        }else{
            //return value to the frontend
            $data['success'] = false;
            $data['message'] = 'Anuthorised User';
            echo json_encode($data);
        }
    } 

    //removing lebel
    function Remove_lebel()
    {
         //redis cache
         $redis = $this->redis->config();

         header('Content-Type: application/json'); 
         $lebel_data = $this->input->post();
 
         //checking that token will into the redius
         if($redis->get($lebel_data['token']))
         {
             $result = $this->Notes_Model->remove_lebel($lebel_data['id']);
 
             if($result)
             {
                 //return value to the frontend
                 $data['success'] = true;
                 $data['message'] = 'label will be removed from Notes..';
                 echo json_encode($data);
             }else{
                 //return value to the frontend
                 $data['success'] = false;
                 $data['message'] = 'Error in label operation...';
                 echo json_encode($data);
             }
         }
    }
    //update lebel
    function Update_lebel()
    {
         //redis cache
         $redis = $this->redis->config();

         header('Content-Type: application/json'); 
         $lebel_data = $this->input->post();
         print_r($lebel_data);
 
         //checking that token will into the redius
         if($redis->get($lebel_data['token']))
         {
             $result = $this->Notes_Model->update_lebel($lebel_data);
 
             if($result)
             {
                 //return value to the frontend
                 $data['success'] = true;
                 $data['message'] = 'label will be updated..';
                 echo json_encode($data);
             }else{
                 //return value to the frontend
                 $data['success'] = false;
                 $data['message'] = 'Error in label operation...';
                 echo json_encode($data);
             }
         }
    }

}
