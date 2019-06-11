<?php $this->load->view('templates/temp'); ?>
<body class="skin-blue sidebar-mini sidebar-mini-collapsed sidebar-collapse">

  <div class="wrapper">
    <div class="content-wrapper">
      <section class="content">
      
        <?php 
            $result;
            $module_id;
            if (!empty($_GET['id'])) {

                $module_id=addslashes($_GET['id']);
                $this->db->select('*');
                $this->db->from('modules_list');
                $this->db->where('module_id',$module_id);

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
                <h3 class="box-title">Edit Module<i class="fa fa-pencil" style="margin-left: 10px;"></i></h3>
              </div>

              <form class="form-horizontal" method="post" action="<?php echo base_url('module/edit'); ?>">
                <div class="box-body">
                  <?php 
                      if ($this->session->flashdata('alert')) {
                        echo $this->session->flashdata('alert');
                      }
                  ?>
                  
                  <br>

                  <?php
                  
                      $this->db->select('*');
                      $this->db->from('modules_list');
                      $this->db->where('module_id',$module_id);
                      $query = $this->db->get();
                      $row = $query->row_array();
                      echo "<input type='hidden' name='module_id' id='module_id' class='input-txt' maxlength='20' value='$module_id'/>";

                      echo "<div class='form-group'>
                      <label class='col-sm-3 control-label' for='users_empno'>Module Name: </label>
                      <div class='col-sm-6'>
                        <input type='text' name='module_name' id='module_name' placeholder='Module Name' class='form-control' maxlength='20' value='$row[module_name]' required/>
                      </div>
                      </div>";
                      
                       echo "<div class='form-group'>
                      <label class='col-sm-3 control-label' for='users_empno'>Description: </label>
                      <div class='col-sm-6'>
                        <input type='text' name='module_url' id='module_url' placeholder='Url (Controller/class/view)' class='form-control' maxlength='80' value='$row[module_url]'/>
                      </div>
                      </div>";

                      if ($row['module_level'] == 2) {
                          echo "<div class='row'><div class='col-lg-3'> </div>
                          <div class='col-lg-6'> 
                              <input type='checkbox' name='module_level' id='module_level' checked>    Requires additional variable(s)
                          </div>
                          <div class='col-lg-3'> </div></div>";
                      }

                      else {
                          echo "<div class='row'><div class='col-lg-3'> </div>
                          <div class='col-lg-4'> 
                            <input type='checkbox' name='module_level' id='module_level'>    Requires additional variable(s)
                          </div>
                          <div class='col-lg-6'> </div></div>";
                      }
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
                    Save Module
                    <i class="fa fa-save" style="margin-left: 5px;"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        <div class="col-lg-3"></div>
      </div>
    </section>
  </div>
  <footer class="main-footer">
      <strong>© <?php echo date("Y");?> | AMTI</strong>
  </footer>
</div>