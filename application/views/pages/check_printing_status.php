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
                <h3 class="box-title">CHECK PRINTING STATUS<i class="fa fa-line-chart" style="margin-left: 10px;"></i></h3>
              </div>

              <div class="form-horizontal">

                <div class="box-body">

                  <br>
                  <div class="form-group">
                      <label class="col-sm-3 control-label" for="order_number">Order Number: </label>
                      <div class="col-sm-5">
                        <input type="text" style='text-transform:uppercase;' class="form-control" name="order_number" id="order_number" required/>
                      </div>
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

    � <?php echo date("Y");?> | AMTI</a>

  </footer>

</div>

<script>

    function setURL() {

        var ordernum = $("#order_number").val();
             
        

        if(ordernum == null || ordernum == "") {
            alert("Order Number Field Required.");
        }
        else {
          

        var report = "http://birt.amti.com.ph:8080/birt4-4/frameset?__report=AMTI_CHECK_STAT.rptdesign&li_Order_num=" + ordernum;

        popup = window.open(report, "popup", "menubar=0,toolbar=0,location=0,height=900,width=1000");
            popup.window.moveTo(950, 150);
        }
    }
</script>