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
                <h3 class="box-title">PO Prooflist - Detailed<i class="fa fa-area-chart" style="margin-left: 10px;"></i></h3>
              </div>

              <div class="form-horizontal" method="post" action="<?php echo base_url('main/'); ?>">

                <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="order_date_start">Order Date (From) : </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control datepickers" id="order_date_start" placeholder="This is a required parameter" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="order_date_end">Order Date (To) : </label>
                    <div class="col-sm-5">
                       <input type="text" class="form-control datepickers" name="order_date_end" id="order_date_end" placeholder="This is a required parameter" required/>
                    </div>
                </div>

                 <div class="form-group">
                    <label class="col-sm-3 control-label" >Vendor Name : </label>
                    <div class="col-sm-5">
                       <input list="itemlist" type="text" style='text-transform:uppercase;' disabled class="form-control" name="vendor_name" id="vendor_name" autocomplete="off" style="text-transform:uppercase" required/>
                      <!--  <datalist id="itemlist"></datalist> -->
                    </div>
                    <button type="button" class="col-sm-1 search_vendor btn btn-primary" style="width:30px; margin-top:3px; margin-left:-8px;" title='Search Vendor'><i class="fa fa-search" style="margin-left:-5px;"></i></button>
                    <button id="clear_customer" type="button" class="col-sm-1 btn btn-primary" style="width:30px; margin-top:3px; margin-left:5px;" title='Clear Vendor'><i class="fa fa-remove" style="margin-left:-5px;" ></i></button>
                 </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label" for="po_number">PO Number : </label>
                    <div class="col-sm-5">
                       <input type="text" class="form-control" name="po_number" id="po_number" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" >Item Code : </label>
                    <div class="col-sm-5">
                       <input list="itemlist" type="text" style='text-transform:uppercase;' disabled class="form-control" name="item" id="item" autocomplete="off" style="text-transform:uppercase" required/>
                      <!--  <datalist id="itemlist"></datalist> -->
                    </div>
                    <button type="button" class="col-sm-1 search_item btn btn-primary" style="width:30px; margin-top:3px; margin-left:-8px;" title='Search Item'><i class="fa fa-search" style="margin-left:-5px;"></i></button>
                    <button id="clear_item_code" type="button" class="col-sm-1 btn btn-primary" style="width:30px; margin-top:3px; margin-left:5px;" title='Clear Item'><i class="fa fa-remove" style="margin-left:-5px;" ></i></button>
                 
                </div>

                <div class="box-footer">
                  <a href="javascript: history.go(-1)">
                    <button class="btn btn-default btn-flat" type="button">
                      Cancel
                      <i class="fa fa-remove" style="margin-left: 5px;"></i>
                    </button>
                  </a>

                    <button class="btn btn-info btn-flat pull-right" onclick='setURL()'>Submit </button>

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

 <!-- Item Modal -->

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

<div class="modal fade" id="vendorModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-top:-10px;">×</button>
        <h4 class="modal-title">Vendor Name</h4>
      </div>
      <div class="modal-body">
        
            <table id="vendor_modal" class="table table-striped table_bordered table-hover" style="white-space:nowrap;" width="100%">
          
          <thead>
            <tr>
                <th style="white-space:nowrap;">Vendor Name </th>
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





</body>
</html>




<script type="text/javascript">

  $('.datepickers').datepicker({
    autoclose: true,
    todayHighlight: true ,
    yearRange: "-60:+0",
    changeMonth: true,
    changeYear: true,
    format: "yyyy-mm-dd"
  });

  function setURL() {
  
    var start = $("#order_date_start").val();
    var end = $("#order_date_end").val();
    var po_number = $("#po_number").val();
    var vendor_name = $("#vendor_name").val();
    var item_number = $("#item").val();
    var ls_msg ="";
    

        var SmyDate = new Date(start);
        var SnewDate = jQuery.format.date(SmyDate, "yyyy-MM-dd");

        var EmyDate = new Date(end);
        EmyDate.setDate(EmyDate.getDate()); //+1 removed
        var EnewDate = jQuery.format.date(EmyDate, "yyyy-MM-dd");

        //Form Validation

        if(start == ""){

          ls_msg = "Date (From)";
        }

        if(end == ""){

          if (ls_msg != ""){
             ls_msg = ls_msg + " , ";
           }
           ls_msg = ls_msg + "Date (To)";
        }

        if(ls_msg != ""){

        alert("Please provide the following required field/s: "  + ls_msg);
        }
        else {
          var report = "http://birt.amti.com.ph:8080/birt4-4/frameset?__report=AMTI_PO_PROOFLIST_DETAILED.rptdesign&start_date="+SnewDate +"&end_date="+EnewDate+"&po_number="+ po_number +"&vendor_name="+ vendor_name+"&item_number="+ item_number;

        popup = window.open(report, "popup", "menubar=0,toolbar=0,location=0,height=900,width=1000");
        popup.window.moveTo(950, 150); 
        }

 

  }


  $(document).on("click", ".search_item", function() { 

      //var search=$("#customer").val();
     // var list=$("#customerlist").val();
      //var options = $('customerlist').val().childNodes;
      var item_records = [];
      var item_record = [];


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

    $(document).on("click", ".search_vendor", function() { 


      var vendor_records = [];
      var vendor_record = [];


      $.ajax({
        type:"post",
        url:"../user/user_data_submit",
        data:"action=search_vendor",
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
              value[0] = data[i].vendor_name;

              vendor_records.push(value);  
          } 

          $('#vendor_modal').DataTable({
              data: vendor_records,
              "bDestroy": true,
              "bAutoWidth": false,
              "fnDrawCallback": function() {

                var tbl = document.getElementById("vendor_modal");
                if (tbl != null) {
                    for (var i = 0; i < tbl.rows.length; i++) {
                        for (var j = 0; j < tbl.rows[i].cells.length; j++) {
                            tbl.rows[i].cells[j].ondblclick = (function (i, j) {
                                return function () {

                                    for (var k = vendor_record.length; k > 0; k--) {
                                        
                                        vendor_record.pop();
                                    }

                                    for (var l = 0; l < tbl.rows[i].cells.length; l++) {

                                        vendor_record.push(tbl.rows[i].cells.item(l).innerHTML); 
                                    }
   
                                    $("#vendor_name").val(vendor_record[0]);

                                    $('#vendorModal').modal('hide');
                                };
                            }(i, j));
                        }
                      }
                    }
                  },


                  
              });

              $('#vendorModal').modal('show');     
          }
      });    
     // }
  });


$("#clear_customer").click( function(){
   $("#vendor_name").val('');
});

$("#clear_item_code").click( function(){
   $("#item").val('');
});



</script>


<style>
  
tbody > tr > td
{
  cursor: pointer;
}

</style>