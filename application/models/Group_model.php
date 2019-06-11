<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Group_model extends CI_Model {
    	
    	function __construct() {

            parent::__construct();
            $this->load->database('amti');
        }

        public function check_group_rec($group_id, $group_name, $group_description) {
                
            $this->db->select('*');
            $this->db->from('groups');
            $this->db->where('group_id',$group_id);
            $this->db->where('group_name',$group_name);
            $this->db->where('group_description',$group_description);

            $query=$this->db->get();
            if ($query->num_rows() == 0) {
                $group_id="has";
            }

            else {
                $group_id="none";
            }
            
            return $group_id;     
        }

        public function check_duplicate_group($group_name) {  
            
            $this->db->select('group_name');
            $this->db->from('groups');
            $this->db->where('group_name',$group_name);
           
            $query= $this->db->get();
            if ($query->num_rows() == 1) {
                $result="has";
            }
            else {
                $result="none";
            }

            return $result;
        } 

        public function check_group_permissions($group_id) {  
            
            $this->db->select('*');
            $this->db->from('permissions');
            $this->db->where('group_id',$group_id);
           
            $permission_id = array();
            foreach($this->db->get()->result_array() as $row) {

               $permission_id[] = $row['permission_id'];
            }

            return $permission_id;
        } 

        public function edit_check_duplicate_group($group_name, $group_id) {  
            
            $this->db->select('*');
            $this->db->from('groups');
            $this->db->where('group_name',$group_name);
           
            $query=$this->db->get();
            if($query->num_rows() == 1) {

                $row=$query->row_array();
                $id=$row['group_id'];
                
                if ($group_id == $id) {
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

        public function group_save($group_name, $group_description) { 

            $data = array(
                'group_name'=>$group_name,
                'group_description'=>$group_description
            );

            $this->db->insert('groups',$data);
            $this->db->select('group_id');
            $this->db->from('groups');
            $this->db->where('group_name',$group_name);
           
            $query=$this->db->get();
            $row= $query->row_array();
            $result=$row['group_id'];
            
            return $result;
        }   

        public function group_permissions($group_id, $permission_id) { 

            $data= array(
                'group_id'=>$group_id,
                'permission_id'=>$permission_id
            );

            $this->db->insert('permissions',$data);
        } 

        public function group_edit($group_name, $group_description, $group_id) { 

            $this->db->set('group_name', $group_name);
            $this->db->set('group_description', $group_description);
            $this->db->where('group_id', $group_id);
            $this->db->update('groups');

            $this->db->where('group_id', $group_id);
            $this->db->delete('permissions');

            return $group_id;   
        }    

        public function deactivate($group_name) { 

            $this->db->set('archive', '1');
            $this->db->where('group_name', $group_name);
            $this->db->update('groups');    
        }

        public function activate($group_name) {
                
            $this->db->set('archive', '0');
            $this->db->where('group_name', $group_name);
            $this->db->update('groups');
        } 
    }
?>
