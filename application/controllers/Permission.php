<?php
class Permission extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->database('amti');
        $this->load->model('permission_model');
    }

    public function index() {   
        
        if ($this->session->userdata('is_logged')) {
            redirect('main/home');
        }

       else {
            redirect('main/login');
        }
    }

    public function add_permission() {

        if ($this->session->userdata('is_logged')) {
        
            $action=$_POST['action'];
      
            if ($action=="deactivate_permission") { 

                $permission_name=addslashes($_POST['permission_name']);
                $this->permission_model->deactivate($permission_name);
                    
                $end="The permission has been archived";
                echo $end; 
            }

            if ($action=="activate_permission") { 

                $permission_name=addslashes($_POST['permission_name']);
                $this->permission_model->activate($permission_name);
                    
                $end="The permission has been unarchived successfully";
                echo $end;
            }
        }

        else {
            redirect('main/login');
        }
    }

//---------EDIT---- malinaw naman na edit sya no? :)

    public function edit() {
        
        extract($_POST);
        $modules = array();

        if (isset($save)) {

            $permission_id = addslashes($_POST['permission_id']);
            $permission_name = addslashes($_POST['permission_name']);
            $permission_description = addslashes($_POST['permission_description']);
            $permission_icon = addslashes($_POST['permission_icon']);
            $permission_name=ucfirst($permission_name);
            $permission_description=ucfirst($permission_description);
            
            if (!empty($_POST['module_id'])) {

                foreach ($_POST['module_id'] as $module) {

                    $modules[] = $module; 
                }

                $result=$this->permission_model->check_permission_rec($permission_id, $permission_name, $permission_description, $permission_icon);
                    
                if ($result=="none") {

                    $result=$this->permission_model->check_permission_modules($permission_id);
                
                    sort($result);
                    sort($modules);
                    
                    if ($result==$modules) {

                        $change=0;
                    }

                    else {$change=1;}
                }

                else {$change=1;}

                if ($change==1) {

                    $result= $this->permission_model->edit_check_duplicate_permission($permission_name, $permission_id);
       
                    if ($result == "has") {
                        $alert= '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <span class="fa fa-exclamation-triangle"></span>
                                            &nbspDuplicate permission name has been detected
                                    </div>
                                </div>
                            </div>
                        ';

                        $this->session->set_flashdata('alert', $alert);
                        redirect('user/check_access?mid=0008&id='.$permission_id);
                    }

                    else {

                        $result=$this->permission_model->permission_edit($permission_name, $permission_description, $permission_id, $permission_icon);
                        
                        for ($i = 0; $i < count($modules); $i++) {

                            $module_id=$modules[$i];
                            $result=$this->permission_model->permission_modules($permission_id, $module_id);
                        }

                        $alert= '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 10px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <span class="fa fa-check"></span>
                                            &nbspPermission has been updated successfully
                                    </div>
                                </div>
                            </div>
                        ';

                        $this->session->set_flashdata('alert', $alert);
                        redirect('user/check_access?mid=0006');
                    }
                }

                else {

                    $alert= '
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-warning alert-dismissible" role="alert" style="margin-top: 10px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <span class="fa fa-exclamation-triangle"></span>
                                        &nbspNo change has been made
                                </div>
                            </div>
                        </div>
                    ';

                    $this->session->set_flashdata('alert', $alert);
                    redirect('user/check_access?mid=0006');
                }
            }

            else {

                $alert= '
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <span class="fa fa-exclamation-triangle"></span>
                                    &nbspSelect at least one (1) module
                            </div>
                        </div>
                    </div>
                ';

                $this->session->set_flashdata('alert', $alert);
                redirect('user/check_access?mid=0008&id='.$permission_id);               
            }               
        }

        if (isset($add)) {

            $permission_name=addslashes($_POST['permission_name']);
            $permission_description=addslashes($_POST['permission_description']);
            $permission_name=ucfirst($permission_name);
            $permission_description=ucfirst($permission_description);
            
            if (!empty($_POST['module_id'])) {

                foreach ($_POST['module_id'] as $module) {
                    $modules[] = $module; 
                }

                $result=$this->permission_model->check_duplicate_permission($permission_name);
       
                if ($result == "has") {
                    $alert= '
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <span class="fa fa-exclamation-triangle"></span>
                                        &nbspDuplicate permission name has been detected
                                </div>
                            </div>
                        </div>
                    ';

                    $this->session->set_flashdata('alert', $alert);
                    redirect('user/check_access?mid=0007');
                }

                else {

                    $result=$this->permission_model->permission_save($permission_name, $permission_description);
                    $permission_id=$result;
                    
                    for ($i = 0; $i < count($modules); $i++) {

                        $module_id=$modules[$i];
                        $result=$this->permission_model->permission_modules($permission_id, $module_id);
                    }

                    $alert= '
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 10px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <span class="fa fa-check"></span>
                                        &nbspNew permission has been added successfully
                                </div>
                            </div>
                        </div>
                    ';

                    $this->session->set_flashdata('alert', $alert);
                    redirect('user/check_access?mid=0006');
                }
            }

            else {
                $alert= '
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <span class="fa fa-exclamation-triangle"></span>
                                    &nbspSelect at least one (1) module
                            </div>
                        </div>
                    </div>
                ';

                $this->session->set_flashdata('alert', $alert);
                redirect('user/check_access?mid=0007'); 
            }              
        }           
    }
}