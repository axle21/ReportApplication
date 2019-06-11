<?php $this->load->view('templates/temp'); ?>
<body class="skin-blue sidebar-mini sidebar-mini-collapsed sidebar-collapse">

  <div class="wrapper">
    <div class="content-wrapper">
      <section class="content">

        <div class="row">
         <div class="col-lg-2"> </div>
          <div class="col-lg-8">
          
            <div class="box box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">STOCK CARD<i class="fa fa-line-chart" style="margin-left: 10px;"></i></h3>
              </div>

              <div class="form-horizontal">

                <div class="box-body">

                  <br>
                  <div class="form-group">
                      <label class="col-sm-4 control-label" for="password_new">Subinventory Code: </label>
                      <div class="col-sm-5">
                        <input list="inventory" type="text" class="form-control" name="Sub_Inventory_Code" id="Sub_Inventory_Code" disabled="" />
                      </div>
                      <button type="button" class="col-sm-1 search_subinventory btn btn-primary" style="width:30px; margin-top:3px; margin-left:-8px;" title='Search Sub Inventory Code'><i class="fa fa-search" style="margin-left:-5px;"></i></button>
                       <button id="clear_inv" type="button" class="col-sm-1 btn btn-primary" style="width:30px; margin-top:3px; margin-left:5px;" title='Clear Sub Inventory Field'><i class="fa fa-remove" style="margin-left:-5px;"></i></button>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-4 control-label" for="Item_Code">Item Code: </label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" name="Item_Code" id="Item_Code" disabled/>
                      </div>
                      <button type="button" class="col-sm-1 search_item btn btn-primary" style="width:30px; margin-top:3px; margin-left:-8px;" title='Search Item'><i class="fa fa-search" style="margin-left:-5px;"></i></button>
                       <button id="clear_item_code" type="button" class="col-sm-1 btn btn-primary" style="width:30px; margin-top:3px; margin-left:5px;" title='Clear Item Field'><i class="fa fa-remove" style="margin-left:-5px;"></i></button>
                 
                  </div>

                  <br>

                  <div class="box-footer">
                    <a href="<?php echo base_url('main/home'); ?>">
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
        <div class="col-lg-2"> </div>
      </div>
    </section>

  </div>

  <footer class="main-footer">
  <strong>

    © <?php echo date("Y");?> | AMTI</a>

  </footer>

</div>

      <div class="modal fade" id="itemModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-top:-10px;">×</button>
              <h4 class="modal-title">Customer Name</h4>
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

        <div class="modal fade" id="itemModal" >
          <div class="modal-dialog modal-lg" style="max-width: 700px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-top:-10px;">×</button>
                <h4 class="modal-title">Item Code</h4>
              </div>
              <div class="modal-body">
                
                    <table id="item_modal" class="table table-striped table_bordered table-hover" >
                  
                  <thead>
                    <tr>
                        <th style="white-space:nowrap; width: 200px;">Sub Inventory Code </th>
                        <th style="white-space:nowrap;">Description </th>
                  
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


<script>

    function setURL() {

        var SIC = $("#Sub_Inventory_Code").val();
        var SIC_upper = SIC.toUpperCase();
        var IC =$("#Item_Code").val();  
        var IC_upper = IC.toUpperCase();   
        var ls_validation, ls_msg = "";   
        
        //Form Validation
        if(SIC == ""){

          ls_msg = "Sub Inventory Code";
        }

        if(IC == ""){

          if (ls_msg != ""){
             ls_msg = ls_msg + ", ";
           }
           ls_msg = ls_msg + "Item Code";
        }

        if(ls_msg != ""){

        alert("Please provide the following required field/s: "  + ls_msg);
        }
        else {

        var report = "http://birt.amti.com.ph:8080/birt4-4/frameset?__report=AMTI_StockCard.rptdesign&SubInventory_Code=" + SIC_upper + "&Item_Code=" + IC_upper;

        popup = window.open(report, "popup", "menubar=0,toolbar=0,location=0,height=900,width=1000");
            popup.window.moveTo(950, 150);
        }
    }

    $('#Sub_Inventory_Code').on('input',function(){

    var search=$("#Sub_Inventory_Code").val().toUpperCase();
    var list=document.getElementById('inventory');

    if (search != "") {

      $.ajax({

        type:"post", url:"../user/user_data_submit", data:"search="+search+"&action=search_subinventory",
        dataType:"json", success:function(data){

          $("#inventory").empty();

          for(var i=0;i<data.length; i++) {

            var option = document.createElement('option');
            option.value = data[i].subinventory.toUpperCase();
            list.appendChild(option); 
          }
        }
      });
    }
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
   
                                    $("#Item_Code").val(item_record[0]);

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


     $(document).on("click", ".search_subinventory", function() { 

      //var search=$("#customer").val();
     // var list=$("#customerlist").val();
      //var options = $('customerlist').val().childNodes;
      var item_records = [];
      var item_record = [];


      $.ajax({
        type:"post",
        url:"../user/user_data_submit",
        data:"action=search_subinventory",
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
              value[0] = data[i].subinventory;
              value[1] = data[i].description;
             
              
             
              item_records.push(value);  
          } 

          $('#item_modal').DataTable({
            "order": [ 0, 'asc' ],
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
   
                                    $("#Sub_Inventory_Code").val(item_record[0]);

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



//clear Function
$("#clear_item_code").click( function(){
   $("#Item_Code").val('');
});    
$("#clear_inv").click( function(){
   $("#Sub_Inventory_Code").val('');
}); 
</script>
<style>
  
tbody > tr > td
{
  cursor: pointer;
}

</style>