<?php $this->load->view('templates/header');?>
<title> AMTI</title>
<body class="xbgcolor">

      <header class="xhead">
      </header>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <div class="col-xs-12 col-lg-12">             
            <div class="xbox box box-primary form-horizontal">
                    <div class="box-header with-border">
                <center><h3 class="box-title">Accent Micro Technologies Inc.</h3> </center>
              </div>
               <?php echo form_open('main/verifyUser'); ?>
                <div class="box-body">

                  <div class="form-group">

                    <div class="col-sm-12 col-lg-12">
                      <div class="inner-addon left-addon">
                        <i class="fa fa-user"></i>
                        <input placeholder="Username" name="users_uname" class="form-control" style='text-transform:uppercase;' type="text" required>
                      </div>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-12 col-lg-12">
                      <div class="inner-addon left-addon">
                        <i class="fa fa-lock"></i>
                        <input placeholder="PASSWORD" id="myPassword" name="users_pass" class="form-control" type="password" required>
                    </div>
                    
                    <span class="pull-right" src="#" onmouseover="mouseoverPass();" onmouseout="mouseoutPass();" style="cursor: pointer;">Show Password <i id="eye" class="fa fa-eye"></i>
                    </span>
                    </div>
                  </div>
                  <button class="btn col-sm-12 col-lg-12 col-xs-12 col-md-6 " type="submit" name="submit1">
                    Login
                  </button>
                  
                </div> 
            </form>           
        </div>
        <?php
            echo br(4);
            if ($this->session->flashdata('alert')) {
              echo $this->session->flashdata('alert');
            }
        ?>
                           
      </div>
    </div>
    <div class="col-md-4"></div>
  </div>

<style>

  .xbox {
    position: relative;
    top: 100px;
    border-radius: 7px;
    border-top: 6px solid #d2d6de;
    margin-bottom: 20px;
    margin-right: 20px;
    box-shadow: 0 3px 3px rgba(0, s, 0, 0.4);
  }
  .xhead {
   position: relative;
    height: 50px;
    width: 100%;
    background-color: #3c8dbc;
  }
  .xbgcolor{
    background-color: #ecf0f5;
  }

  .inner-addon { 
      position: relative; 
  }

  .inner-addon .fa {
    position: absolute;
    padding: 10px;
    pointer-events: none;
  }

  .left-addon .fa  { left:  0px;}
  .right-addon .fa { right: 0px;}

  .left-addon input  { padding-left:  30px; }
  .right-addon input { padding-right: 30px; }

 </style>


<script>

  function mouseoverPass(obj) {
    var obj = document.getElementById('myPassword');
    obj.type = "text";
    document.getElementById("eye").className = "fa fa-eye-slash";
  }

  function mouseoutPass(obj) {
    var obj = document.getElementById('myPassword');
    obj.type = "password";
    document.getElementById("eye").className = "fa fa-eye";
  }

</script>