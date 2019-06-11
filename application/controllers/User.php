<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct() {

        parent::__construct();
        $this->load->database('amti');
        $this->load->model('user_model'); // -------------------- contains data needed in checking user access
    }

    public function index() {   
        
        if ($this->session->userdata('is_logged')) {
            redirect('main/home');
        }

       else {
            redirect('main/login');
        }
    }

    public function register() {

        if ($this->session->userdata('is_logged')) {    

            extract($_POST);

            $empno=addslashes($_POST['users_empno']);
            $empno = substr($empno, 0, 8);
            $username=addslashes($_POST['users_uname']);
            $firstname=addslashes($_POST['users_fname']);
            $lastname=addslashes($_POST['users_lname']);
            $email=addslashes($_POST['users_email']);
            $group_id=addslashes($_POST['group_id']);
            $additional_permissions=array();
            $additional_modules=array();
            $sales_reps=array();

            if (isset($submit1)) {  // -------------------------------------------- add new user account

                if (!empty($_POST['permission_id'])) {

                    foreach ($_POST['permission_id'] as $permission) {
                                            
                        $additional_permissions[]=$permission; 
                    } 
                }

                if (!empty($_POST['module_id'])) {

                    foreach ($_POST['module_id'] as $module) {
                                            
                        $additional_modules[]=$module; 
                    }
                }

                $result1=$this->user_model->check_duplicate_empno($empno);
                    
                if (ctype_digit($empno)) {
               
                    if ($result1=="has") {

                        $alert= '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <span class="fa fa-exclamation-triangle"></span>
                                            &nbspInvalid Entry. Employee Number already exists
                                    </div>
                                </div>
                            </div>
                        ';

                        $this->session->set_flashdata('alert', $alert);
                        redirect('user/check_access?mid=0002');
                    }

                    else {

                        $result2=$this->user_model->check_duplicate_username($username);

                        if ($result2=="has") {

                            $alert= '
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <span class="fa fa-exclamation-triangle"></span>
                                                &nbspInvalid Entry. Username already exists  
                                        </div>
                                    </div>
                                </div>
                            ';

                            $this->session->set_flashdata('alert', $alert);
                            redirect('user/check_access?mid=0002');
                        }
                        
                        else {

                            $this->user_model->add_user($empno, $username, $firstname, $lastname, $email, $group_id);

                            $user_uname=$username;
                            $result=$this->user_model->check_user_id($user_uname);
                            $userid=$result;

                            $result=$this->user_model->delete_salesrep($userid); 

                            if ($group_id != "0002") {  //---------------------------- group_id = "user"

                                for ($i=0; $i < count($additional_permissions); $i++) {

                                    $permission_id=$additional_permissions[$i];
                                    $result=$this->user_model->set_additional_permissions($permission_id, $userid);
                                }

                                for ($i=0; $i < count($additional_modules); $i++) {
                    
                                    $module_id=$additional_modules[$i];
                                    $result=$this->user_model->set_additional_modules($module_id, $userid); 
                                }

                                if ($group_id == "0012") {  //--------------------------- group_id = "sales"

                                    foreach ($_POST['salesselect'] as $sales_id) {
                                        
                                        $result=$this->user_model->set_salesrep($userid, $sales_id); 
                                    }
                                }
                            }

                            $alert= '
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 10px;">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <span class="glyphicon glyphicon-ok"></span>
                                                &nbspNew user has been added successfully &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspUsername: ' .strtoupper($users_uname) .',&nbsp&nbspPassword: password@123
                                        </div>
                                    </div>
                                </div>
                            ';

                            $this->session->set_flashdata('alert', $alert);
                            redirect('user/check_access?mid=0001');
                        }
                    } 
                }

                else {

                    $alert= '
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <span class="fa fa-exclamation-triangle"></span>
                                        &nbspInvalid Entry. Employee number consists of numerical values only
                                </div>
                            </div>
                        </div>
                    ';

                    $this->session->set_flashdata('alert', $alert);
                    redirect('user/check_access?mid=0002');
                }
            }

            if (isset($submit2)) {  // -------------------- edit user record

                $userid=addslashes($_POST['user_id']);

                if (!empty($_POST['permission_id'])) {

                    foreach ($_POST['permission_id'] as $permission) {
                                            
                        $additional_permissions[]=$permission; 
                    } 
                }

                if (!empty($_POST['module_id'])) {

                    foreach ($_POST['module_id'] as $module) {
                                            
                        $additional_modules[]=$module; 
                    }
                }

                if (!empty($_POST['salesselect'])) {

                    foreach ($_POST['salesselect'] as $sales) {
                                            
                        $sales_reps[]=$sales; 
                    }
                }

                // check for changes in new entry ------------------------------------- START

                $result=$this->user_model->check_account($empno, $username, $firstname, $lastname, $email, $group_id);
                 
                if ($result=="none") {

                    $user_id=$userid;
                    $result=$this->user_model->check_user_permissions($user_id);

                    sort($result);
                    sort($additional_permissions);
                    
                    if ($result==$additional_permissions) {

                        $result=$this->user_model->check_user_modules($user_id);
                    
                        sort($result);
                        sort($additional_modules);
                        
                        if ($result==$additional_modules) {
                            $result=$this->user_model->search_user_salesrep($userid);
                    
                            sort($result);
                            sort($sales_reps);
                            
                            if ($result==$sales_reps) {

                                $change=0;
                            }

                            else {$change=1;}
                        }

                        else {$change=1;}
                    }

                    else {$change=1;}
                }

                else {$change=1;}

                // check for changes in new entry ------------------------------------------- END

                if ($change==1) {

                    $result1=$this->user_model->check_empno($empno, $userid);

                    if (ctype_digit($empno)) {
                   
                        if ($result1=="has") {

                            $alert= '
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <span class="fa fa-exclamation-triangle"></span>
                                                &nbspInvalid Entry. Employee Number already exists.
                                        </div>
                                    </div>
                                </div>
                            ';

                            $this->session->set_flashdata('alert', $alert);
                            redirect('user/check_access?mid=0012&id='.$userid);
                        }

                        else {

                            $result2=$this->user_model->check_username($userid, $username);

                            if ($result2=="has") {

                                $alert= '
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <span class="fa fa-exclamation-triangle"></span>
                                                    &nbspInvalid Entry. Username already exists
                                            </div>
                                        </div>
                                    </div>
                                ';

                                $this->session->set_flashdata('alert', $alert);
                                redirect('user/check_access?mid=00012&id='.$userid);
                            }
                            
                            else {

                                $this->user_model->edit($empno, $username, $firstname, $lastname, $email, $userid, $group_id);
                                $result=$this->user_model->delete_salesrep($userid); 

                                if ($group_id != "0002") {   //------------------------ group_id = "user"

                                    for ($i=0; $i<count($additional_permissions); $i++) {

                                        $permission_id=$additional_permissions[$i];
                                        $result=$this->user_model->set_additional_permissions($permission_id, $userid);
                                    }

                                    for ($i=0; $i<count($additional_modules); $i++) {
                        
                                        $module_id=$additional_modules[$i];
                                        $result=$this->user_model->set_additional_modules($module_id, $userid); 
                                    }

                                    if ($group_id == "0012" || $group_id == "0019"  || $group_id == "0022") {  //---------------------- group_id = "sales"

                                        foreach ($_POST['salesselect'] as $sales_id) {
                                            
                                            $result=$this->user_model->set_salesrep($userid, $sales_id); 
                                        }
                                    }
                                }
                                
                                $alert= '
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 10px;">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <span class="glyphicon glyphicon-ok"></span>
                                                    &nbspUser account has been edited successfully
                                            </div>
                                        </div>
                                    </div>
                                ';

                                $this->session->set_flashdata('alert', $alert);
                                redirect('user/check_access?mid=0001');
                            }
                        } 
                    }

                    else {

                        $alert= '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <span class="fa fa-exclamation-triangle"></span>
                                            &nbspInvalid Entry. Employee number consists of numerical values only
                                    </div>
                                </div>
                            </div>
                        ';

                        $this->session->set_flashdata('alert', $alert);
                        redirect('user/check_access?mid=0012&id='.$userid);
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
                    redirect('user/check_access?mid=0001');
                }
            }

            if (isset($submit3)) {   // ----------------------------------------- reset password

                $user_id=addslashes($_POST['user_id']);
                $user_uname=addslashes($_POST['username']);
                $this->user_model->reset_password($user_id);

                $alert= '
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 10px;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <span class="glyphicon glyphicon-ok"></span>
                                    &nbspPassword has been reset successfully&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspUsername: ' .strtoupper($user_uname) .',&nbsp&nbspPassword: password@123
                            </div>
                        </div>
                    </div>
                ';

                $this->session->set_flashdata('alert', $alert);
                redirect('user/check_access?mid=0001');
            }
        }

        else {

            $this->load->view('pages/login');
            $this->load->library('form_validation');
        }  
    }

    public function edit() {

        extract($_POST);

        if (isset($save_password)) {

            $user_id=addslashes($_POST['user_id']);
            $user_password=addslashes($_POST['user_password']);
            $password_old=addslashes($_POST['password_old']);
            $password_new=addslashes($_POST['password_new']);
            $password_confirm=addslashes($_POST['password_confirm']);

            if (md5($password_old)!=$user_password) {

                $alert= '
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <span class="fa fa-exclamation-triangle"></span>
                                    &nbspInvalid Entry. The password you have entered does not match with your current password
                            </div>
                        </div>
                    </div>
                ';

                $this->session->set_flashdata('alert', $alert);
                redirect('main/change_password');
            }

            else {

                if ($password_new==$password_old) {

                    $alert= '
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <span class="fa fa-exclamation-triangle"></span>
                                        &nbspInvalid Entry. New password cannot be same with your current password
                                </div>
                            </div>
                        </div>
                    ';

                    $this->session->set_flashdata('alert', $alert);
                    redirect('main/change_password');
                }

                else {

                    if ($password_new!=$password_confirm) {

                        $alert= '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <span class="fa fa-exclamation-triangle"></span>
                                           &nbspInvalid Entry. Password confirmation does not match with the new password
                                    </div>
                                </div>
                            </div>
                        ';

                        $this->session->set_flashdata('alert', $alert);
                        redirect('main/change_password');
                    }

                    else { 

                        if (strlen($password_new)<6) {  // -------- string (password) length must be not less than 6 characters

                            $alert= '
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 10px;">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <span class="fa fa-exclamation-triangle"></span>
                                               &nbspInvalid Entry. New password must not be less than six (6) characters
                                        </div>
                                    </div>
                                </div>
                            ';

                            $this->session->set_flashdata('alert', $alert);
                            redirect('main/change_password');
                        }

                        else { 
                            
                            $result=$this->user_model->change_password($user_id, $password_new);
                            $this->session->sess_destroy();

                            $alert= '
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 10px;">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <span class="fa fa-check"></span>
                                                &nbspNew password has been saved successfully
                                        </div>
                                    </div>
                                </div>
                            ';

                            $this->session->set_flashdata('alert', $alert);
                            $this->load->view('pages/login');
                        }
                    }
                }
            }                   
        }
    }

    public function user_data_submit() {

        if ($this->session->userdata('is_logged')) {
            
            $action=$_POST['action'];

            if ($action=="deactivate_account") { 

                $empno=addslashes($_POST['empno']);
                $this->user_model->deactivate($empno);
                    
                $end="The account has been deactivated";
                echo $end;             
            }

            if ($action=="activate_account") { 

                $empno=addslashes($_POST['empno']);
                $this->user_model->activate($empno);
                    
                $end="The account has been activated successfully";
                echo $end;         
            }

            if ($action=="group_retrieve") {
                
                $result=$this->user_model->groups();

                $groups=array();                        
                foreach ($result as $group) {
                    
                    $groups[]=array(
                        'id' => $group['id'],
                        'name' => $group['name']
                    );
                }

                echo json_encode($groups);
            }

            if ($action=="permission_retrieve") {

                $group_id=addslashes($_POST['group_id']);
                $result=$this->user_model->permissions($group_id);

                $permissions=array();
                foreach ($result as $permission) {    

                    $permissions[]=$permission['permission'];
                }
                   
                echo json_encode($permissions);
            }

             if ($action=="additional_permission_retrieve") {

                $user_id=addslashes($_POST['user_id']);
                $result=$this->user_model->check_permission_2($user_id);  // Check permissions asigned to specified user id

                $permissions=array();
                foreach ($result as $permission) {    

                    $permissions[]=$permission['permission_id'];
                }
                   
                echo json_encode($permissions);
            }

            if ($action=="permissions_list_retrieve") {

                $result=$this->user_model->permissions_list();

                $permissions_list=array();                        
                foreach ($result as $permission) {
                    
                    $permissions_list[] =array(
                        'id' => $permission['id'],
                        'name' => $permission['name']
                    );
                }
    
                echo json_encode($permissions_list);
            }

            if ($action=="modules_retrieve") {

                $permission_id=addslashes($_POST['permission_id']);
                $result=$this->user_model->modules($permission_id);

                $modules=array();
                foreach ($result as $module) { 

                    $modules[]=$module['module']; 
                }
                       
                echo json_encode($modules);
            }

            if ($action=="additional_modules_retrieve") {

                $user_id=addslashes($_POST['user_id']);
                $result=$this->user_model->check_additional_module($user_id);

                $modules=array();
                foreach ($result as $module) { 

                    $modules[]=$module['module_id']; 
                }
                      
                echo json_encode($modules);
            }

            if ($action=="modules_list_retrieve") {

                $result=$this->user_model->modules_list();

                $modules_list=array();                        
                foreach ($result as $module) {
                    
                    $modules_list[]=array(
                        'id' => $module['id'],
                        'name' => $module['name']
                    );
                }
                    
                echo json_encode($modules_list);
            }

            if ($action=="search_data") {

                $search=addslashes($_POST['search']);
                $result=$this->user_model->search_data($search);

                $data=array();                        
                foreach ($result as $record) {
                    
                    $data[]=array(
                        'empno' => $record['empno'],
                        'fname' => $record['fname'],
                        'lname' => $record['lname'],
                        'department' => $record['department'],
                        'email' => $record['email'],
                        'full' => $record['full']
                    );
                }
                                
                echo json_encode($data);
            }

            if ($action=="search_sales") {

                $search=addslashes($_POST['search']);
                $result=$this->user_model->search_sales($search);

                $data=array();                        
                foreach ($result as $record) {
                    
                    $data[]=array(
                        'id' => $record['id'],
                        'name' => $record['name'],
                        'unit' => $record['unit'],
                        'manager' => $record['manager'],
                        'salesrep' => $record['salesrep'],
                        'branch' => $record['branch']
                    );
                }
                                
                echo json_encode($data);
            }

            if ($action=="search_sales_list") {

                $search=addslashes($_POST['search']);
                $result=$this->user_model->search_sales_list($search);

                $data=array();                        
                foreach ($result as $record) {
                    
                    $data[]=array(
                        'id' => $record['id'],
                        'name' => $record['name'],
                        'unit' => $record['unit'],
                        'manager' => $record['manager'],
                        'salesrep' => $record['salesrep']
                    );
                }
                                
                echo json_encode($data);
            }

            if ($action=="search_user_salesrep_id") {

                $userid=addslashes($_POST['userid']);
                $result=$this->user_model->search_user_salesrep_id($userid);

                $data=array();                        
                foreach ($result as $record) {
                    
                    $data[]=array(
                        'salesrep' => $record['salesrep']
                    );
                }
                                
                echo json_encode($data);
            }

            if ($action=="search_salesrep") {   // Search salesrep id's based on user's input

                $search=addslashes($_POST['search']);
                $result=$this->user_model->search_salesrep($search);

                $data=array();                        
                foreach ($result as $record) {
                    
                    $data[]=array(
                        'id' => $record['id'],
                        'name' => $record['name'],
                        'unit' => $record['unit'],
                        'manager' => $record['manager'],
                        'salesrep' => $record['salesrep'],
                        'branch' => $record['branch']
                    );
                }
                                
                echo json_encode($data);
            }

            if ($action=="search_manager_salesrep_id") {    // Search salesrep id's assigned to salesmanager's account

                $fname=addslashes($_POST['fname']);
                $lname=addslashes($_POST['lname']);
                $result=$this->user_model->search_manager_salesrep_id($fname, $lname);

                $data=array();                        
                foreach ($result as $record) {
                    
                    $data[]=array(
                        'salesrep' => $record['salesrep']
                    );
                }
                                
                echo json_encode($data);
            }

           if ($action=="search_subinventory") { // Search subinventory code from mtl_secondary_inventories table

               // $search=addslashes($_POST['search']);
                $result=$this->user_model->search_subinventory();

                                     
                foreach ($result as $record) {
                    
                    $data[]=array(
                        'subinventory' => $record['subinventory'],
                        'description' => $record['description']

                    );
                }
                                
                echo json_encode($data);
            }

            if ($action=="search_customer") {   //  Search customer from amti_cust_bill_to table in oracle database
                $salesrep_id=addslashes($_POST['salesrep_id']);
                $result=$this->user_model->search_customer($salesrep_id);

                // $data=array();                        
                foreach ($result as $record) {
                    
                    $data[]=array(
                        'customer' => $record['customer'],
                        'accountmanager' => $record['accountmanager']
            

                    );

                }
                                
                echo json_encode($data);
            }

            if ($action=="search_customer_group") {   //  Search customer from amti_cust_bill_to table in oracle database
                $salesrep_id=addslashes($_POST['salesrep_id']);
                $group=addslashes($_POST['group']);
                $result=$this->user_model->search_customer_group($salesrep_id,$group);

                // $data=array();                        
                foreach ($result as $record) {
                    
                    $data[]=array(
                        'customer' => $record['customer'],
                        'accountmanager' => $record['accountmanager']
                    );

                }
                                
                echo json_encode($data);
            }


               if ($action=="search_item") { // Search searchitem code from ITEM table

                //$search=addslashes($_POST['search']);
                $result=$this->user_model->search_item();

                $data=array();                        
                foreach ($result as $record) {
                    
                    $data[]=array(
                        'item' => $record['item'],
                        'description' => $record['description']
                    );
                }
                                
                echo json_encode($data);
            }

            if ($action=="search_vendor") { // Search Vendor name from PO.Vendors table

                
                $result=$this->user_model->search_vendor();

                $data=array();                        
                foreach ($result as $record) {
                    
                    $data[]=array(
                        'vendor_name' => $record['vendor_name']
            
                    );
                }
                                
                echo json_encode($data);
            }


        }

        else {

            $this->load->view('pages/login');
            $this->load->library('form_validation');
        }   
    }

    public function check_access() {

        if ($this->session->userdata('is_logged')) {

            $user_uname=$this->session->userdata('username');
            $module_id1=array();
            $module_id2=addslashes($_GET['mid']); // ----------------- module id from modules_list table 

            // -------------- check permissions under group

                $result=$this->user_model->check_user_id($user_uname);

                if ($result!="none") {

                    $user_id=$result;
                    $result=$this->user_model->check_group_archive($user_id);

                    if ($result!="none") {
                    
                        $group_id=$result;
                        $result=$this->user_model->check_permission_1($group_id); //Check permissions under specified group id

                        if ($result!="none") {
                            
                            foreach ($result as $id) {
                                
                                $permission_id=$id['permission_id'];
                                $result=$this->user_model->check_permission_archive($permission_id);

                                $result2=$this->user_model->check_module($permission_id);
                                foreach ($result2 as $id2) {
                                
                                    $module_id=$id2['module_id'];
                                    $result3=$this->user_model->check_module_archive($module_id);

                                    foreach ($result3 as $id3) {
                            
                                        $module_id1[]=$id3['module_id'];
                                    }                           
                                }
                            }                                
                        }

                        else {}
                    }

                    else {}
                }

                else {}

                // ---------------------------- check permissions_additional table

                $result=$this->user_model->check_user_id($user_uname);

                if ($result!="none") {

                    $user_id=$result;
                    $result=$this->user_model->check_permission_2($user_id); // -- Check permissions assigned to specified user id

                    if ($result!="none") {
                                
                        foreach ($result as $id) {
                                    
                            $permission_id=$id['permission_id'];
                            $result=$this->user_model->check_permission_archive($permission_id);

                            $result2=$this->user_model->check_module($permission_id);
                            foreach ($result2 as $id2) {
                                    
                                $module_id=$id2['module_id'];
                                $result3=$this->user_model->check_module_archive($module_id);

                                foreach ($result3 as $id3) {
                                    
                                    $module_id1[]=$id3['module_id'];                                            
                                }                                        
                            }
                        }                          
                    }

                    else {}
                }

                else {}

                //-------------------------------------------- check permissions_additional table

                $result=$this->user_model->check_user_id($user_uname);

                if ($result!="none") {
                  $user_id=$result;
                     
                  $result2=$this->user_model->check_additional_module($user_id);
                  foreach ($result2 as $id) {
                          
                      $module_id=$id['module_id'];
                      $result3=$this->user_model->check_module_archive($module_id);
       
                      foreach ($result3 as $id2) {
                          
                          $module_id1[]=$id2['module_id'];         //pogi mo paul                                   
                      }             
                  }  
                }

                else {} 

                if (in_array($module_id2, $module_id1)) {

                    $result=$this->user_model->get_module_url($module_id2);
                    
                    $module_url=explode("/", $result);
                    
                    $module_controller=$module_url[0];
                    $module_class=$module_url[1];
                    $module_view=$module_url[2];

                    $this->load->view('templates/header');
                    $this->load->view('pages/'.$module_view.'');
                }

                else {                     
                    redirect('main/access_denied');
                } 
            }
            
        else {
            redirect('main/login');
        }
    }
}

?>