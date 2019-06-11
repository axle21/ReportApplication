<?php $this->load->view('templates/temp'); ?>
<body class="skin-blue sidebar-mini sidebar-mini-collapsed sidebar-collapse">

  <div class="wrapper">
    <div class="content-wrapper">
      <section class="content">

        <div class="row">
          <div class="col-lg-3"> </div>
          <div class="col-lg-6">
            <div class="box box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Add Permission<i class="fa fa-plus-square" style="margin-left: 10px;"></i></h3>
              </div>

              <form class="form-horizontal" method="post" action="<?php echo base_url('permission/edit'); ?>">
                <div class="box-body">

                  <?php 
                      if ($this->session->flashdata('alert')) {
                        echo $this->session->flashdata('alert');
                      }
                  ?>
                  <br>
                  
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="users_empno">Permission Name: </label>
                    <div class="col-sm-6">
                        <input type="text" name="permission_name" id="permission_name" placeholder="Permission Name" class="form-control" maxlength="20" required/>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="users_uname">Description: </label>
                    <div class="col-sm-6">
                        <input type="text" name="permission_description" id="permission_description" placeholder="Description" class="form-control"  maxlength="80"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="users_empno">Modules: </label>
                    <div class="col-sm-6">
                        <?php

                            $this->db->select('*');
                            $this->db->from('modules_list');
                            $this->db->where('archive','0');
                           
                            echo "<div style='overflow-y:scroll; max-height:220px;'>";
                            foreach ($this->db->get()->result_array() as $row)
                            {
                              
                              echo "<div onmouseover='hover($row[module_id])' onmouseout='mouseout($row[module_id])' title='$row[module_url]'><input type='checkbox' id='module_id[]' name='module_id[]' value=$row[module_id]> <label class='lbl'>$row[module_name]</label><br></div>";
                            }

                            echo "</div>";
                        ?>
                  </div>
                </div> 

                <br>

                <div class="box-footer">
                  <a href="javascript: history.go(-1)">
                    <button class="btn btn-default btn-flat" type="button">
                      Cancel
                      <i class="fa fa-remove" style="margin-left: 5px;"></i>
                    </button>
                  </a>
                  <button class="btn btn-info btn-flat pull-right" type="submit" name="add">
                    Save Permission
                    <i class="fa fa-save" style="margin-left: 5px;"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-3"> </div>
      </section>

    </div>

    <footer class="main-footer">
        <strong>© <?php echo date("Y");?> | AMTI</strong>
    </footer>

  </div>