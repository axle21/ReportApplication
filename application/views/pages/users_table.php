<body class="skin-blue sidebar-mini sidebar-mini-collapsed sidebar-collapse">
<?php $this->load->view('templates/temp'); ?>


  <div class="wrapper"> 
    <div class="content-wrapper">
      <section class="content">
        <?php 
          if ($this->session->flashdata('alert')) {
            echo $this->session->flashdata('alert');
          }
        ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">USER ACCOUNTS<i class="fa fa-user" style="margin-left: 10px;"></i></h3>

            </div>
            <div class="box-header with-border">
            <a href="<?php echo base_url('user/check_access?mid=0002');?>"> <button class="btn btn-primary"><i class="fa fa-user-plus"> Add User </i> </button> </a> 
            </div>
            <div class="box-body">  
              <div id="users_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-12">

                    <!-- Retrieving data from oracle (2nd database) -->

                    <!-- <div class="table-responsive">
                    <table id="users-table" class="table table-bordered table-hover dataTable" role="grid">
                      <thead>
                           <tr>
                              <th>Employee Number</th>
                              <th>First Name</th>
                              <th>Last Name</th>
                              <th>Email</th>
                              <th>Sex</th>
                              <th>Action</th>
                           </tr>
                      </thead>
                    <tbody>
            
                          <?php
                              // $this->db2 = $this->load->database('db2', true); 

                              // $this->db2->select ('*');
                              // $this->db2->from ('AMTI_EMPLOYEE');

                              // foreach ($this->db2->get()->result_array() as $row) 
                              // {
                              //       echo  "<td style='white-space: nowrap;'>$row[EMPLOYEE_NUMBER]</td>";
                              //       echo  "<td style='white-space: nowrap;'>$row[FIRST_NAME]</td>";
                              //       echo  "<td style='white-space: nowrap;'>$row[LAST_NAME]</td>";
                              //       echo  "<td style='white-space: nowrap;'>$row[EMAIL_ADDRESS]</td>";
                              //       echo  "<td style='white-space: nowrap;'>$row[SEX]</td>";

                              //       $employee_number=$row['EMPLOYEE_NUMBER'];

                              //       echo 
                              //       "   <td style='width: 30px;'>
                              //               <a href=".base_url('user/check_access')."?mid=0012&id=$employee_number role='button' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i></a>
                              //       ";    // base_url must be the url saved in the database (table:modules_list)
                              //             // mid (module ID) must be the module_id saved in the database (table:modules_list)

                              //       echo $row['EMPLOYEE_NUMBER'] == "active" ?
                              //       "   
                              //               <button class='deactivate_rec btn btn-danger btn-xs'
                              //                     data-id='$row[EMPLOYEE_NUMBER]' 
                              //                     data-toggle='modal' data-target='#myModal2'><i class='fa fa-minus'></i></button>

                              //           "
                              //           :
                              //           "  
                              //               <button class='activate_rec btn btn-success btn-xs' 
                              //                     data-id='$row[EMPLOYEE_NUMBER]'
                              //                     data-toggle='modal' data-target='#myModal3'><i class='fa fa-plus'></i></button>
                              //           </td>";
                              //        echo "</tr>";
                              //     }
                          ?>  -->

                  <div class="table-responsive">
                    <table id="users-table" class="table table-bordered table-hover dataTable" role="grid">
                        <thead>
                            <tr>
                              <th>First Name</th>
                              <th>Last Name</th>
                              <th>Username</th>
                              <th>Employee #</th>
                              <th>Email</th>
                              <th>Role</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                              $query = $this->db->get('users');
                              $res = $query->result_array();

                              foreach ($res as $row) {
                                $u_username=strtoupper($row['users_uname']);
                                $u_fname=strtolower($row['users_fname']);
                                $u_lname=strtolower($row['users_lname']);

                                $u_fname=ucwords(strtolower($u_fname));
                                $u_lname=ucwords(strtolower($u_lname));

                                  echo  "<td style='white-space: nowrap;'>$u_fname</td>";
                                  echo  "<td style='white-space: nowrap;'>$u_lname</td>";
                                  echo  "<td style='white-space: nowrap;'>$u_username</td>";
                                  echo  "<td style='white-space: nowrap;'>$row[users_empno]</td>";
                                  echo  "<td style='white-space: nowrap;'>$row[users_email]</td>";

                                  $user_id=$row['users_id'];

                                  $this->db->select('group_name');
                                  $this->db->from('groups');
                                  $this->db->where('group_id',$row['users_role']);
                                  
                                  $query = $this->db->get();
                                  
                                  $role = $query->row_array();
                                  $role=$role['group_name'];
                                  
                                  echo  "<td style='white-space: nowrap;'>$role</td>";

                                  echo 
                                  "   <td style='width: 30px;'>
                                          <a href=".base_url('user/check_access')."?mid=0012&id=$user_id role='button' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i></a>
                                  ";    // base_url must be the url saved in the database (table:modules_list)
                                        // mid (module ID) must be the module_id saved in the database (table:modules_list)

                                  echo $row['users_status'] == "active" ?
                                  "   
                                      <button class='deactivate_rec btn btn-danger btn-xs'
                                            data-id='$row[users_empno]' 
                                            data-toggle='modal' data-target='#myModal2'><i class='fa fa-minus'></i></button>
                                      "
                                      :
                                      "  
                                      <button class='activate_rec btn btn-success btn-xs' 
                                            data-id='$row[users_empno]'
                                            data-toggle='modal' data-target='#myModal3'><i class='fa fa-plus'></i></button>
                                      </td>";
                                  echo "</tr>";
                                }
                             ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
  </div>
</div>

<footer class="main-footer">
    <strong>© <?php echo date("Y");?> | AMTI</strong>
</footer>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" style="margin-left:-2px; font-size:22px;" id="myModalLabel">Deactivate Account</h4>
      </div>
      
      <div class="modal-body">
        
      <br>
        <input type="hidden" name="users_empno" id="users_empno" class="form-control"/>
        <label for="users_empno" style="font-size:16px;font-weight:normal;">Are you sure you want to deactivate this account?</label>
      <br><br>
        
      </div>
      <div class="modal-footer">
       
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button class="deactivate_account btn btn-primary">Yes</button>
      
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" style="margin-left:-2px; font-size:22px;" id="myModalLabel">Activate Account</h4>
      </div>
      
      <div class="modal-body">
        
        <br>
          <label for="users_empno" style="font-size:16px;font-weight:normal;">Are you sure you want to activate this account?</label>
        <br><br>

      </div>
      <div class="modal-footer">
       
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button class="activate_account btn btn-primary">Yes</button>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
  
      $('#users-table').DataTable({});

      $(document).on("click", ".deactivate_account", function() { 

            var empno=$("#users_empno").val();
            
            $.ajax({
              type:"post",
              url: "<?php echo base_url(); ?>" + "index.php/user/user_data_submit",
              data:"empno="+empno+"&action=deactivate_account",
              
              success:function(data){

                window.location.reload();
              }
            });
          });

      $(document).on("click", ".activate_account", function() { 

            var empno=$("#users_empno").val();

              
                  $.ajax({
                        type:"post",
                        url: "<?php echo base_url(); ?>" + "index.php/user/user_data_submit",
                        data:"empno="+empno+"&action=activate_account",
                        
                        success:function(data){
          
                          window.location.reload();
                        }
          
                  });

      });

      $(document).on("click", ".deactivate_rec", function() {
        var empno = $(this).data('id');        
        $("#users_empno").val(empno);

      });

      $(document).on("click", ".activate_rec", function() {
        var empno = $(this).data('id');        
        $("#users_empno").val(empno);
     
      });

  </script>