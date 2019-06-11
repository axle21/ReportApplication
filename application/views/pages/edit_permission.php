<?php $this->load->view('templates/temp'); ?>
<body class="skin-blue sidebar-mini sidebar-mini-collapsed sidebar-collapse">
  <div class="wrapper">
    <div class="content-wrapper">
      <section class="content">
      
        <?php 

            $result;
            $permission_id;

            if (!empty($_GET['id'])) {

              $permission_id=addslashes($_GET['id']);
              $this->db->select('*');
              $this->db->from('permissions_list');
              $this->db->where('permission_id',$permission_id);

              $query = $this->db->get();

              if ($query->num_rows() == 0){
                  redirect('main/access_denied');
                  exit();
              }

              else{}
            }

            else {

              redirect('main/access_denied');
              exit();
            }
        ?>

        <div class="row">
         <div class="col-lg-3"> </div>
          <div class="col-lg-6">
            <div class="box box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Edit Permission<i class="fa fa-pencil" style="margin-left: 10px;"></i></h3>
              </div>

              <form class="form-horizontal" method="post" action="<?php echo base_url('permission/edit'); ?>">
                <div class="box-body">
                 <?php 
                      if ($this->session->flashdata('alert')) {
                        echo $this->session->flashdata('alert');
                      }
                 ?>

                 <br>

                 <?php
                 
                    $this->db->select('*');
                    $this->db->from('permissions_list');
                    $this->db->where('permission_id',$permission_id);
                    $query = $this->db->get();
                    $row = $query->row_array();

                    $permission_icon=$row['permission_icon'];

                    echo "<input type='hidden' name='permission_id' id='permission_id' class='input-txt' maxlength='20' value='$permission_id'/>";

                    echo "<div class='form-group'>
                    <label class='col-sm-3 control-label' for='users_empno'>Permission Name: </label>
                    <div class='col-sm-6'>
                      <input name='permission_name' id='permission_name' value='$row[permission_name]' class='form-control' type='text' required>
                      </div>
                    </div>";
                    
                     echo "<div class='form-group'>
                    <label class='col-sm-3 control-label' for='users_empno'>Description: </label>
                    <div class='col-sm-6'>
                      <input type='text' name='permission_description' id='permission_description' class='form-control' value='$row[permission_description]' type='text'>
                      </div>
                    </div>";
                 ?>

                 <?php

                    $this->db->select('*');
                    $this->db->from('modules');
                    $this->db->where('permission_id',$permission_id);

                    $modules = array();
                    foreach($this->db->get()->result_array() as $row) {

                       $modules[] = $row['module_id'];
                    }
                    
                    $this->db->select('*');
                    $this->db->from('modules_list');
                    $this->db->where('archive','0');
                    echo "<div class='row'>";
                    echo "<label class='col-sm-3 control-label'>Modules: </label>";
                    echo "<div class='col-sm-6'>";
                    echo "<div style='overflow-y:scroll; max-height:165px;'>";

                    foreach ($this->db->get()->result_array() as $row) {
                        
                       if (in_array($row['module_id'], $modules)) {

                        echo "<div onmouseover='hover($row[module_id])' onmouseout='mouseout($row[module_id])' title='$row[module_url]'><input type='checkbox' id='module_id[]' name='module_id[]' value=$row[module_id] checked> <label class='lbl'>$row[module_name]</label><br></div>";
                      }

                      else {

                        echo "<div onmouseover='hover($row[module_id])' onmouseout='mouseout($row[module_id])' title='$row[module_url]'><input type='checkbox' id='module_id[]' name='module_id[]' value=$row[module_id]> <label class='lbl'>$row[module_name]</label><br></div>";
                      }

                    }
                    echo "</div>";
                    echo "</div>";
                    echo "</div><br>";

                    echo "<div class='form-group'>
                      <label class='col-sm-3 control-label' for='users_empno'>Icon: </label>
                      <div class='col-sm-6'>
                        <input type='text' name='permission_icon' id='permission_icon' class='form-control' value='$permission_icon' type='text'>
                        </div>
                      </div>";
                 ?>

                 <br>

                <div class="box-footer">
                  <a href="javascript: history.go(-1)">
                    <button class="btn btn-default btn-flat" type="button">
                      Cancel
                      <i class="fa fa-remove" style="margin-left: 5px;"></i>
                    </button>
                  </a>
                  <button class="btn btn-info btn-flat pull-right" type="submit" name="save">
                    Save Permission
                    <i class="fa fa-save" style="margin-left: 5px;"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
         <div class="col-lg-3"> </div>
      </div>
    </section>
  </div>

  <footer class="main-footer">
     <strong>© <?php echo date("Y");?> | AMTI</strong>
  </footer>
</div>
