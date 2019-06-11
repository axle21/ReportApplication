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
                <h3 class="box-title">PMG MONITORING<i class="fa fa-line-chart" style="margin-left:10px;"></i></h3>
              </div>

              <div class="form-horizontal">

                <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="start_date">Start Date: </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control datepickers" id="start_date">
                    </div>
                </div>

     
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="start_date">End Date: </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control datepickers" id="end_date">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="Line_business">Line of Business: </label>
                    <div class="col-sm-5">
                            <select class="form-control select2" name="line" id="line" style="width: 100%;">
                                <option selected disabled> Please Select </option>
                                <option>All Unit</option>
                                <option>CISCO - Osel Aguilar</option>
                                <option>DELL - Vlad Banares</option>
                                <option>Harry De Leon</option>
                                <option>HP INC. - Edna Jugado</option>
                                <option>HP Enterprise - Butch Dizon</option>
                                <option>Huawei - Ericka Bacungan</option>
                                <option>Jun Sister</option>
                                <option>LENOVO - Rosannie Macaraeg</option>
                                <option>PERIPHERAL - Anavie Albiar</option>
                                <option>SOFTWARE - Jason Taopo</option>
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

<script>

  $('.datepickers').datepicker({
      autoclose: true,
      format: "yyyy-mm-dd"
  });


  function setURL() {
      var SD = $("#start_date").val();
      var ED = $("#end_date").val();  
      var line = $("#line").val();
      var ls_msg = "";

        //Form Validation
        if(SD == ""){

          ls_msg = "Date (From)";
        }

        if(ED == ""){

          if (ls_msg != ""){
             ls_msg = ls_msg + " , ";
           }
           ls_msg = ls_msg + "Date (To)";
        }

        if(line == null){

          if (ls_msg != ""){
             ls_msg = ls_msg + " , ";
           }
           ls_msg = ls_msg + "Line of Business";
        }

        if(ls_msg != ""){

        alert("Please provide the following required field/s: "  + ls_msg);
        }
        else {
        var report = "http://birt.amti.com.ph:8080/birt4-4/frameset?__report=PMG_Report.rptdesign&Start_Date="+ SD +"&End_Date="+ ED +"&Where="+ line;

      popup = window.open(report, "popup", "menubar=0,toolbar=0,location=0,height=900,width=1000");
      popup.window.moveTo(950, 150);
    }
    
  }
</script>