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
                <h3 class="box-title">SO Prooflist<i class="fa fa-area-chart" style="margin-left: 10px;"></i></h3>
              </div>

              <div class="form-horizontal" method="post" action="<?php echo base_url('main/'); ?>">

                <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="order_date_start">SO Date (From) : </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control datepickers" id="so_date_start" placeholder="This is a required parameter" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="order_date_end">SO Date (To) : </label>
                    <div class="col-sm-5">
                       <input type="text" class="form-control datepickers" id="order_date_end" placeholder="This is a required parameter" required/>
                    
                      <?php 

                        $user_id = $this->session->userdata('userid');
                        $fname = $this->session->userdata('fname');
                        $lname = $this->session->userdata('lname');

                        $query = $this->db->get_where('sales_reps' , array('user_id' => $user_id));
                        $res = $query->result_array();

                        echo "<input type='hidden' name='fname' id='fname' value='$fname'>";
                        echo "<input type='hidden' name='lname' id='lname' value='$lname'>";

                      ?>

                       <select multiple style="display: none;" name="sales_rep_ids[]" id="sales_rep_ids">

                        <?php foreach ($res as $sales_rep_id) : ?> 

                        <option selected><?php echo $sales_rep_id['salesrep_id']; ?></option>

                        <?php endforeach; ?>
                         
                       </select>

                    </div>
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
  
    var result = [];
    var user_sales_list = [];
    var start = $("#so_date_start").val();
    var end = $("#order_date_end").val();
    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var ls_msg = "";

    var request=$.ajax({       //------------------------- Get all salesrep id where sales manager = user

      type:"post", url:"../user/user_data_submit", data:"fname="+fname+"&lname="+lname+"&action=search_manager_salesrep_id",
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

        //For Form Validation
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

        var report = "http://birt.amti.com.ph:8080/birt4-4/frameset?__report=AMTI_SO_PROOFLIST.rptdesign&ls_salesrep_id="+user_sales_list.join(",")+"&ld_start_date="+SnewDate+"&ld_end_date="+EnewDate;

        popup = window.open(report, "popup", "menubar=0,toolbar=0,location=0,height=900,width=1000");
        popup.window.moveTo(950, 150); 
      }

    });

  }

</script>