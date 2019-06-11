<?php
class Module extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->database('amti');
        $this->load->model('module_model');
    }

    public function index() {   
        
        if ($this->session->userdata('is_logged')) {
            redirect('main/home');
        }

       else {
            redirect('main/login');
        }
    }

    public function add_module() {

        $action=$_POST['action'];

        if ($action=="deactivate_module") { 

            $module_name=addslashes($_POST['module_name']);
            $this->module_model->deactivate($module_name);
                
            $end="The module has been archived";
            echo $end; 
        }

        if ($action=="activate_module") { 

            $module_name=addslashes($_POST['module_name']);
            $this->module_model->activate($module_name);
                
            $end="The module has been unarchived successfully";
            echo $end;    
        }       
    }

    public function edit() {

        extract($_POST);

        if (isset($save)) {

            $module_id=addslashes($_POST['module_id']);
            $module_name=addslashes($_POST['module_name']);
            $module_url=addslashes($_POST['module_url']);
            $module_name=ucfirst($module_name);
            $module_level=1;

            if (!empty($_POST['module_level'])) {

                $module_level=2;
            }

            if (substr_count($module_url, '/') != 2) {

                $alert = '
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <span class="fa fa-exclamation-triangle"></span>
                                    &nbspRequired Field. Url must be specified (Controller/class/view)
                            </div>
                        </div>
                    </div>
                ';

                $this->session->set_flashdata('alert', $alert);
                redirect('user/check_access?mid=0011&id='.$module_id);
            }

            else {

                $result=$this->module_model->check_module_name($module_name, $module_id);
       
                if ($result=="has") {

                    $alert= '
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <span class="fa fa-exclamation-triangle"></span>
                                        &nbspDuplicate module name has been detected
                                </div>
                            </div>
                        </div>
                    ';

                    $this->session->set_flashdata('alert', $alert);
                    redirect('user/check_access?mid=0011&id='.$module_id);
                }

                else {

                    $result=$this->module_model->check_module_url($module_url, $module_id);

                    if ($result=="has") {

                        $alert= '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <span class="fa fa-exclamation-triangle"></span>
                                            &nbspDuplicate module url has been detected
                                    </div>
                                </div>
                            </div>
                        ';

                        $this->session->set_flashdata('alert', $alert);
                        redirect('user/check_access?mid=0011&id='.$module_id);
                    }

                    else { 

                        $result=$this->module_model->module_edit($module_name, $module_url, $module_id, $module_level);
                    
                        $alert= '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 10px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <span class="fa fa-check"></span>
                                            &nbspModule has been updated successfully
                                    </div>
                                </div>
                            </div>
                        ';

                        $this->session->set_flashdata('alert', $alert);
                        redirect('user/check_access?mid=0009');
                    }
                }
            }      
        }

        if(isset($add)) {

            $module_name=addslashes($_POST['module_name']);
            $module_url=addslashes($_POST['module_url']);
            $module_name=ucfirst($module_name);
            $module_level=1;

            if (!empty($_POST['module_level'])) {

                $module_level=2;
            }

            if (substr_count($module_url, '/') != 2) {

                $alert= '
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <span class="fa fa-exclamation-triangle"></span>
                                    &nbspRequired Field. Url must be specified (Controller/class/view)
                            </div>
                        </div>
                    </div>
                ';

                $this->session->set_flashdata('alert', $alert);
                redirect('user/check_access?mid=0010');
            }

            else {

                $result=$this->module_model->check_duplicate_module_name($module_name);
       
                if ($result=="has") {

                    $alert= '
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <span class="fa fa-exclamation-triangle"></span>
                                        &nbspDuplicate module name has been detected
                                </div>
                            </div>
                        </div>
                    ';

                    $this->session->set_flashdata('alert', $alert);
                    redirect('user/check_access?mid=0010');
                }

                else {

                    $result=$this->module_model->check_duplicate_module_url($module_url);

                    if ($result == "has") {

                        $alert= '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <span class="fa fa-exclamation-triangle"></span>
                                            &nbspDuplicate module url has been detected
                                    </div>
                                </div>
                            </div>
                        ';

                        $this->session->set_flashdata('alert', $alert);
                        redirect('user/check_access?mid=0010');
                    }

                    else { 

                        $result=$this->module_model->module_save($module_name, $module_url, $module_level);                    

                        $alert= '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 10px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <span class="fa fa-check"></span>
                                            &nbspNew module has been added successfully
                                    </div>
                                </div>
                            </div>
                        ';

                        $this->session->set_flashdata('alert', $alert);
                        redirect('user/check_access?mid=0009');
                    }
                }
            }
        }   
    }
}