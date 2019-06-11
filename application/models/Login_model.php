<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model
{
	public function __construct() {

        parent::__construct();
        $this->load->database('amti');
    }
	
	public function login() {

		$users_uname=$this->input->post('users_uname');
		$users_pass=$this->input->post('users_pass');

		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('users_uname',$users_uname);
		$this->db->where('users_pass',md5($users_pass));

		$query = $this->db->get();
		$row = $query->result_array();
		$num_rows=$query->num_rows();
		
		if($num_rows == 1){

            if ($row[0]['users_status']=="active") {

            	$sessions = array(
	                'username' => $row[0]['users_uname'] ,
	                'role' => $row[0]['users_role'] ,
	                'fname' => $row[0]['users_fname'] ,
	                'lname' => $row[0]['users_lname'] ,
	                'status' => $row[0]['users_status'] ,
	                'userid' => $row[0]['users_id'],
	                'empno' => $row[0]['users_empno'],
	                'is_logged' => 1
	            );
	            $this->session->set_userdata($sessions);

	            redirect('main/');
	            
            } else {

            	$alert = '
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
	                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                            <span class="fa fa-exclamation-triangle"></span>
	                                &nbspThis account is currently deactivated
	                        </div>
	                    </div>
	                </div>
	            ';

	            $this->session->set_flashdata('alert', $alert);
	            redirect('main/login');
            }

		} else {

			$alert = '
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <span class="fa fa-exclamation-triangle"></span>
                                &nbspInvalid username or password
                        </div>
                    </div>
                </div>
            ';

            $this->session->set_flashdata('alert', $alert);
            redirect('main/login');
		}	
	} 

	public function login_status($users_uname) {

		$this->db->select('users_uname, users_pass');
		$this->db->from('users');
		$this->db->where('users_uname',$users_uname);
		$this->db->where('users_status','active');

		$query = $this->db->get();
		if($query->num_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}
}

?>