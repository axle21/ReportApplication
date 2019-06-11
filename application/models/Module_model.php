<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Module_model extends CI_Model {

    	function __construct() {

            parent::__construct();
            $this->load->database('amti');
        }

        public function check_module_rec($module_id) {
                
            $this->db->select('*');
            $this->db->from('modules_list');
            $this->db->where('module_id',$module_id);

            $query=$this->db->get();

            if ($query->num_rows() == 0) {
                $module_id="none";
            }

            else {
                $module_id="has";
            }
            
            return $module_id; 
        }

        public function check_duplicate_module_name($module_name) {  
            
            $this->db->select('module_name');
            $this->db->from('modules_list');
            $this->db->where('module_name',$module_name);
           
            $query=$this->db->get();
            if ($query->num_rows() == 1) {
                $result="has";
            }
            else {
                $result="none";
            }

            return $result;
        } 

        public function check_duplicate_module_url($module_url) {  
            
            $this->db->select('module_url');
            $this->db->from('modules_list');
            $this->db->where('module_url',$module_url);
           
            $query=$this->db->get();
            if ($query->num_rows() != 0) {
                $result="has";
            }
            else {
                $result="none";
            }

            return $result;
        } 

        public function check_record($module_name, $module_url, $module_level) {
                
            $this->db->select('*');
            $this->db->from('modules_list');
            $this->db->where('module_name',$module_name);
            $this->db->where('module_url',$module_url);
            $this->db->where('module_level',$module_level);

            $query=$this->db->get();
            if ($query->num_rows() == 1) {
                $result1="none";
            }
            else {
                $result1="has";
            }

            return $result1;  
        }

        public function check_module_name($module_name, $module_id) {
                
            $this->db->select('*');
            $this->db->from('modules_list');
            $this->db->where('module_name',$module_name);

            $query=$this->db->get();
     
            if ($query->num_rows() == 0) {
                $result2="none";
            }

            else {
                $row=$query->row_array();

                if ($row['module_id'] == $module_id) {
                    $result2="none";
                }

                else {
                    $result2="has";
                }
            }
          
            return $result2;     
        }

        public function check_module_url($module_url, $module_id) {
                
            $this->db->select('*');
            $this->db->from('modules_list');
            $this->db->where('module_url',$module_url);

            $query=$this->db->get();
      
            if ($query->num_rows() == 0) {
                $result2="none";
            }

            else {
                $row=$query->row_array();

                if ($row['module_id'] == $module_id) {
                    $result2="none";
                }

                else {
                    $result2="has";
                }
            }
            
            return $result2;  
        }

        public function module_save($module_name, $module_url, $module_level) { 

            $data= array(
                'module_name'=>$module_name,
                'module_url'=>$module_url,
                'module_level'=>$module_level
            );

            $this->db->insert('modules_list',$data);
        }   

        public function module_edit($module_name, $module_url, $module_id, $module_level) { 

            $this->db->set('module_name', $module_name);
            $this->db->set('module_url', $module_url);
            $this->db->set('module_level', $module_level);
            $this->db->where('module_id', $module_id);
            $this->db->update('modules_list');
        }   

        public function deactivate($module_name) { 

            $this->db->set('archive', '1');
            $this->db->where('module_name', $module_name);
            $this->db->update('modules_list');  
        }

        public function activate($module_name) {
                
            $this->db->set('archive', '0');
            $this->db->where('module_name', $module_name);
            $this->db->update('modules_list');
        }
    }
?>
