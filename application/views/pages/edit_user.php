<body class="skin-blue sidebar-mini sidebar-mini-collapsed sidebar-collapse">
<?php $this->load->view('templates/temp'); ?>

  <div class="wrapper">
    <div class="content-wrapper">
      <section class="content">

      <?php 
          $result;
          $module_id;
          if (!empty($_GET['id'])) {

              $user_id=addslashes($_GET['id']);
              $this->db->select('*');
              $this->db->from('users');
              $this->db->where('users_id',$user_id);

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

        <form class="form-horizontal" method="post" action="<?php echo base_url('user/register'); ?>">
        <div class="row">
          <div class="col-lg-2"> </div>
          <div class="col-lg-8">
            <div class="box box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title" style="margin-top:8px;">Edit User<i class="fa fa-pencil" style="margin-left: 10px;"></i></h3>
                <button class="btn btn-primary btn-flat pull-right" type="submit" name="submit3">
                    Reset Password
                    <i class="fa fa-lock" style="margin-left: 5px;"></i>
                </button>
              </div>
                <div class="box-body">

                  <?php 
                    if ($this->session->flashdata('alert')) {
                      echo $this->session->flashdata('alert');
                    }
                  ?>

                  <br>

                  <?php              
                  
                    $this->db->select('*');
                    $this->db->from('users');
                    $this->db->where('users_id',$user_id);
                    $query = $this->db->get();
                    $row = $query->row_array();
                    echo "<input type='hidden' name='user_id' id='user_id' class='input-txt' value='$user_id'/>";
                    echo "<input type='hidden' name='user_role' id='user_role' class='input-txt' value='$row[users_role]'/>";
                    echo "<input type='hidden' name='username' id='username' class='input-txt' value='$row[users_uname]'/>";

                    echo "<div class='form-group'>
                      <label class='col-sm-3 control-label' for='users_empno'>Employee Number: </label>
                      <div class='col-sm-3'>
                        <input name='users_empno' value='$row[users_empno]' class='form-control' type='text' maxlength = '8' required>
                      </div>

                      <label class='col-sm-1 control-label' for='users_uname' style='margin-left:-18px; margin-right:18px;'>Username: </label>
                      <div class='col-sm-3'>
                        <input name='users_uname' value='$row[users_uname]' class='form-control' type='text'  style='text-transform:uppercase' required>
                      </div>
                    </div>";

                    echo "<div class='form-group'>
                      <label class='col-sm-3 control-label' for='users_fname'>First Name: </label>
                      <div class='col-sm-3'>
                        <input name='users_fname' id='users_fname' value='$row[users_fname]' class='form-control' type='text' required>
                      </div>

                      <label class='col-sm-1 control-label' for='users_lname' style='margin-left:-10px; margin-right:10px;'>Surname: </label>
                      <div class='col-sm-3'>
                        <input name='users_lname' id='users_lname' value='$row[users_lname]' class='form-control' type='text' required>
                      </div>
                    </div>";

                     echo "<div class='form-group'>
                      <label class='col-sm-3 control-label' for='users_uname'>Email: </label>
                      <div class='col-sm-3'>
                        <input name='users_email' value='$row[users_email]' class='form-control' type='text'>
                      </div>

                      <label class='col-sm-1 control-label' for='group_id' style='margin-left:10px; margin-right:-10px;'>Role: </label>
                      <div class='col-sm-3'>
                        <select class='form-control' name='group_id' id='group_id' required></select>
                      </div>
                    </div>";

                  ?>

                  <div class="row">
                    <div class="col-sm-11">

                      <label class="col-sm-3 control-label"> </label>

                      <div class="col-sm-4" style="margin-left:12px;">
                        <div class="xhead"><center><b>Permission</b></center></div>
                        <div id="permissions_list" style="overflow-y:scroll;max-height:180px;"></div>
                      </div>

                      <div class="col-sm-4"  style="margin-left:-7px;">
                        <div class="xhead"><center><b>Modules</b></center></div>
                        <div id="modules_list" style="overflow-y:scroll;max-height:180px;">
                        </div>
                      </div>
                          
                    </div>
                  </div>

                  <br>

                  <div id="salesdiv" style="display:none;">
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Sales Representative: </label>
                      <div class="col-sm-7">
                        <input list="sales" name="sales_record" id="sales_record" class="form-control" type="text" autocomplete="off"  style="text-transform:uppercase">
                        <datalist id="sales"></datalist>
                      </div>
                      <button type="button" class="col-sm-1 add_sales btn btn-success" style="width:30px; margin-top:3px; margin-left:-8px;" title='Add Salesrep'><i class="fa fa-plus" style="margin-left:-4px;"></i></button>
                    </div>

                    <div class="form-group" >
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-7">
                        <select id="salesselect" name="salesselect[]" class="form-control" size="5px" style="padding: 7px;" multiple="multiple"></select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-7">

                        <table id="saleslist" class="table table-striped table-bordered table-hover" style="white-space:nowrap;text-align:center;font-size:14px;" title='Double-click to Delete'>
                          <thead>
                            <tr class="xhead" style="font-size:14px;">
                              <th width="20%" style="white-space:nowrap;height:3px;line-height:3px;"><p style="margin-top:0px;margin-bottom:1px;text-align:center;">Operating Unit</p></th>
                              <th width="55%" style="white-space:nowrap;height:3px;line-height:3px;"><p style="margin-top:0px;margin-bottom:1px;text-align:center;">BU Head</p></th>
                              <th width="25%" style="white-space:nowrap;height:3px;line-height:3px;"><p style="margin-top:0px;margin-bottom:1px;text-align:center;">Business Unit</p></th>
                            </tr>
                          </thead>
                        </table>
                      </div>
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
                  <button class="btn btn-info btn-flat pull-right" type="submit" name="submit2">
                    Save User
                    <i class="fa fa-save" style="margin-left: 5px;"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>

    <footer class="main-footer">
        <strong>© <?php echo date("Y");?> | AMTI</strong>
    </footer>

  </div>

<script type="text/javascript">

  for(i=group_id.options.length-1; i >= 0; i--){group_id.remove(i);}
  var sales_list=[];  
  var user_sales_list=[];
  var role=$("#user_role").val();
  var userid=$("#user_id").val();
  var result=[];
            
  var request=$.ajax({
    type:"post",
    url:"../user/user_data_submit",
    data:"action=group_retrieve",
    dataType:"json",
    success:function(data){

      for(var i=0;i<data.length; i++) {

        var select=document.getElementById("group_id");
        var opt=document.createElement("option");
        opt.value=data[i].id;
            
        opt.innerHTML=data[i].name;

        if (data[i].id == role) {

            opt.setAttribute('selected', true);
        }

        select.add(opt); 
      }

      permissions_list();

      var group_id=$("#group_id").val();

       if(group_id == "0012" || group_id == "0019"  || group_id == "0022") {        // ----------------------------------------------- group_id of "Sales" in groups(table)

        document.getElementById('salesdiv').style.display = "block";
      }

      else {

        document.getElementById('salesdiv').style.display = "none";
      }  
    }
  });

  result.push(request);
                    
  $.when.apply(null, result).done(function() {

      result.pop(); 

      var request=$.ajax({       //------------------------------------------------------ Get all salesrep id assigned to user

        type:"post", url:"../user/user_data_submit", data:"userid="+userid+"&action=search_user_salesrep_id",
        dataType:"json", success:function(data){

          for(var i=0;i<data.length; i++) {

            var in_list = user_sales_list.indexOf(data[i].salesrep);

            if (in_list==-1) {

              user_sales_list.push(data[i].salesrep);
            }
          } 
        }
      });

      result.push(request);
                     
      $.when.apply(null, result).done(function() {

          var sales_record=[];
          result.pop();

          for(i=salesselect.options.length-1; i >= 0; i--){salesselect.remove(i);}

          for(var i=0;i<user_sales_list.length; i++) {
     
            var request=$.ajax({
            type:"post", url:"../user/user_data_submit", data:"search="+user_sales_list[i]+"&action=search_salesrep",
            dataType:"json", success:function(data){

                for(var j=0;j<data.length; j++) { 

                  var value = [];
                  value[0] = data[j].branch;
                  value[1] = data[j].manager;
                  value[2] = data[j].unit;
                  value[3] = data[j].salesrep;
                  value[4] = data[j].id;
                  sales_record.push(value);

                  if($("#salesselect option[value='"+data[j].salesrep+"']").length > 0) {}
                  else {
                      var select=document.getElementById("salesselect");
                      var opt=document.createElement("option");
                      opt.value=data[j].salesrep;
                          
                      opt.innerHTML=data[j].salesrep;
                      opt.selected=true;
                      select.add(opt);
                  }
                }
              }
            });

            result.push(request);
          } 

          $.when.apply(null, result).done(function() {

              $('#saleslist').DataTable({
                data: sales_record,
                "bDestroy": true,
                "bAutoWidth": false,
                "fnDrawCallback": function() {

                  var tbl = document.getElementById("saleslist");
                  for (var i = 1; i < tbl.rows.length; i++) {
                    tbl.rows[i].ondblclick = (function(i) {
                      return function() {

                        var value = $(this).closest('tr').children('td:eq(3)').text();
                        var id = $(this).closest('tr').children('td:eq(4)').text();
                        $("#salesselect option[value='"+value+"']").remove();
                        
                        for (var a = 0; a < sales_list.length; a++) {
                          if (sales_list[a] == id) {
                              sales_list.splice(a);
                              break;
                          }
                        }

                        for (var b = 0; b < user_sales_list.length; b++) {
                          if (user_sales_list[b] == value) { 
                              user_sales_list.splice(b);
                              break;
                          }
                        }

                        $(this).closest('tr').remove();
                      };
                    }(i));
                  }
                },
                "aoColumns": [{ sWidth: '20%' },{ sWidth: '55%' },{ sWidth: '25%' }],
                "columnDefs": [{className: "hide_column", "targets": [3,4]},
                  {className: "cursor_row", "targets": [0,1,2]},
                  {orderData: [0,2], targets: [0]}],
                "paging": false,
                "info": false,
                "bFilter": false
              });
          });
      });
  });

  function permissions_list() {

      var group_id=$("#group_id").val();
      var user_id=$("#user_id").val();
      var additional_permissions = [];
      var additional_modules = [];
      var permissions = [];
      var modules_list = [];
      var result1 = [];
      
        $.ajax({

            type:"post", url:"../user/user_data_submit", data:"group_id="+group_id+"&action=permission_retrieve",
            dataType:"json", success:function(data){

              document.getElementById('permissions_list').innerHTML = "";
              document.getElementById('modules_list').innerHTML = "";

                  for(var i=0;i<data.length; i++) {

                      permissions.push(data[i]);
                  }

                  var request = $.ajax({
                  type:"post", url:"../user/user_data_submit", data:"user_id="+user_id+"&action=additional_permission_retrieve",
                  dataType:"json", success:function(data){

                      for(var i=0;i<data.length; i++) {

                          additional_permissions.push(data[i]);
                      }
                    }
                  });

                  result1.push(request);

                  $.when.apply(null, result1).done(function() {

                      result1.pop();

                      $.ajax({
                      type:"post", url:"../user/user_data_submit", data:"action=permissions_list_retrieve",
                      dataType:"json", success:function(data){

                        for(var i=0;i<data.length; i++) {

                            var in_list = permissions.indexOf(data[i].id);

                            var permission = document.createElement("input");
                            permission.type= 'checkbox';
                            
                            permission.name = 'permission_id[]';
                            permission.id = data[i].id;
                            permission.value = data[i].id;
                            document.getElementById('permissions_list').appendChild(permission);

                            var permission=data[i].id;
                            var label = document.createElement("label");
                            var text = document.createTextNode("   "+data[i].name);
                            var br = document.createElement("br");
                            var div = document.getElementById('permissions_list');
                            div.appendChild(text);
                            div.appendChild(br);  

                            if (group_id != "0002") {

                              if (in_list!=-1) {

                                document.getElementById(permission).checked = true;
                                document.getElementById(permission).disabled = true; 
                              }
                              
                              else {

                                var in_list = additional_permissions.indexOf(data[i].id);

                                if (in_list!=-1) {

                                    document.getElementById(permission).checked = true;
                                }   
                              }
                            }

                            else {

                              document.getElementById(permission).disabled = true; 
                            }
                          }
                       }
                    });
                }); 

                for(var i=0; i<permissions.length; i++) {

                    var request = $.ajax({
                      type:"post", url:"../user/user_data_submit", data:"permission_id="+permissions[i]+"&action=modules_retrieve",
                      dataType:"json", success:function(data){ 
                        
                        for(var j=0; j<data.length; j++) {

                            modules_list.push(data[j]);
                        }
                      }
                  });

                  result1.push(request);
                }

                $.when.apply(null, result1).done(function() { 

                    for(var i=0; i<additional_permissions.length; i++) {

                        var request = $.ajax({
                          type:"post", url:"../user/user_data_submit", data:"permission_id="+additional_permissions[i]+"&action=modules_retrieve",
                          dataType:"json", success:function(data){ 
                            
                            for(var j=0; j<data.length; j++) {

                                modules_list.push(data[j]);
                            }
                          }
                      });

                      result1.push(request);
                    }

                    result1.pop();

                    $.when.apply(null, result1).done(function() { 

                    var request = $.ajax({
                    type:"post", url:"../user/user_data_submit", data:"user_id="+user_id+"&action=additional_modules_retrieve",
                    dataType:"json", success:function(data){ 
                      
                      for(var j=0; j<data.length; j++) {

                          additional_modules.push(data[j]);
                      }
                    }
                    });

                    result1.push(request);
                    
                    $.when.apply(null, result1).done(function() { 

                        $.ajax({
                          type:"post", url:"../user/user_data_submit", data:"action=modules_list_retrieve",
                          dataType:"json", success:function(data){

                              for(var i=0;i<data.length; i++) {

                                var in_list = modules_list.indexOf(data[i].id);

                                var modules = document.createElement("input");
                                modules.type= 'checkbox';
              
                                modules.name = 'module_id[]';
                                modules.id = data[i].name;
                                modules.value = data[i].id;
                                document.getElementById('modules_list').appendChild(modules);

                                var label = document.createElement("label");
                                var text = document.createTextNode("   "+data[i].name);
                                document.getElementById('modules_list').appendChild(text);
                                document.getElementById('modules_list').appendChild(document.createElement("br"));

                                if (group_id != "0002") {

                                  if (in_list!=-1) {
                                
                                      document.getElementById(data[i].name).checked = true;
                                      document.getElementById(data[i].name).disabled = true;
                                  }
                                  
                                  else {
                                    var in_list = additional_modules.indexOf(data[i].id);

                                    if (in_list!=-1) {

                                      document.getElementById(data[i].name).checked = true;
                                    }    
                                  }
                                }

                                else {

                                  document.getElementById(data[i].name).disabled = true;
                                }
                              }
                            }
                        });
                    });
                });  
              });   
            }        
        });
     }

     $(document).on('change', '#permissions_list input:checkbox', function() {
          modules_list();
     });

     function modules_list() {

        document.getElementById('modules_list').innerHTML = "";

        var user_id=$("#user_id").val();
        var additional_modules = [];
        var permissions = [];
        var modules_list = [];
        var result = [];

        $('#permissions_list input:checkbox:checked').each(function() {
            permissions.push(this.id);
        });

        for(var i=0; i<permissions.length; i++) {

            var request = $.ajax({
              type:"post", url:"../user/user_data_submit", data:"permission_id="+permissions[i]+"&action=modules_retrieve",
              dataType:"json", success:function(data){ 
                
                for(var j=0; j<data.length; j++) {

                    modules_list.push(data[j]);
                }
              }
          });

          result.push(request);
        }

        $.when.apply(null, result).done(function() {

          result.pop();

          var request = $.ajax({
          type:"post", url:"../user/user_data_submit", data:"user_id="+user_id+"&action=additional_modules_retrieve",
          dataType:"json", success:function(data){ 
            
            for(var j=0; j<data.length; j++) {

                additional_modules.push(data[j]);
            }
          }
          });

          result.push(request);
          
          $.when.apply(null, result).done(function() {

            result.pop();

            $.ajax({
              type:"post", url:"../user/user_data_submit", data:"action=modules_list_retrieve", 
              dataType:"json", success:function(data){

                for(var i=0;i<data.length; i++) {

                  var in_list=modules_list.indexOf(data[i].id);

                  var modules=document.createElement("input");
                  modules.type='checkbox';

                  modules.name='module_id[]';
                  modules.id=data[i].name;
                  modules.value=data[i].id;
                  document.getElementById('modules_list').appendChild(modules);

                  var module_id=data[i].name;
                  
                  var label=document.createElement("label");
                  var text=document.createTextNode("   "+data[i].name);
                  document.getElementById('modules_list').appendChild(text);
                  document.getElementById('modules_list').appendChild(document.createElement("br"));

                  if (in_list!=-1) {

                      document.getElementById(data[i].name).checked=true;
                      document.getElementById(data[i].name).disabled=true; 
                  }
                  
                  else {

                    var in_list=additional_modules.indexOf(data[i].id);

                    if (in_list!=-1) {

                        document.getElementById(data[i].name).checked=true;
                    }
                  }
                }
              }
          });
        });
    });
  }           

  $('#group_id').change(function(){
  
        var group_id=$("#group_id").val();

       if(group_id == "0012" || group_id == "0019"  || group_id == "0022") {  // ------------------------------------------------------- group_id=sales in groups(table)

          document.getElementById('salesdiv').style.display = "block";
        }

        else {

          document.getElementById('salesdiv').style.display = "none";
        }   

        permissions_list();
  }); 

  $('#users_fname').on('input',function(){

      var search=$("#users_fname").val().toUpperCase();
      var splitStr = search.toLowerCase().split(' ');
      for (var i = 0; i < splitStr.length; i++) {
           
          splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
      }

      $("#users_fname").val(splitStr.join(' ')); 
          
  });

  $('#users_lname').on('input',function(){

      var search=$("#users_lname").val().toUpperCase();
      var splitStr = search.toLowerCase().split(' ');
      for (var i = 0; i < splitStr.length; i++) {
           
          splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
      }
      
      $("#users_lname").val(splitStr.join(' ')); 
          
  });  
  
  $('#sales_record').on('input',function(){

    var search=$("#sales_record").val().toUpperCase();
    var result=[];
    var list=document.getElementById('sales');
    
    if (search != "") {

      $.ajax({

        type:"post", url:"../user/user_data_submit", data:"search="+search+"&action=search_sales_list",
        dataType:"json", success:function(data){

          $("#sales").empty();

          for(var i=0;i<data.length; i++) {

              var option = document.createElement('option');
              option.value = data[i].name.toUpperCase();
              list.appendChild(option); 
          }
        }
      });
    }
  });

 
  $(document).on("click", ".add_sales", function() { 
        
      var search=$("#sales_record").val();
      var result=[];
      var sales_record=[];

    
      var request=$.ajax({

        type:"post",
        url:"../user/user_data_submit",
        data:"search="+search+"&action=search_sales",
        dataType:"json",
        success:function(data){

          if (!$.trim(data)){   
            alert("No record retrieved");
          }

          else {

            for(var i=0;i<1; i++) {

              var in_list = sales_list.indexOf(data[i].id);

              if (in_list==-1) {

                sales_list.push(data[i].id);   
              }
            }
          }
        }
      });

      result.push(request);
                     
      $.when.apply(null, result).done(function() {

          result.pop();
          for(i=salesselect.options.length-1; i >= 0; i--){salesselect.remove(i);}

          for(var i=0;i<sales_list.length; i++) {
     
            var request=$.ajax({
            type:"post",url:"../user/user_data_submit",data:"search="+sales_list[i]+"&action=search_sales",
            dataType:"json",success:function(data){

                for(var j=0;j<data.length; j++) { 

                  var value = [];
                  value[0] = data[j].branch;
                  value[1] = data[j].manager;
                  value[2] = data[j].unit;
                  value[3] = data[j].salesrep;
                  value[4] = data[j].id;
                  sales_record.push(value);

                  if($("#salesselect option[value='"+data[j].salesrep+"']").length > 0) {}
                  else {
                      var select=document.getElementById("salesselect");
                      var opt=document.createElement("option");
                      opt.value=data[j].salesrep;
                          
                      opt.innerHTML=data[j].salesrep;
                      opt.selected=true;
                      select.add(opt);
                  }
                }
              }
            });

            result.push(request);
          } 

          $.when.apply(null, result).done(function() {

              $('#saleslist').DataTable({
                  data: sales_record,
                  "bDestroy": true,
                  "bAutoWidth": false,
                  "fnDrawCallback": function() {

                    var tbl = document.getElementById("saleslist");
                    for (var i = 1; i < tbl.rows.length; i++) {
                      tbl.rows[i].ondblclick = (function(i) {
                        return function() {

                          var value = $(this).closest('tr').children('td:eq(3)').text();
                          var id = $(this).closest('tr').children('td:eq(4)').text();
                          $("#salesselect option[value='"+value+"']").remove();
                          
                          for (var a = 0; a < sales_list.length; a++) {
                            if (sales_list[a] == id) { 
                                sales_list.splice(a, 1);
                                break;
                            }
                          }

                          $(this).closest('tr').remove();
                        };
                      }(i));
                    }
                  },
                  "aoColumns": [{ sWidth: '20%' },{ sWidth: '55%' },{ sWidth: '25%' }],
                  "columnDefs": [{className: "hide_column", "targets": [3,4]},
                    {className: "cursor_row", "targets": [0,1,2]},
                    {orderData: [0,2], targets: [0]}],
                  "paging": false,
                  "info": false,
                  "bFilter": false
              });
          });
      });
  }); 
</script>

<style>
.xhead {
  position: relative;
  height: 22px;
  width: 100%;
  background-color: #3c8dbc;
  color:white;
}
.hide_column {
    display : none;
}
.cursor_row {
    cursor: pointer;
}
</style>