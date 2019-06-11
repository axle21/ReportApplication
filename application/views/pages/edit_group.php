<?php $this->load->view('templates/temp'); ?>
<body class="skin-blue sidebar-mini sidebar-mini-collapsed sidebar-collapse">
  
  <div class="wrapper">
    <div class="content-wrapper">
      <section class="content">
        
      <?php
          $result;
          $group_id;

          if (!empty($_GET['id'])) {

              $group_id=addslashes($_GET['id']);
              $this->db->select('*');
              $this->db->from('groups');
              $this->db->where('group_id',$group_id);

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
                <h3 class="box-title">Edit Group<i class="fa fa-pencil" style="margin-left: 10px;"></i></h3>
              </div>

              <form class="form-horizontal" method="post" action="<?php echo base_url('group/edit'); ?>">
                <div class="box-body">

                 <?php 
                    if ($this->session->flashdata('alert')) {
                      echo $this->session->flashdata('alert');
                    }
                  ?>

                 <br>
              
                 <?php
                  
                    $this->db->select('*');
                    $this->db->from('groups');
                    $this->db->where('group_id',$group_id);
                    $query = $this->db->get();
                    $row = $query->row_array();
                    echo "<input type='hidden' name='group_id' id='group_id' class='form-control' maxlength='20' value='$group_id'/>";

                    echo "<div class='form-group'>
                    <label class='col-sm-3 control-label' for='users_empno'>Group Name: </label>
                    <div class='col-sm-6'>
                      <input name='group_name' id='group_name' value='$row[group_name]' class='form-control' type='text' required>
                    </div>
                  </div>";
                    
                     echo "<div class='form-group'>
                    <label class='col-sm-3 control-label' for='users_empno'>Description: </label>
                    <div class='col-sm-6'>
                      <input type='text' name='group_description' id='group_description' class='form-control' value='$row[group_description]' type='text'>
                      
                    </div>
                  </div>";

               ?>

               <?php

                  $this->db->select('*');
                  $this->db->from('permissions');
                  $this->db->where('group_id',$group_id);

                  $permissions = array();
                  foreach($this->db->get()->result_array() as $row) {

                     $permissions[] = 
                          $row['permission_id']
                            
                      ;
                  }
                  
                  $this->db->select('*');
                  $this->db->from('permissions_list');
                  $this->db->where('archive','0');
                  echo "<div class='row'>";
                  echo "<label class='col-sm-3 control-label' for='users_empno'>Permissions: </label>";
                  echo "<div class='col-sm-6'>";
                  echo "<div style='overflow-y:scroll; max-height:220px;'>";
                  foreach ($this->db->get()->result_array() as $row) {
                      
                      if (in_array($row['permission_id'], $permissions)) {

                          echo "<div onmouseover='hover($row[permission_id])' onmouseout='mouseout($row[permission_id])' title='$row[permission_description]'><input type='checkbox' id='permission_id[]' name='permission_id[]' value=$row[permission_id] checked> <label class='lbl'>$row[permission_name]</label><br></div>";

                      }

                      else {

                          echo "<div onmouseover='hover($row[permission_id])' onmouseout='mouseout($row[permission_id])' title='$row[permission_description]'><input type='checkbox' id='permission_id[]' name='permission_id[]' value=$row[permission_id]> <label class='lbl'>$row[permission_name]</label><br></div>";

                      }

                  }
                  echo "</div>";
                  echo "</div>";
                  echo "<div class='col-lg-6'> </div>";
                  echo "</div>";

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
                    Save Group
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
