<body class="skin-blue sidebar-mini sidebar-mini-collapsed sidebar-collapse">
<?php $this->load->view('templates/temp'); ?>

  <div class="wrapper">
    <div class="content-wrapper">
      <section class="content">

        <div class="row">
          <div class="col-lg-2"></div>
          <div class="col-lg-8">
            <div class="box box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Add User<i class="fa fa-user-plus" style="margin-left: 10px;"></i></h3>
              </div>

              <form class="form-horizontal" method="post" action="<?php echo base_url('user/register'); ?>">
                <div class="box-body">

                  <?php 
                    if ($this->session->flashdata('alert')) {
                      echo $this->session->flashdata('alert');
                    }
                  ?>

                  <br>
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="users_record">Search Employee: </label>
                    <div class="col-sm-7">
                      <input list="employees" name="users_record" id="users_record" class="form-control" type="text" autocomplete="off" style="text-transform:uppercase">
                      <datalist id="employees"></datalist>
                    </div>
                    <button type="button" class="col-sm-1 search_data btn btn-warning" style="width:30px; margin-top:3px; margin-left:-8px;" title='Search'><i class="fa fa-search" style="margin-left:-5px;"></i></button>
                  </div>
    
                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="users_empno">Employee Number: </label>
                    <div class="col-sm-3">
                      <input name="users_empno" id="users_empno" class="form-control" type="text" maxlength="8" autocomplete="off" required>
                    </div>

                    <label class="col-sm-1 control-label" for="users_uname" style="margin-left:-18px; margin-right:18px;">Username: </label>
                    <div class="col-sm-3">
                      <input name="users_uname" id="users_uname" class="form-control" type="text" style="text-transform:uppercase" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="users_fname">First Name: </label>
                    <div class="col-sm-3">
                      <input name="users_fname" id="users_fname" class="form-control" type="text" required>
                    </div>

                    <label class="col-sm-1 control-label" for="users_lname" style="margin-left:-10px; margin-right:10px;">Surname: </label>
                    <div class="col-sm-3">
                      <input name="users_lname" id="users_lname" class="form-control" type="text" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label" for="users_email">Email: </label>
                    <div class="col-sm-3">
                      <input name="users_email" id="users_email" class="form-control" type="text">
                    </div>

                    <label class="col-sm-1 control-label" for="role" style="margin-left:10px; margin-right:-10px;">Role: </label>
                    <div class="col-sm-3">
                     
                      <select class="form-control" name="group_id" id="group_id" style="padding: 7px;"></select>
                    </div>
                  </div>

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
                        <input list="sales" name="sales_record" id="sales_record" class="form-control" type="text" autocomplete="off" style="text-transform:uppercase">
                        <datalist id="sales"></datalist>
                      </div>
                      <button type="button" class="col-sm-1 add_sales btn btn-success" style="width:30px; margin-top:3px; margin-left:-8px;" title='Search'><i class="fa fa-plus" style="margin-left:-4px;"></i></button>
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
                  <button class="btn btn-info btn-flat pull-right" type="submit" name="submit1">
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

<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-top:-10px;">×</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <table id="example" class="table table-striped table_bordered table-hover" style="white-space:nowrap;" width="100%">
          
          <thead>
            <tr>
                <th style="white-space:nowrap;">First Name</th>
                <th style="white-space:nowrap;">Last Name</th>
                <th style="white-space:nowrap;">Employee #</th>
                <th style="white-space:nowrap;">Department</th>       
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  for(i=group_id.options.length-1; i >= 0; i--){group_id.remove(i);}
  var sales_list=[];

  $.ajax({
      type:"post",url:"../user/user_data_submit",data:"action=group_retrieve",
      dataType:"json",success:function(data) {

        for(var i=0;i<data.length; i++) {
        
          var select=document.getElementById("group_id");
          var opt=document.createElement("option");
          opt.value=data[i].id;
          opt.innerHTML=data[i].name;
          select.add(opt);
        }

        permissions_list();
      }
  });

  function permissions_list() {

    var group_id=$("#group_id").val();
    var permissions = [];
    var modules_list = [];
    var result = [];
  
    $.ajax({
        type:"post",url:"../user/user_data_submit",data:"group_id="+group_id+"&action=permission_retrieve",
        dataType:"json",success:function(data){

          document.getElementById('permissions_list').innerHTML = "";
          document.getElementById('modules_list').innerHTML = "";

              for(var i=0;i<data.length; i++) {

                  permissions.push(data[i]);
              }

              $.ajax({
              type:"post",url:"../user/user_data_submit",data:"action=permissions_list_retrieve",
              dataType:"json",success:function(data){

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

                    if (group_id != "0002") {  // ---------- disable every module and permission if group_id 0002 (user)

                        if (in_list!=-1) {

                            document.getElementById(permission).checked = true;
                            document.getElementById(permission).disabled = true; 
                        } 
                    }

                    else {

                        document.getElementById(permission).disabled = true; 
                    }
                  }
                }
            }); 

            for(var i=0; i<permissions.length; i++) {

              var request = $.ajax({
                  type:"post",url:"../user/user_data_submit",data:"permission_id="+permissions[i]+"&action=modules_retrieve",
                  dataType:"json",success:function(data){ 
                    
                    for(var j=0; j<data.length; j++) {

                        modules_list.push(data[j]);
                    }
                  }
              });

              result.push(request);
            }

            $.when.apply(null, result).done(function() { 

              $.ajax({
                type:"post",url:"../user/user_data_submit",data:"action=modules_list_retrieve",
                dataType:"json",success:function(data){

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

                    if (group_id != "0002") { // ---------- disable every module and permission if group_id 0002 (user)

                        if (in_list!=-1) {
                      
                            document.getElementById(data[i].name).checked = true;
                            document.getElementById(data[i].name).disabled = true; 
                        }
                    }

                    else {

                        document.getElementById(data[i].name).disabled = true; 
                    }
                  }
                }
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

        var permissions = [];
        var modules_list = [];
        var result = [];

        $('#permissions_list input:checkbox:checked').each(function() {
            permissions.push(this.id);
        });

        for(var i=0; i<permissions.length; i++) {

            var request = $.ajax({
              type:"post",url:"../user/user_data_submit",data:"permission_id="+permissions[i]+"&action=modules_retrieve",
              dataType:"json",success:function(data){ 
                
                for(var j=0; j<data.length; j++) {

                    modules_list.push(data[j]);
                }
              }
          });

          result.push(request);
        }

        $.when.apply(null, result).done(function() { 

          $.ajax({
              type:"post",url:"../user/user_data_submit",data:"action=modules_list_retrieve", 
              dataType:"json",success:function(data){

                for(var i=0;i<data.length; i++) {

                  var in_list = modules_list.indexOf(data[i].id);

                  var modules = document.createElement("input");
                  modules.type= 'checkbox';

                  modules.name = 'module_id[]';
                  modules.id = data[i].name;
                  modules.value = data[i].id;
                  document.getElementById('modules_list').appendChild(modules);

                  var module_id= data[i].name;
                  
                  var label = document.createElement("label");
                  var text = document.createTextNode("   "+data[i].name);
                  document.getElementById('modules_list').appendChild(text);
                  document.getElementById('modules_list').appendChild(document.createElement("br"));

                  if (group_id != "0002") {  // ------------ disable every module and permission if group_id 0002 (user)

                      if (in_list!=-1) {

                          document.getElementById(data[i].name).checked = true;
                          document.getElementById(data[i].name).disabled = true; 
                      }
                  }

                  else {

                      document.getElementById(data[i].name).disabled = true; 
                  }
              }
            }
        });
    });
  }           

  $('#group_id').change(function(){

      var group_id=$("#group_id").val();

      if(group_id == "0012" || group_id == "0019"  || group_id == "0022") {  // ---------------------------------------------- group_id of "Sales" in groups (table)

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

  $(document).on("click", ".search_data", function() { 

      var search=$("#users_record").val();
      var employee_records = [];
      var employee_record = [];

      $.ajax({
        type:"post",url:"../user/user_data_submit",data:"search="+search+"&action=search_data",
        dataType:"json",success:function(data){

          for(var i=0;i<data.length; i++) {

              var value = [];
              value[0] = data[i].fname;
              value[1] = data[i].lname;
              value[2] = data[i].empno;
              value[3] = data[i].department;
              value[4] = data[i].email;
              employee_records.push(value);  
          } 

          $('#example').DataTable({
              data: employee_records,
              "bDestroy": true,
              "bAutoWidth": false,
              "fnDrawCallback": function() {

                var tbl = document.getElementById("example");
                if (tbl != null) {
                    for (var i = 0; i < tbl.rows.length; i++) {
                        for (var j = 0; j < tbl.rows[i].cells.length; j++) {
                            tbl.rows[i].cells[j].ondblclick = (function (i, j) {
                                return function () {

                                    for (var k = employee_record.length; k > 0; k--) {
                                        
                                        employee_record.pop();
                                    }

                                    for (var l = 0; l < tbl.rows[i].cells.length; l++) {

                                        employee_record.push(tbl.rows[i].cells.item(l).innerHTML); 
                                    }

                                    var fname=employee_record[0].toLowerCase();
                                    var splitfname = fname.toLowerCase().split(' ');
                                    for (var a = 0; a < splitfname.length; a++) {
                                         
                                      splitfname[a] = splitfname[a].charAt(0).toUpperCase() + splitfname[a].substring(1);     
                                    }

                                    var lname=employee_record[1].toLowerCase();
                                    var splitlname = lname.toLowerCase().split(' ');
                                    for (var a = 0; a < splitlname.length; a++) {
                                         
                                      splitlname[a] = splitlname[a].charAt(0).toUpperCase() + splitlname[a].substring(1);     
                                    }

                                    $("#users_empno").val(employee_record[2]);    
                                    $("#users_fname").val(splitfname.join(' '));
                                    $("#users_lname").val(splitlname.join(' '));
                                    $("#users_email").val(employee_record[4]);

                                    username();
                                    $('#myModal').modal('hide');
                                };
                            }(i, j));
                        }
                      }
                    }
                  },
                  "aoColumns": [{ sWidth: '20%' },{ sWidth: '20%' },{ sWidth: '15%' },{ sWidth: '45%' }],
                  "columnDefs": [{className: "hide_column", "targets": [4]},
                    {className: "cursor_row", "targets": [0,1,2,3]}]
              });

              $('#myModal').modal('show');     
          }
      });    
  });

  function username() {

      var fname = $("#users_fname").val();
      var fname = fname.replace(/\s/g, '');

      var lname = $("#users_lname").val();
      var lname = lname.match(/\b(\w)/g);
      var lname = lname.join('');

      document.getElementById('users_uname').value = fname.concat(lname);
  }

  $('#users_record').on('input',function(){

      var search=$("#users_record").val().toUpperCase();
      var list = document.getElementById('employees');
      var options = document.getElementById('employees').childNodes;

      if (search != "") {

        for (var a = 0; a < options.length; a++) {
          if (options[a].value === search) {
            list.options[i] = null;
          }
        }

        $.ajax({

          type:"post",url:"../user/user_data_submit",data:"search="+search+"&action=search_data",
          dataType:"json",success:function(data){

              $("#employees").empty();

              for(var i=0;i<data.length; i++) {

                  var option = document.createElement('option');
                  option.value = data[i].empno.concat(" - ").concat(data[i].full).concat("  ").concat(data[i].department);
                  list.appendChild(option); 
              }
            }
        });   
      }
  });

  $('#sales_record').on('input',function(){

      var search=$("#sales_record").val().toUpperCase();
      var result=[];
      var list = document.getElementById('sales');
      var options = document.getElementById('sales').childNodes;

      if (search != "") {

        for (var a = 0; a < options.length; a++) {
          if (options[a].value === search) {
            list.options[i] = null;
          }
        }

        $.ajax({

            type:"post",
            url:"../user/user_data_submit",
            data:"search="+search+"&action=search_sales_list",
            dataType:"json",
            success:function(data){

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

      if(search == ""){
        alert("Please Fill Sales Representative :");
      }
      else{

    
      var request=$.ajax({

        type:"post",
        url:"../user/user_data_submit",
        data:"search="+search+"&action=search_sales",
        dataType:"json",
        success:function(data){

          if (!$.trim(data)){   
            alert("No record retrieved");
            exit();
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

    }

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