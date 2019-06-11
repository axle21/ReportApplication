<?php $this->load->view('templates/temp'); ?>
<body class="skin-blue sidebar-mini sidebar-mini-collapsed sidebar-collapse">

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
              <h3 class="box-title">PERMISSIONS<i class="fa fa-list-ul" style="margin-left: 10px;"></i></h3>

            </div>
            <div class="box-header with-border">
              <a href="<?php echo base_url('/user/check_access?mid=0007');?>"> <button class="btn btn-primary"><i class="fa fa-plus"> Add Permission</i> </button> </a>
              </div>
              <div class="box-body">  
                <div id="users_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                  <div class="row">
                    <div class="col-sm-12">

                      <div class="table-responsive">
                        <table id="permission-table" class="table table-bordered table-hover dataTable" role="grid">
                                <thead>
                                <tr>
                                    <th>Permission</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                
                                <?php

                              $this->db->select('*');
                              $this->db->from('permissions_list');
                              
                              foreach ($this->db->get()->result_array() as $row) 
                              {
                                echo "<tr>";

                                echo  "<td style='white-space: nowrap;'>$row[permission_name]</td>";
                                echo "<td style='white-space: nowrap;'>$row[permission_description]</td>";
                                echo $row['archive'] == "0" ?
                                "   <td style='white-space: nowrap;'>Active</td>               
                                "
                                :
                                "   
                                    <td style='white-space: nowrap;'>Inactive</td>        
                                </td>";

                                echo 
                                "   <td style='width: 30px;'>
                                        <a href=".base_url('user/check_access')."?mid=0008&id=$row[permission_id] role='button' class='btn btn-warning btn-xs' title='Edit Permission'><i class='fa fa-pencil'></i></a>
                                ";    // mid = module_id of edit_permission module

                                echo $row['archive'] == "0" ?
                                "   
                                        <button class='deactivate_rec btn btn-danger btn-xs' 
                                              data-toggle='modal' data-target='#myModal2' title='Archive Permission'><i class='fa fa-minus'></i></button>    
                                    "
                                    :
                                    "   
                                        <button class='activate_rec btn btn-success btn-xs' 
                                              data-toggle='modal' data-target='#myModal3' title='Unarchive Permission'><i class='fa fa-plus'></i></button>
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
        <h4 class="modal-title" style="margin-left:-2px; font-size:22px;" id="myModalLabel">Archive Permission</h4>
      </div>
      
        <div class="modal-body">
          
          <br>
            <label style="font-size:16px; font-weight: normal;">Are you sure you want to archive this permission?</label>
          <br><br>

          <input type="hidden" name="permission_name" id="permission_name" class="input-txt"/> 

        </div>
        <div class="modal-footer">
         
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button class="archive_permission btn btn-primary">Yes</button> 
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
        <h4 class="modal-title" style="margin-left:-2px; font-size:22px;" id="myModalLabel">Unarchive Permission</h4>
        </div>
      
        <div class="modal-body">
          
          <br>
            <label style="font-size:16px; font-weight: normal;">Are you sure you want to unarchive this permission?</label>
          <br><br>
          
        </div>
        <div class="modal-footer">
         
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button class="unarchive_permission btn btn-primary">Yes</button>  
      </div>
    </div>
  </div>
</div> 

<script type="text/javascript">

      $('#permission-table').DataTable({});

       $(document).on("click", ".archive_permission", function() { 

            var permission_name=$("#permission_name").val();
          
            $.ajax({
                  type:"post",
                  url: "../permission/add_permission",
                  data:"permission_name="+permission_name+"&action=deactivate_permission",
                  
                  success:function(data){

                    window.location.reload();
                  }       
            });            
       });

       $(document).on("click", ".unarchive_permission", function() { 

            var permission_name=$("#permission_name").val();
                     
            $.ajax({
                  type:"post",
                  url: "../permission/add_permission",
                  data:"permission_name="+permission_name+"&action=activate_permission",
                  
                  success:function(data){

                    window.location.reload();
                  }        
            });           
      });


      $(document).on("click", ".deactivate_rec", function() {
        var permission_name = $(this).closest('tr').children()[0].textContent;
        $("#permission_name").val(permission_name);      
      
      });


      $(document).on("click", ".activate_rec", function() {
        var permission_name = $(this).closest('tr').children()[0].textContent;
        $("#permission_name").val(permission_name);       
           
      });

  </script>