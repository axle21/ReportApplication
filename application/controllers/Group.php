<?php
class Group extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->database('amti');
        $this->load->model('group_model');
    }

    public function index() {   
        
        if ($this->session->userdata('is_logged')) {
            redirect('main/home');
        }

       else {
            redirect('main/login');
        }
    }

    public function add_group() {

        $action=$_POST['action'];

        if ($action=="deactivate_group") { 

            $group_name=addslashes($_POST['group_name']);
            $this->group_model->deactivate($group_name);
                
            $end="The group has been archived";
            echo $end; 
        }

        if ($action=="activate_group") { 

            $group_name=addslashes($_POST['group_name']);
            $this->group_model->activate($group_name);
                
            $end="The group has been unarchived successfully";
            echo $end;        
        }        
    }

     public function edit() {

            extract($_POST);
            $permissions = array();

            if (isset($save)) {

                $group_id = addslashes($_POST['group_id']);
                $group_name = addslashes($_POST['group_name']);
                $group_description = addslashes($_POST['group_description']);
                $group_name=ucfirst($group_name);
                $group_description=ucfirst($group_description);
                
                if (!empty($_POST['permission_id'])) {

                    foreach ($_POST['permission_id'] as $permission) {
                        $permissions[] = $permission; 
               
                    }

                    $result=$this->group_model->check_group_rec($group_id, $group_name, $group_description);
                    
                    if ($result=="none") {

                        $result=$this->group_model->check_group_permissions($group_id);
                    
                        sort($result);
                        sort($permissions);
                        
                        if ($result==$permissions) {

                            $change=0;
                        }

                        else {$change=1;}
                    }

                    else {$change=1;}

                    if ($change==1) {

                        $result = $this->group_model->edit_check_duplicate_group($group_name, $group_id);
           
                        if ($result == "has") {
                            $alert = '
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <span class="fa fa-exclamation-triangle"></span>
                                                &nbspDuplicate group name has been detected
                                        </div>
                                    </div>
                                </div>
                            ';

                            $this->session->set_flashdata('alert', $alert);
                            redirect('user/check_access?mid=0003');
                        }

                        else {

                            $result = $this->group_model->group_edit($group_name, $group_description, $group_id);
                            $group_id = $result;
                            
                            for ($i = 0; $i < count($permissions); $i++) {
                                
                                $permission_id=$permissions[$i];
                                $result = $this->group_model->group_permissions($group_id, $permission_id);
                            }

                            $alert = '
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 10px;">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <span class="fa fa-check"></span>
                                                &nbspGroup has been updated successfully
                                        </div>
                                    </div>
                                </div>
                            ';

                            $this->session->set_flashdata('alert', $alert);
                            redirect('user/check_access?mid=0003');
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
                        redirect('user/check_access?mid=0003');
                    }
                }

                else {
                    $alert = '
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <span class="fa fa-exclamation-triangle"></span>
                                        &nbspSelect at least one (1) permission
                                </div>
                            </div>
                        </div>
                    ';

                    $this->session->set_flashdata('alert', $alert);
                    redirect('user/check_access?mid=0005&id='.$group_id);
                }     
            }

            if (isset($add)) {

                $group_name = addslashes($_POST['group_name']);
                $group_description = addslashes($_POST['group_description']);
                $group_name=ucfirst($group_name);
                $group_description=ucfirst($group_description);
                
                if (!empty($_POST['permission_id'])) {

                    foreach ($_POST['permission_id'] as $permission) {
                        $permissions[] = $permission; 
                    }

                    $result = $this->group_model->check_duplicate_group($group_name);
           
                    if ($result == "has") {
                        $alert = '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <span class="fa fa-exclamation-triangle"></span>
                                            &nbspDuplicate group name has been detected
                                    </div>
                                </div>
                            </div>
                        ';

                        $this->session->set_flashdata('alert', $alert);
                        redirect('user/check_access?mid=0004');
                    }

                    else {

                        $result = $this->group_model->group_save($group_name, $group_description);
                        $group_id = $result;
                        
                        for ($i = 0; $i < count($permissions); $i++) {

                            $permission_id=$permissions[$i];
                            $result = $this->group_model->group_permissions($group_id, $permission_id);
                        }

                        $alert = '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 10px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <span class="fa fa-check"></span>
                                            &nbspNew group has been added successfully
                                    </div>
                                </div>
                            </div>
                        ';

                        $this->session->set_flashdata('alert', $alert);
                        redirect('user/check_access?mid=0003');

                    }
                }

                else {
                    $alert = '
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <span class="fa fa-exclamation-triangle"></span>
                                        &nbspSelect at least one (1) permission
                                </div>
                            </div>
                        </div>
                    ';

                    $this->session->set_flashdata('alert', $alert);
                    redirect('user/check_access?mid=0004');
                }    
            }      
        }
}