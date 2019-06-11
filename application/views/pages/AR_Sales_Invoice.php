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
                <h3 class="box-title">AMTI AR Sales Invoice<i class="fa fa-area-chart" style="margin-left: 10px;"></i></h3>
              </div>

              <div class="form-horizontal" method="post" action="<?php echo base_url('main/'); ?>">

                <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-3 control-label">SI Number (From) : </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="si_number_from" placeholder="This is a required parameter" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">SI Number (To) : </label>
                    <div class="col-sm-5">
                       <input type="text" class="form-control" id="si_number_to" placeholder="This is a required parameter" required/>
                    </div>
                </div>
<!--
              <div class="form-group">
                    <label class="col-sm-3 control-label" >Vendor Name : </label>
                    <div class="col-sm-5">
                       <input list="itemlist" type="text" style='text-transform:uppercase;' disabled class="form-control" name="vendor_name" id="vendor_name" autocomplete="off" style="text-transform:uppercase" required/>
        
                    </div>
                    <button type="button" class="col-sm-1 search_vendor btn btn-primary" style="width:30px; margin-top:3px; margin-left:-8px;" title='Search'><i class="fa fa-search" style="margin-left:-5px;"></i></button>
              </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="End">PO Number : </label>
                    <div class="col-sm-5">
                       <input type="text" class="form-control" name="po_number" id="po_number" />
                    </div>
                </div>
-->
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
<!--
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
-->

<div id='loader' style="position: absolute; top: 30%; right: 50%; display: none; color: #3c8dbc; font-size: 20px;">
        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
        <span class="sr-only" id="ima">Loading...</span> 
</div>


</body>
</html>

<script type="text/javascript">

  function setURL() {
  
    var si_from = $("#si_number_from").val();
    var si_to = $("#si_number_to").val();

      
        if(si_from == null || si_from == "" ){
          alert("Please enter SI Number.");
          exit();
        }
        else if(si_to == null || si_to == ""){
          alert("Please enter SI Number.");
          exit();
      }
         
        else
        {
          var report = "http://birt.amti.com.ph:8080/birt4-4/frameset?__report=ARSalesInvoice.rptdesign&si_number_from="+si_from +"&si_number_to="+si_to;

           popup = window.open(report, "popup", "menubar=0,toolbar=0,location=0,height=900,width=1000");
         popup.window.moveTo(950, 150); 
        }

 

  }

   
</script>


<style>
  
tbody > tr > td
{
  cursor: pointer;
}

</style>