<body class="skin-blue sidebar-mini sidebar-mini-collapsed sidebar-collapse">
<?php $this->load->view('templates/temp'); ?>

  <div class="wrapper">
    <div class="content-wrapper">
      <section class="content">

        <div class="row">
         <div class="col-lg-2"> </div>
          <div class="col-lg-8">

            <div class="box box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Move Order Prooflist  <i class="fa fa-area-chart" style="margin-left: 10px;"></i></h3>
              </div>

              <div class="form-horizontal" method="post" action="<?php echo base_url('main/'); ?>">

                <div class="box-body">

                <!-- <?php 
                        $admin = $this->session->userdata('role');
                        if($admin == '0001'){
                          echo  '<div class="form-group">
                              <label class="col-sm-3 control-label" for="SR_ID">SR ID: </label>
                              <div class="col-sm-5">
                                 <input type="text" style="text-transform:uppercase;" class="form-control" name="sales_rep_ids" id="sales_rep_ids" required/>
                              </div>
                          </div>';
                        }

                        // in case na gusto ni admin mag manual input. pero parang ayaw nya yata kaya okay lang
                ?>  -->

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Start"> Date (From) : </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control datepickers" id="JO_date_start" placeholder="This is a required parameter" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="End"> Date (To) : </label>
                    <div class="col-sm-5">
                       <input type="text" class="form-control datepickers" id="JO_date_end" placeholder="This is a required parameter" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Customer">Customer Name : </label>
                    <div class="col-sm-5">
                       <input list="customerlist" type="text" style='text-transform:uppercase;' disabled class="form-control" name="customer" id="customer" autocomplete="off" style="text-transform:uppercase" required/>
                       <!-- <datalist id="customerlist"></datalist> -->
                    </div>
                    <button type="button" class="col-sm-1 search_customer btn btn-primary" style="width:30px; margin-top:3px; margin-left:-8px;" title='Search Customer'><i class="fa fa-search" style="margin-left:-5px;"></i></button>
                    <button id="clear_customer" type="button" class="col-sm-1 btn btn-primary" style="width:30px; margin-top:3px; margin-left:5px;" title='Clear Customer'><i class="fa fa-remove" style="margin-left:-5px;" ></i></button>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Item_Code">Item Code : </label>
                    <div class="col-sm-5">
                       <input list="itemlist" type="text" style='text-transform:uppercase;' disabled class="form-control" name="item" id="item" autocomplete="off" style="text-transform:uppercase" required/>
                      <!--  <datalist id="itemlist"></datalist> -->
                    </div>
                    <button type="button" class="col-sm-1 search_item btn btn-primary" style="width:30px; margin-top:3px; margin-left:-8px;" title='Search Item'><i class="fa fa-search" style="margin-left:-5px;"></i></button>
                    <button id="clear_item" type="button" class="col-sm-1 btn btn-primary" style="width:30px; margin-top:3px; margin-left:5px;" title='Clear Item'><i class="fa fa-remove" style="margin-left:-5px;" ></i></button>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="PO">JO Number : </label>
                    <div class="col-sm-5">
                       <input type="text" style='text-transform:uppercase;' class="form-control" name="jo_number" id="jo_number" required/>

                      <?php 

                        $user_id = $this->session->userdata('userid');
                        $fname = $this->session->userdata('fname');
                        $lname = $this->session->userdata('lname');

                        $query = $this->db->get_where('sales_reps' , array('user_id' => $user_id));
                        $res = $query->result_array();

                        echo "<input type='hidden' name='fname' id='fname' value='$fname'>";
                        echo "<input type='hidden' name='lname' id='lname' value='$lname'>";



                        // $user_id = $this->session->userdata('userid');
                        // $empno = $this->session->userdata('empno');

                        // $query = $this->db->get_where('sales_reps' , array('user_id' => $user_id));
                        // $res = $query->result_array();

                        // echo "<input type='hidden' name='empno' id='empno' value='$empno'>";

                      ?>

                       <select multiple style="display: none;" name="sales_rep_ids[]" id="sales_rep_ids">

                        <?php foreach ($res as $sales_rep_id) : ?> 

                        <option selected><?php echo $sales_rep_id['salesrep_id']; ?></option>

                        <?php 

                        
                        endforeach; ?>
                         
                       </select>

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

                    <button class="btn btn-info btn-flat pull-right" onclick='setURL()'>
                    Submit
                   
                   </button>

                  </div>

                </div>
              </div>
            </div>
          </div>
        <div class="col-lg-2"> </div>
      </div>
    </section>

  </div>

  <footer class="main-footer">
    <strong>
      © <?php echo date("Y");?> | AMTI</strong>
  </footer>

  </div>

</body>
</html>

<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-top:-10px;">×</button>
        <h4 class="modal-title">Customer Name</h4>
      </div>
      <div class="modal-body">
        <table id="customer_modal" class="table table-striped table_bordered table-hover" style="white-space:nowrap;" width="100%">
          
          <thead>
            <tr>
                <th style="white-space:nowrap;">Customer Name</th>
             <!--  <th style="white-space:nowrap;">Account Manager</th> -->

            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="itemModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-top:-10px;">×</button>
        <h4 class="modal-title">Item Code</h4>
      </div>
      <div class="modal-body">
        
            <table id="item_modal" class="table table-striped table_bordered table-hover" style="white-space:nowrap;" width="100%">
          
          <thead>
            <tr>
                <th style="white-space:nowrap;">Item </th>
                <th style="white-space:nowrap;">Description</th>

            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>


<div id='loader' style="position: absolute; top: 30%; right: 50%; display: none; color: #3c8dbc; font-size: 20px;">
 <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
<span class="sr-only" id="ima">Loading...</span> 
</div>



<script type="text/javascript">

  $('.datepickers').datepicker({
    autoclose: true,
    todayHighlight: true ,
    format: "yyyy-mm-dd"
  });

  function setURL() {
  
    var result = [];
    var user_sales_list = [];
    var start = $("#JO_date_start").val();
    var end = $("#JO_date_end").val();
    var customer = $("#customer").val();
    var CPO = $("#jo_number").val();
    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var ls_msg ="";

    var request=$.ajax({       //------------------------- Get all salesrep id where sales manager = user

      type:"post", 
      url:"../user/user_data_submit", 
      data:"fname="+fname+"&lname="+lname+"&action=search_manager_salesrep_id",
      dataType:"json", 
      success:function(data){

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

        var salesrep_id = document.getElementById("sales_rep_ids");

        for (var j = 0; j < salesrep_id.length; j++) {
          
          var in_list = user_sales_list.indexOf(salesrep_id.options[j].value);

          if (in_list==-1) {
            user_sales_list.push(salesrep_id.options[j].value);
          }
        }
        
        user_sales_list.sort();
        var SmyDate = new Date(start);
        var SnewDate = jQuery.format.date(SmyDate, "yyyy-MM-dd");

        var EmyDate = new Date(end);
        EmyDate.setDate(EmyDate.getDate()+1);
        var EnewDate = jQuery.format.date(EmyDate, "yyyy-MM-dd");


        //Form Validation
        if(start == ""){

          ls_msg = "Date (From)";
        }

        if(end == ""){

          if (ls_msg != ""){
             ls_msg = ls_msg + ", ";
           }
           ls_msg = ls_msg + "Date (To)";
        }

        if(ls_msg != ""){

        alert("Please provide the following required field/s: "  + ls_msg);
        }
        else {
        var str = $("#item").val();
        var res = str.substr(0, 15);

        var report = "http://birt.amti.com.ph:8080/birt4-4/frameset?__report=AMTI_Move_Order_Prooflist.rptdesign&ls_salesrep_id="+user_sales_list.join(",")+"&ld_Start_Date="+SnewDate+"&ld_End_Date="+EnewDate+"&ls_Customer_Name="+customer+"&ls_JO_Number="+CPO+"&ls_items="+res;

        popup = window.open(report, "popup", "menubar=0,toolbar=0,location=0,height=900,width=1000");
        popup.window.moveTo(950, 150); 

       } 

    });

  }

  $(document).on("click", ".search_customer", function() { 

      //var search=$("#customer").val();
     // var list=$("#customerlist").val();
      //var options = $('customerlist').val().childNodes;
      var customer_records = [];
      var customer_record = [];
      var user_sales_list = [];
      var salesrep_id = document.getElementById("sales_rep_ids");

        for (var j = 0; j < salesrep_id.length; j++) {
          
          var in_list = user_sales_list.indexOf(salesrep_id.options[j].value);

          if (in_list==-1) {
            user_sales_list.push(salesrep_id.options[j].value);
          }
        }

      $.ajax({
        type:"post",url:"../user/user_data_submit",
        data:"salesrep_id="+user_sales_list.join(",")+"&action=search_customer",
        dataType:"json",
        beforeSend: function() {
        $('#loader').show();
          },
         complete: function(){
         $('#loader').hide();
          },
        success:function(data){

          for(var i=0;i<data.length; i++) {

              var value = [];
              value[0] = data[i].customer;
              // value[1] = data[i].accountmanager;
              customer_records.push(value);  
          } 

          $('#customer_modal').DataTable({
              data: customer_records,
              "bDestroy": true,
              "bAutoWidth": false,
              "fnDrawCallback": function() {

                var tbl = document.getElementById("customer_modal");
                if (tbl != null) {
                    for (var i = 0; i < tbl.rows.length; i++) {
                        for (var j = 0; j < tbl.rows[i].cells.length; j++) {
                            tbl.rows[i].cells[j].ondblclick = (function (i, j) {
                                return function () {

                                    for (var k = customer_record.length; k > 0; k--) {
                                        
                                        customer_record.pop();
                                    }

                                    for (var l = 0; l < tbl.rows[i].cells.length; l++) {

                                        customer_record.push(tbl.rows[i].cells.item(l).innerHTML); 
                                    }
   
                                    $("#customer").val(customer_record[0]);

                                    $('#myModal').modal('hide');
                                };
                            }(i, j));
                        }
                      }
                    }
                  },


                  
              });

              $('#myModal').modal('show');     
          }
      });    
     // }
  });


    $(document).on("click", ".search_item", function() { 

      //var search=$("#customer").val();
     // var list=$("#customerlist").val();
      //var options = $('customerlist').val().childNodes;
      var item_records = [];
      var item_record = [];
      var user_sales_list = [];


      $.ajax({
        type:"post",
        url:"../user/user_data_submit",
        data:"action=search_item",
        dataType:"json",
        beforeSend: function() {
        $('#loader').show();
          },
         complete: function(){
         $('#loader').hide();
          },
        success:function(data){

          for(var i=0;i<data.length; i++) {

              var value = [];
              value[0] = data[i].item;
              value[1] = data[i].description;
              item_records.push(value);  
          } 

          $('#item_modal').DataTable({
              data: item_records,
              "bDestroy": true,
              "bAutoWidth": false,
              "fnDrawCallback": function() {

                var tbl = document.getElementById("item_modal");
                if (tbl != null) {
                    for (var i = 0; i < tbl.rows.length; i++) {
                        for (var j = 0; j < tbl.rows[i].cells.length; j++) {
                            tbl.rows[i].cells[j].ondblclick = (function (i, j) {
                                return function () {

                                    for (var k = item_record.length; k > 0; k--) {
                                        
                                        item_record.pop();
                                    }

                                    for (var l = 0; l < tbl.rows[i].cells.length; l++) {

                                        item_record.push(tbl.rows[i].cells.item(l).innerHTML); 
                                    }
   
                                    $("#item").val(item_record[0]);

                                    $('#itemModal').modal('hide');
                                };
                            }(i, j));
                        }
                      }
                    }
                  },


                  
              });

              $('#itemModal').modal('show');     
          }
      });    
     // }
  });

$("#clear_customer").click( function(){
   $("#customer").val('');
});

$("#clear_item").click( function(){
   $("#item").val('');
});



</script>

<style>
  
tbody > tr > td
{
  cursor: pointer;
}

</style>