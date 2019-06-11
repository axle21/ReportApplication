<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Main extends CI_Controller {
        
        public function __construct() {
            
            parent::__construct();
            $this->load->database('amti');
            $this->load->model(array('User_model'));
            $this->load->model('user_model'); // --------------- contains data needed in checking user access
        }

        public function index() {   
        
            if ($this->session->userdata('is_logged')) {
                redirect('main/home');
            } else {
                redirect('main/login');
            }
        }

        public function login() {

            if ($this->session->userdata('is_logged')) {
                redirect('main/home');
            }
            
            else {
                $this->load->view('pages/login');
                $this->load->library('form_validation');
            }
        }

        public function home() {
            
            if ($this->session->userdata('is_logged')) {
                $this->load->view('templates/header');
                $this->load->view('pages/users_page'); 
            }

            else {
                redirect('main/login');
            }
        }

        public function verifyUser() {

            $this->load->model('login_model');

            $this->form_validation->set_rules('users_uname', 'Username', 'required');
            $this->form_validation->set_rules('users_pass', 'Password', 'required');
                
            if ($this->form_validation->run() == true)
            {
                $this->login_model->login();
                    
            }
            else {
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

        public function logout() {

            $this->session->sess_destroy();
            redirect('main/');
        }

        public function change_password() {
            
            $this->load->view('templates/header');
            $this->load->view('pages/change_password');
        }

        public function access_denied() {
            
            if ($this->session->userdata('is_logged')) {

                  $this->load->view('pages/authorization');
            }

            else {
                  redirect('main/logout');
            }
        }
    }
?>
