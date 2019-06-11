<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Permission_model extends CI_Model {

    	function __construct() {

            parent::__construct();
            $this->load->database('amti');
        }
      
        public function check_permission_rec($permission_id, $permission_name, $permission_description, $permission_icon) {
                
            $this->db->select('*');
            $this->db->from('permissions_list');
            $this->db->where('permission_id',$permission_id);
            $this->db->where('permission_name',$permission_name);
            $this->db->where('permission_description',$permission_description);
            $this->db->where('permission_icon',$permission_icon);


            $query=$this->db->get();
            if ($query->num_rows() == 0) {
                $permission_id="has";
            }

            else {
                $permission_id="none";
            }
            
            return $permission_id;     
        }

        public function check_permission_modules($permission_id) {
            
            $this->db->select('*');
            $this->db->from('modules');
            $this->db->where('permission_id',$permission_id);
           
            $module_id = array();
            foreach($this->db->get()->result_array() as $row) {

               $module_id[] = $row['module_id'];
            }

            return $module_id;
        } 
        
        public function check_duplicate_permission($permission_name) {
            
            $this->db->select('permission_name');
            $this->db->from('permissions_list');
            $this->db->where('permission_name',$permission_name);
           
            $query=$this->db->get();
            if ($query->num_rows() == 1){
                $result="has";
            }
            else {
                $result="none";
            }

            return $result;
        } 

        public function edit_check_duplicate_permission($permission_name, $permission_id) {
            
            $this->db->select('*');
            $this->db->from('permissions_list');
            $this->db->where('permission_name',$permission_name);
           
            $query=$this->db->get();
            if ($query->num_rows() == 1) {

                $row=$query->row_array();
                $id=$row['permission_id'];
                
                if ($permission_id == $id) {
                    $result="none";
                }

                else {
                    $result="has";
                }
            }
            else {
                $result="none";
            }

            return $result;
        }

        public function permission_save($permission_name, $permission_description) {

            $data= array(
                'permission_name'=>$permission_name,
                'permission_description'=>$permission_description
            );

            $this->db->insert('permissions_list',$data);

            $this->db->select('permission_id');
            $this->db->from('permissions_list');
            $this->db->where('permission_name',$permission_name);
           
            $query=$this->db->get();
            $row=$query->row_array();
            $result=$row['permission_id'];
            
            return $result;
        }  

        public function permission_edit($permission_name, $permission_description, $permission_id, $permission_icon) {

            $this->db->set('permission_name', $permission_name);
            $this->db->set('permission_description', $permission_description);
            $this->db->set('permission_icon', $permission_icon);
            $this->db->where('permission_id', $permission_id);
            $this->db->update('permissions_list');

            $this->db->where('permission_id', $permission_id);
            $this->db->delete('modules');

            return $permission_id; 
        }    

        public function permission_modules($permission_id, $module_id) {

            $data= array(
                'permission_id'=>$permission_id,
                'module_id'=>$module_id
            );

            $this->db->insert('modules',$data);
        }  

        public function deactivate($permission_name) {

            $this->db->set('archive', '1');
            $this->db->where('permission_name', $permission_name);
            $this->db->update('permissions_list');  
        }

        public function activate($permission_name) {
                
            $this->db->set('archive', '0');
            $this->db->where('permission_name', $permission_name);
            $this->db->update('permissions_list');
        } 
    }
?>
