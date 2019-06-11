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
                <h3 class="box-title">SERVICE TAG INQUIRY<i class="fa fa-line-chart" style="margin-left: 10px;"></i></h3>
              </div>

              <div class="form-horizontal">

                <div class="box-body">

               <br>
              
              <div class="form-group">
                  <label for="Item_Code" class="col-sm-3 control-label">Service Tag :</label>
                      <div class="col-sm-5">
                            <input type="text" class="form-control" name="Serv_Number" id="Serv_Number">
                      </div>
              </div>


              <div class="form-group">
                  <label for="SIC" class="col-sm-3 control-label">Serial Number : </label>
                        <div class="col-sm-5">
                             <input type="text" class="form-control" name="Serial_Number" id="Serial_Number">
                        </div>
              </div>

                                      
              <div class="form-group">
                  <label for="Item_Code" class="col-sm-3 control-label">SI Number :</label>
                        <div class="col-sm-5">
                              <input type="text" class="form-control" name="SI_Number" id="SI_Number" placeholder="Multiple value Accepted, Seperated by comma">
                        </div>
              </div>


              <div class="form-group">
                  <label for="Item_Code" class="col-sm-3 control-label">DR Number :</label>
                        <div class="col-sm-5">
                              <input type="text" class="form-control" name="DR_Number" id="DR_Number">
                        </div>
              </div>

              <div class="form-group">
                  <label for="Item_Code" class="col-sm-3 control-label">JO Number :</label>
                        <div class="col-sm-5">
                                <input type="text" class="form-control" name="JO_Number" id="JO_Number" placeholder="Multiple value Accepted, Seperated by comma">
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
                    <!-- <i class="fa fa-save" style="margin-left: 5px;"></i> -->
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

      © <?php echo date("Y");?> | AMTI</strong>

    </footer>

  </div>

</body>
</html>

<script>
    function setURL() {


        //Form Validation
        if ( ($('#Serial_Number').val() == "")
              && ($('#JO_Number').val() == "")
              && ($('#SI_Number').val() == "")
              && ($('#DR_Number').val() == "")
              && ($('#Serv_Number').val() == "") )
        {
        alert( "Fill atleast one field to continue." );
        exit();
        }

        var SN = $('#Serial_Number').val();
        var JON = $('#JO_Number').val();
        var SIN = $('#SI_Number').val();
        var DRN = $('#DR_Number').val();
        var ServN = $('#Serv_Number').val();

        var report = "http://birt.amti.com.ph:8080/birt4-4/frameset?__report=AMTI_ServiceTagInquiry.rptdesign&SNumber=" + SN + "&JONumber=" + JON + "&SINumber=" + SIN + "&DRNumber=" + DRN + "&Servtag=" + ServN;

        popup = window.open(report, "popup", "menubar =0,toolbar=0,location=0,height=900,width=1000");
        popup.window.moveTo(950, 150);
        
        
    }
</script> 