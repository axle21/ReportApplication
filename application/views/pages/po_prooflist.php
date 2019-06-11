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
                <h3 class="box-title">PO Prooflist - Summary<i class="fa fa-area-chart" style="margin-left: 10px;"></i></h3>
              </div>

              <div class="form-horizontal" method="post" action="<?php echo base_url('main/'); ?>">

                <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Start">PO <input type="radio" name="dateflag" value="0"  /> </label>
                    
                    <label class="col-sm-2 control-label" for="Start">From Date : </label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control datepickers" id="start_date" placeholder="Required parameter" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Start">RR <input type="radio" name="dateflag" value="1"  /> </label>   
                    <label class="col-sm-2 control-label" for="End">To Date : </label>
                    <div class="col-sm-3">
                       <input type="text" class="form-control datepickers" id="end_date" placeholder="Required parameter" required/>
                    </div>
                </div>

              <div class="form-group">
                    <label class="col-sm-3 control-label" >Vendor Name : </label>
                    <div class="col-sm-5">
                       <input list="itemlist" type="text" style='text-transform:uppercase;' disabled class="form-control" name="vendor_name" id="vendor_name" autocomplete="off" style="text-transform:uppercase" required/>
                      <!--  <datalist id="itemlist"></datalist> -->
                    </div>
                    <button type="button" class="col-sm-1 search_vendor btn btn-primary" style="width:30px; margin-top:3px; margin-left:-8px;" title='Search Vendor'><i class="fa fa-search" style="margin-left:-5px;"></i></button>
                    <button id="clear_vendor" type="button" class="col-sm-1 btn btn-primary" style="width:30px; margin-top:3px; margin-left:5px;" title='Clear Vendor'><i class="fa fa-remove" style="margin-left:-5px;" ></i></button>
              </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="End">PO Number : </label>
                    <div class="col-sm-5">
                       <input type="text" class="form-control" name="po_number" id="po_number" />
                    </div>
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
    format: "dd-M-yy"
  });

  function setURL() {
    var flag_date = $("input[name='dateflag']:checked").val();
    var start = $("#start_date").val();
    var end = $("#end_date").val();
    var po_number = $("#po_number").val();
    var vendor_name = $("#vendor_name").val();
    var ls_validation, ls_msg = "";
  
        // if(start == "" && end == "" ){   
        //   alert("From Date and To Date Required.");
          
        // }
        // else if(start == "" ){
        //   alert("Start Date Required.");
          
        // }
        // else if(end == ""){
        //   alert("End Date Required.");
          
        // }
        // else if( flag_date == ""){
        //   alert("Please select on radio button.");
          
        // }
         
        // else{
        //   var report = "http://birt.amti.com.ph:8080/birt4-4/frameset?__report=AMTI_PO_PROOFLIST_SUMMARY.rptdesign&ld_start_date="+ start + "&ld_end_date="+ end + "&date_flag=" + flag_date +"&po_number="+ po_number +"&vendor_name="+ vendor_name;

        //    popup = window.open(report, "popup", "menubar=0,toolbar=0,location=0,height=900,width=1000");
        //  popup.window.moveTo(950, 150); 
        // } 

        
        //Form Validation

        if(start == ""){

          ls_msg = "From Date";
        }

        if(end == ""){

          if (ls_msg != ""){
             ls_msg = ls_msg + ", ";
           }
           ls_msg = ls_msg + "To Date";
        }

        if(flag_date == null){

          if (ls_msg != ""){
             ls_msg = ls_msg + ", ";
              }
           ls_msg = ls_msg + "Date Flag"
        }

        if(ls_msg != ""){

        alert("Please provide the following required field/s: "  + ls_msg);
        }
        else{
        var report = "http://birt.amti.com.ph:8080/birt4-4/frameset?__report=AMTI_PO_PROOFLIST_SUMMARY.rptdesign&ld_start_date="+ start + "&ld_end_date="+ end + "&date_flag=" + flag_date +"&po_number="+ po_number +"&vendor_name="+ vendor_name;

          popup = window.open(report, "popup", "menubar=0,toolbar=0,location=0,height=900,width=1000");
          popup.window.moveTo(950, 150); 
        }
  }

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

  $("#clear_vendor").click( function(){
   $("#vendor_name").val('');
});


</script>


<style>
  
tbody > tr > td
{
  cursor: pointer;
}

</style>