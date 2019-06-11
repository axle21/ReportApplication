<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class User_model extends CI_Model {

        protected $table='users';
        function __construct() {

            parent::__construct();
            $this->load->database('amti');
            $this->db2 = $this->load->database('db2', true); 
            $this->db3 = $this->load->database('db3', true); 
        }

        // -------------------------- check user_access START ------------------------------

        public function check_user_id($user_uname) {
           
            $this->db->select('users_id');
            $this->db->from('users');
            $this->db->where('users_uname', $user_uname);
            $this->db->where('users_status', 'active');
            $query = $this->db->get();
                  
            if ($query->num_rows() == 0) {
                $user_id="none";
            }

            else {
                $row = $query->row_array();
                $user_id=$row['users_id'];
            }
               
            return $user_id;  
        }

        public function check_group_archive($user_id) {
                
            $this->db->select('users_role');
            $this->db->from('users');
            $this->db->where('users_id', $user_id);
            $query = $this->db->get();
            $row = $query->row_array();
            $group_id=$row['users_role'];
            
            $this->db->select('group_id');
            $this->db->from('groups');
            $this->db->where('group_id', $group_id);
            $this->db->where('archive', '0');

            $query = $this->db->get();

            if ($query->num_rows() == 0) {
                $group_id="none";
            }

            else {
                $row = $query->row_array();
                $group_id=$row['group_id'];
            }
             
            return $group_id;       
        }

        public function check_permission_1($group_id) {   // ---------- Check permissions under specified group/role id
                
            $this->db->select('permission_id');
            $this->db->from('permissions');
            $this->db->where('group_id',$group_id);
            
            $permission_id = array();
            foreach($this->db->get()->result_array() as $row) {

                $permission_id[] = array( 
                    'permission_id' => $row['permission_id']   
                );
            }
            
            return $permission_id;     
        }

        public function check_permission_2($user_id) { // ---------- Check permissions assigned to  specified user id
                
            $this->db->select('permission_id');
            $this->db->from('permissions_additional');
            $this->db->where('user_id',$user_id);
            
            $permission_id=array();
            foreach($this->db->get()->result_array() as $row) {

                $permission_id[]= array( 
                    'permission_id' => $row['permission_id']   
                );
            }
            
            return $permission_id;     
        }

        public function check_user_permissions($user_id) {
                
            $this->db->select('permission_id');
            $this->db->from('permissions_additional');
            $this->db->where('user_id',$user_id);
            
            $permission_id=array();
            foreach($this->db->get()->result_array() as $row) {

               $permission_id[]= $row['permission_id'];
            }
            
            return $permission_id;     
        }

        public function check_permission_archive($permission_id) {
                
            $this->db->select('*');
            $this->db->from('permissions_list');
            $this->db->where('permission_id',$permission_id);
            $this->db->where('archive','0');
            //$this->db->order_by("permission_name","desc");


            $permission_id=array();
            $query=$this->db->get();

            if ($query->num_rows() == 0) {
                $permission_id="none";
            }

            else {
                $row=$query->row_array();

                $permission_id[]= array( 
                    'permission_name' => $row['permission_name'],
                    'permission_icon' => $row['permission_icon']    
                );
            }
            
            return $permission_id;   
        }

        public function check_module($permission_id) {
                
            $this->db->select('module_id');
            $this->db->from('modules');
            $this->db->where('permission_id',$permission_id);
     
            $module_id=array();
            foreach($this->db->get()->result_array() as $row) {

                $module_id[]= array( 
                  'module_id' => $row['module_id']   
                );
            }
        
            return $module_id;   
        }

        public function check_additional_module($user_id) {
                
            $this->db->select('module_id');
            $this->db->from('modules_additional');
            $this->db->where('user_id',$user_id);
     
            $module_id=array();
            foreach($this->db->get()->result_array() as $row) {

                $module_id[]= array( 
                  'module_id' => $row['module_id']   
                );
            }
        
            return $module_id;     
        }

        public function check_user_modules($user_id) {
                
            $this->db->select('module_id');
            $this->db->from('modules_additional');
            $this->db->where('user_id',$user_id);
     
            $module_id=array();
            foreach($this->db->get()->result_array() as $row) {

                $module_id[]= $row['module_id'];
            }
        
            return $module_id;     
        }

        public function check_module_archive($module_id) {
                
            $this->db->select('*');
            $this->db->from('modules_list');
            $this->db->where('module_id',$module_id);
            $this->db->where('archive','0');

            $module_rec=array();
            foreach($this->db->get()->result_array() as $row) {

               $module_rec[]= array( 
                    'module_id' => $row['module_id'],
                    'module_url' => $row['module_url'],
                    'module_name' => $row['module_name']  
                );
            }
            
            return $module_rec;  
        }

        public function check_module_archive2($module_id) {
                
            $this->db->select('*');
            $this->db->from('modules_list');
            $this->db->where('module_id',$module_id);
            $this->db->where('module_level','1');
            $this->db->where('archive','0');

            $module_rec=array();
            foreach($this->db->get()->result_array() as $row) {

               $module_rec[]= array( 
                    'module_id' => $row['module_id'],
                    'module_url' => $row['module_url'],
                    'module_name' => $row['module_name']  
                );
            }
            
            return $module_rec;
        }

        public function get_module_url($module_id2) {

            $this->db->select('*');
            $this->db->from('modules_list');
            $this->db->where('module_id',$module_id2);

            $query=$this->db->get();

            if ($query->num_rows() == 0) {
                $module_url="none";
            }

            else {
                $row=$query->row_array();
                $module_url=$row['module_url'];
            }
            
            return $module_url;
        }

        // -----------------------check user_access END ------------------------------

        public function search_data($search) {

            $search = substr($search, 0, 8);

            $this->db2->select ('*');
            $this->db2->from ('AMTI_EMPLOYEE');
            $this->db2->like('EMPLOYEE_NUMBER',$search);
            $this->db2->or_like('LAST_NAME',$search);
            $this->db2->or_like('FIRST_NAME',$search);
            $this->db2->or_like('FULL_NAME',$search);
            $this->db2->or_like('PARENT_RC',$search);
            
            $record=array();
            foreach($this->db2->get()->result_array() as $row) {

                $record[]= array(
                    'empno' => $row['EMPLOYEE_NUMBER'],
                    'fname' => $row['FIRST_NAME'],
                    'lname' => $row['LAST_NAME'],
                    'department' => $row['PARENT_RC'],
                    'email' => $row['EMAIL_ADDRESS'],
                    'full' => $row['FULL_NAME']
                );
            } 
            
            return $record;
        }

        public function search_sales($search) {

            $this->db2->select ('*');
            $this->db2->from ('AMTI_SALESREPS');
            $this->db2->like('RESOURCE_ID',$search);
            $this->db2->or_like('upper(RESOURCE_NAME)',$search);
            $this->db2->or_like('upper(BUSINESS_UNIT)',$search);
            $this->db2->or_like('upper(SALESMANAGER)',$search);
            
            $record=array();
            foreach($this->db2->get()->result_array() as $row) {

                $record[]= array(
                    'id' => $row['RESOURCE_ID'],
                    'name' => $row['RESOURCE_NAME'],
                    'unit' => $row['BUSINESS_UNIT'],
                    'manager' => $row['BU_HEAD'],
                    'salesrep' => $row['SALESREP_ID'],
                    'branch' => "AMTI"
                );
            }

            $this->db2->select ('*');
            $this->db2->from ('AMTI_SALESREPS_SUBIC');
            $this->db2->like('RESOURCE_ID',$search);
            $this->db2->or_like('upper(RESOURCE_NAME)',$search);
            $this->db2->or_like('upper(BUSINESS_UNIT)',$search);
            $this->db2->or_like('upper(SALESMANAGER)',$search);
            
            foreach($this->db2->get()->result_array() as $row) {

                $record[]= array(
                    'id' => $row['RESOURCE_ID'],
                    'name' => $row['RESOURCE_NAME'],
                    'unit' => $row['BUSINESS_UNIT'],
                    'manager' => $row['BU_HEAD'],
                    'salesrep' => $row['SALESREP_ID'],
                    'branch' => "Subic"
                );
            } 
            
            return $record;
        }

        public function search_sales_list($search) {

            $this->db2->select ('*');
            $this->db2->from ('AMTI_SALESREPS');
            $this->db2->like('RESOURCE_ID',$search);
            $this->db2->or_like('upper(RESOURCE_NAME)',$search);
            $this->db2->or_like('upper(BUSINESS_UNIT)',$search);
            $this->db2->or_like('upper(SALESMANAGER)',$search);

            $record=array();
            foreach($this->db2->get()->result_array() as $row) {

                $record[]= array(
                    'id' => $row['RESOURCE_ID'],
                    'name' => $row['RESOURCE_NAME'],
                    'unit' => $row['BUSINESS_UNIT'],
                    'manager' => $row['BU_HEAD'],
                    'salesrep' => $row['SALESREP_ID']
                );
            }
            
            return $record;
        }

        public function search_user_salesrep_id($userid) { // --------------- inserts data into multi-D array

            $this->db->select ('*');
            $this->db->from ('sales_reps');
            $this->db->where('user_id',$userid);
            
            $record=array();
            foreach($this->db->get()->result_array() as $row) {

                $record[]= array(
                    'salesrep' => $row['salesrep_id']
                );
            }
            
            return $record;
        }

         public function search_user_salesrep($userid) { // ----------- inserts data into 1D array

            $this->db->select ('*');
            $this->db->from ('sales_reps');
            $this->db->where('user_id',$userid);
            
            $record=array();
            foreach($this->db->get()->result_array() as $row) {

                $record[]= $row['salesrep_id'];
            }
            
            return $record;
        }

        public function search_salesrep($search) {

            $this->db2->select ('*');
            $this->db2->from ('AMTI_SALESREPS');
            $this->db2->where('SALESREP_ID',$search);

            $record=array();
            foreach($this->db2->get()->result_array() as $row) {

                $record[]= array(
                    'id' => $row['RESOURCE_ID'],
                    'name' => $row['RESOURCE_NAME'],
                    'unit' => $row['BUSINESS_UNIT'],
                    'manager' => $row['BU_HEAD'],
                    'salesrep' => $row['SALESREP_ID'],
                    'branch' => "AMTI"
                );
            }
            
            $this->db2->select ('*');
            $this->db2->from ('AMTI_SALESREPS_SUBIC');
            $this->db2->where('SALESREP_ID',$search);

            foreach($this->db2->get()->result_array() as $row) {

                $record[]= array(
                    'id' => $row['RESOURCE_ID'],
                    'name' => $row['RESOURCE_NAME'],
                    'unit' => $row['BUSINESS_UNIT'],
                    'manager' => $row['BU_HEAD'],
                    'salesrep' => $row['SALESREP_ID'],
                    'branch' => "Subic"
                );
            }
            
            return $record;
        }

        public function search_manager_salesrep_id($fname, $lname) {

            $this->db2->select ('SALESREP_ID');
            $this->db2->from ('AMTI_SALESREPS');
            $this->db2->like('upper(SALESMANAGER)',strtoupper($fname));
            $this->db2->or_like('upper(SALESMANAGER)',strtoupper($lname));

            $record=array();
            foreach($this->db2->get()->result_array() as $row) {

                $record[]= array(
                    'salesrep' => $row['SALESREP_ID']
                );
            }
            
            $this->db2->select ('SALESREP_ID');
            $this->db2->from ('AMTI_SALESREPS_SUBIC');
            $this->db2->like('upper(SALESMANAGER)',strtoupper($fname));
            $this->db2->or_like('upper(SALESMANAGER)',strtoupper($lname));

            foreach($this->db2->get()->result_array() as $row) {

                $record[]= array(
                    'salesrep' => $row['SALESREP_ID']
                );
            }
            
            return $record;
        }

         public function search_subinventory() {
            
           $query = $this->db3->query( " SELECT ' ALL' as SECONDARY_INVENTORY_NAME,
                                            'All Subinventory' as DESCRIPTION 
                                            FROM dual
                                            UNION 
                                            SELECT SECONDARY_INVENTORY_NAME, DESCRIPTION  
                                            FROM MTL_SECONDARY_INVENTORIES
                                            " );
           
            

            foreach ($query->result_array() as $row) {

                $record[]= array(
                    'subinventory' => $row['SECONDARY_INVENTORY_NAME'],
                    'description' => $row['DESCRIPTION']
                    
                );
            }

            return $record;
        }


        public function search_customer_group($salesrep_id, $group) {

           $salesreps = explode(',', $salesrep_id);
            
        
            if ($group == "Sales" )
            {    


                 $sql = "SELECT '  ALL' as CUSTOMER , 'All Customer Name' as SALESREP_ID FROM DUAL UNION SELECT CUSTOMER, SALESREP_ID FROM AMTI_CUSTOMER_PER_AM WHERE SALESREP_ID IN ? ";

                 $query = $this->db2->query($sql, array($salesreps));


                foreach($query->result_array() as $row) {
            
                // $this->db2->where_in('SALESREP_ID',$salesreps);
                // $query=$this->db2->get("AMTI_CUSTOMER_PER_AM");
                // $res = $query->result_array();
        
                // // $record=array();
                // foreach($res as $row) {

                    $record[]= array(
                         'customer' => $row['CUSTOMER'],
                         'accountmanager' => $row['SALESREP_ID']
                    );
                }
                return $record;
            }
            
            else
            {
                 $query = $this->db2->query(" SELECT '  ALL' as CUSTOMER , 'All Customer Name' as SALESREP_ID FROM DUAL UNION SELECT CUSTOMER, SALESREP_ID FROM AMTI_CUSTOMER_PER_AM " );
                
                foreach($query->result_array() as $row) {

                    $record[]= array(
                         'customer' => $row['CUSTOMER'],
                         'accountmanager' => $row['SALESREP_ID']
                    );
                }
 
                return $record;
                
            }
        }

        public function search_customer($salesrep_id) {




           $salesreps = explode(',', $salesrep_id);
            
        
            if ($salesrep_id == "" || $salesrep_id == null )
            {    

                $query = $this->db2->query(" SELECT '  ALL' as CUSTOMER , 'All Customer Name' as SALESREP_ID FROM DUAL UNION SELECT CUSTOMER, SALESREP_ID FROM AMTI_CUSTOMER_PER_AM " );
                
                foreach($query->result_array() as $row) {

                    $record[]= array(
                         'customer' => $row['CUSTOMER'],
                         'accountmanager' => $row['SALESREP_ID']
                    );
                }
 
                return $record;

           
            }
            
            else
            {

                $sql = "SELECT '  ALL' as CUSTOMER , 'All Customer Name' as SALESREP_ID FROM DUAL UNION SELECT CUSTOMER, SALESREP_ID FROM AMTI_CUSTOMER_PER_AM WHERE SALESREP_ID IN ? ";

                 $query = $this->db2->query($sql, array($salesreps));


                foreach($query->result_array() as $row) {

                    $record[]= array(
                         'customer' => $row['CUSTOMER'],
                         'accountmanager' => $row['SALESREP_ID']
                    );
                }
                return $record;
                
            }
        }

        public function search_item() {

            $this->db2->distinct();
            $this->db2->select('*');
            $this->db2->like('upper(ITEM)');
            $this->db2->order_by(1);
            $query = $this->db2->get('AMTI_ORACLE_ITEMS');


            $res = $query->result_array();

            // $record=array();
            foreach($res as $row) {

                $record[]= array(
                    'item' => $row['ITEM'],
                    'description' =>$row['DESCRIPTION']
                );
            }

            return $record;
        }


        public function search_vendor() {

            $this->db2->distinct();
            $this->db2->select('*');
            $this->db2->like('upper(VENDOR_NAME)');
            $this->db2->order_by(1);
            $query = $this->db2->get('APPS.PO_VENDORS');


            $res = $query->result_array();

            // $record=array();
            foreach($res as $row) {

                $record[]= array(
                    'vendor_name' => $row['VENDOR_NAME']
                );
            }

            return $record;


        }

        //  public function search_data($search) {

        //     $search = substr($search, 0, 8);

        //     $this->db2->select ('*');
        //     $this->db2->from ('AMTI_EMPLOYEE');
        //     $this->db2->like('EMPLOYEE_NUMBER',$search);
        //     $this->db2->or_like('LAST_NAME',$search);
        //     $this->db2->or_like('FIRST_NAME',$search);
        //     $this->db2->or_like('FULL_NAME',$search);
        //     $this->db2->or_like('PARENT_RC',$search);
            
        //     $record=array();
        //     foreach($this->db2->get()->result_array() as $row) {

        //         $record[]= array(
        //             'empno' => $row['EMPLOYEE_NUMBER'],
        //             'fname' => $row['FIRST_NAME'],
        //             'lname' => $row['LAST_NAME'],
        //             'department' => $row['PARENT_RC'],
        //             'email' => $row['EMAIL_ADDRESS'],
        //             'full' => $row['FULL_NAME']
        //         );
        //     } 
            
        //     return $record;
        // }


        public function search_empno($user_empno) {     

            $this->db2->select ('*');
            $this->db2->from ('AMTI_EMPLOYEE');
            $this->db2->like('EMPLOYEE_NUMBER',$user_empno);

            $record=array();
            foreach($this->db2->get()->result_array() as $row) {

                $record[]= array(
                    'empno' => $row['EMPLOYEE_NUMBER'],
                    'name' => $row['FULL_NAME'],
                    'department' => $row['PARENT_RC']
                );
            }
            
            return $record;
        }

        public function check_user_rec($user_id) {
                
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('users_id',$user_id);

            $query = $this->db->get();

            if ($query->num_rows() == 0) {
                $user_id="none";
            }

            else {
                $user_id="has";
            }
            
            return $user_id;
        }

        public function add_user($empno, $username, $firstname, $lastname, $email, $group_id) {

            $user = array(
                'users_empno'=> $empno,
                'users_uname'=> strtoupper($username),
                'users_pass'=>  md5('password@123'),
                'users_fname'=> $firstname,
                'users_lname'=> $lastname,
                'users_email'=> $email,
                'users_role'=> $group_id
             );

            $this->db->insert($this->table,$user);
        }

        public function check_duplicate_username($username) {

            $this->db->select('users_uname');
            $this->db->from('users');
            $this->db->where('users_uname',$username);
           
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $result1="has";
            }
            else {
                $result1="none";
            }

            return $result1;
        }

        public function check_duplicate_empno($empno) {

            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('users_empno',$empno);
           
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $result2="has";
            }
            else {
                $result2="none";
            }

            return $result2;
        }

        public function check_account($empno, $username, $firstname, $lastname, $email, $group_id) {
                
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('users_uname',$username);
            $this->db->where('users_fname',$firstname);
            $this->db->where('users_lname',$lastname);
            $this->db->where('users_email',$email);
            $this->db->where('users_empno',$empno);
            $this->db->where('users_role',$group_id);

            $query = $this->db->get();

            if ($query->num_rows() == 1) {
                $result1="none";
            }
            else {
                $result1="has";
            }

            return $result1; 
        }

        public function check_empno($empno, $userid) {
                
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('users_empno',$empno);

            $query = $this->db->get();
       
            if ($query->num_rows() == 0) {
                $result2="none";
            }

            else {
                $row = $query->row_array();

                if ($row['users_id'] == $userid) {
                    $result2="none";
                }

                else {
                    $result2="has";
                }
            }
                  
            return $result2;  
        }

        public function check_username($userid, $username) {
                
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('users_uname',$username);

            $query = $this->db->get();
       
            if ($query->num_rows() == 0) {
                $result2="none";
            }

            else {
                $row = $query->row_array();

                if ($row['users_id'] == $userid) {
                    $result2="none";
                }

                else {
                    $result2="has";
                }
            }
                  
            return $result2;  
        }

        public function edit($empno, $username, $firstname, $lastname, $email, $userid, $group_id) {
                
            $this->db->set('users_empno', $empno);
            $this->db->set('users_fname', $firstname);
            $this->db->set('users_lname', $lastname);
            $this->db->set('users_uname', strtoupper($username));
            $this->db->set('users_email', $email);
            $this->db->set('users_role', $group_id);
            $this->db->where('users_id', $userid);
            $this->db->update('users');  

            $this->db->where('user_id', $userid);
            $this->db->delete('permissions_additional');

            $this->db->where('user_id', $userid);
            $this->db->delete('modules_additional');
        }

        public function set_additional_permissions($permission_id, $userid) {
                
            $data = array(
                'permission_id'=>$permission_id,
                'user_id'=>$userid
            );

            $this->db->insert('permissions_additional',$data);
        }

        public function set_additional_modules($module_id, $userid) {
                
            $data = array(
                'module_id'=>$module_id,
                'user_id'=>$userid
            );

            $this->db->insert('modules_additional',$data);
        }

        public function delete_salesrep($userid) {

            $this->db->where('user_id', $userid);
            $this->db->delete('sales_reps');
        }

        public function set_salesrep($userid, $sales_id) {

            $data = array(
                'user_id'=>$userid,
                'salesrep_id'=>$sales_id
            );

            $this->db->insert('sales_reps',$data);
        }

        public function deactivate($empno) {

            $this->db->set('users_status', 'inactive');
            $this->db->where('users_empno', $empno);
            $this->db->update('users');
        }

        public function activate($empno) {
                
            $this->db->set('users_status', 'active');
            $this->db->where('users_empno', $empno);
            $this->db->update('users');
        }

        public function change_password($user_id, $password_new) {
                
            $this->db->set('users_pass', md5($password_new));
            $this->db->where('users_id', $user_id);
            $this->db->update('users');
        }

        public function reset_password($user_id) {
                
            $this->db->set('users_pass', md5("password@123"));
            $this->db->where('users_id', $user_id);
            $this->db->update('users');
        }

        public function groups() {
                
            $this->db->select('*');
            $this->db->from('groups');
            $this->db->where('archive','0');
           
            $group_id = array();
            foreach($this->db->get()->result_array() as $row) {

                $group_id[] = array( 
                  'id' => $row['group_id'], 
                  'name' => $row['group_name']  
                );
            }
         
            return $group_id;     
        }

        public function permissions($group_id) {
                
            $this->db->select('*');
            $this->db->from('permissions');
            $this->db->where('group_id',$group_id);
     
            $permission_id = array();
            foreach($this->db->get()->result_array() as $row) {

                $permission_id[] = array( 
                    'permission' => $row['permission_id']   
                );
            }
       
            return $permission_id;  
        }

        public function modules($permission_id) {
                
            $this->db->select('*');
            $this->db->from('modules');
            $this->db->where('permission_id',$permission_id);
     
            $module_id = array();
            foreach($this->db->get()->result_array() as $row) {

                $module_id[] = array( 
                    'module' => $row['module_id']   
                );
            }
       
            return $module_id;  
        }

        public function permissions_list() {
                
            $this->db->select('*');
            $this->db->from('permissions_list');
            $this->db->where('archive','0');
     
            $permissions = array();
            foreach($this->db->get()->result_array() as $row) {

                $permissions[] = array( 
                    'id' => $row['permission_id'],
                    'name' => $row['permission_name'] 
                );
            }
         
            return $permissions;    
        }

        public function modules_list() {
                
            $this->db->select('*');
            $this->db->from('modules_list');
            $this->db->where('archive','0');
     
            $modules = array();
            foreach($this->db->get()->result_array() as $row) {

                $modules[] = array( 
                    'id' => $row['module_id'],
                    'name' => $row['module_name'] 
                );
            }
         
            return $modules;
        }

        public function login_status($users_uname) {

            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('users_uname',$users_uname);
            $this->db->where('users_status','active');

            $query = $this->db->get();

            if($query->num_rows() == 1) {
                return true;
            }

            else{
                return false;
            }
        }
    }
?>