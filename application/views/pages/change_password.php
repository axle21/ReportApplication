<body class="skin-blue sidebar-mini sidebar-mini-collapsed sidebar-collapse">
<?php $this->load->view('templates/temp'); ?>

  <div class="wrapper">
    <div class="content-wrapper">
      <section class="content">
        <?php 

          if ($this->session->userdata('userid')) {

              $user_id= $this->session->userdata('userid');
              $user_uname= $this->session->userdata('username');

              $this->db->select('*');
              $this->db->from('users');
              $this->db->where('users_id',$user_id);

              $query = $this->db->get();

              if ($query->num_rows() == 0){
                  redirect('main/access_denied');
                  exit();
              }

              else{}       
            }

            else {

              $this->load->view('templates/header');
              $this->load->view('pages/home');
              exit();
            }
        ?>

        <div class="row">
         <div class="col-lg-3"> </div>
          <div class="col-lg-6">

          <?php 
              if ($this->session->flashdata('alert')) {
                
                echo $this->session->flashdata('alert');
              }
          ?>

            <div class="box box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Change Password<i class="fa fa-pencil" style="margin-left: 10px;"></i></h3>
                <div style='float:right;'>
                    <label style='font-weight:normal; font-size:17px;'>You are logged in as</label><label style='font-weight:bold; font-size:17px;'><?php echo nbs(2), strtoupper($user_uname);?></label>
                </div>
              </div>

              <form class="form-horizontal" method="post" action="<?php echo base_url('user/edit'); ?>">
                <div class="box-body">

                <?php
                  
                    $this->db->select('*');
                    $this->db->from('users');
                    $this->db->where('users_id',$user_id);
                    $query = $this->db->get();
                    $row = $query->row_array();

                    echo "<input type='hidden' name='user_id' id='user_id' class='input-txt' maxlength='20' value='$user_id'/>";   
                    echo "<input type='hidden' name='user_password' id='user_password' class='input-txt' value='$row[users_pass]'/>" 
                ?>

              <br>
               
              <div class="form-group">
                    <label class="col-sm-3 control-label" for="password_old">Current Password: </label>
                    <div class="col-sm-6">
                      <input type="password" name="password_old" id="password_old" placeholder="Current Password" maxlength="20" class="form-control pass" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="password_new">New Password: </label>
                    <div class="col-sm-6">
                      <input type="password" name="password_new" id="password_new" placeholder="New Password" maxlength="20" class="form-control pass" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="password_confirm">Confirm Password: </label>
                    <div class="col-sm-6">
                      <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirm Password" maxlength="20" class="form-control pass" required/>
                      <span class="pull-right" src="#" onmouseover="mouseoverPass();" onmouseout="mouseoutPass();" style="cursor: pointer;">Show Password <i id="eye" class="fa fa-eye"></i>
                    </span>
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
                  <button class="btn btn-info btn-flat pull-right" type="submit" name="save_password">
                    Save Password
                    <i class="fa fa-save" style="margin-left: 5px;"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        <div class="col-lg-3"></div>
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <strong>
      © <?php echo date("Y");?> | AMTI</a>
  </footer>
</div>

<script>

  function mouseoverPass(obj) {
    var password_old = document.getElementById('password_old');
    var password_new = document.getElementById('password_new');
    var password_confirm = document.getElementById('password_confirm');
    password_old.type = "text";
    password_new.type = "text";
    password_confirm.type = "text";
    document.getElementById("eye").className = "fa fa-eye-slash";
  }

  function mouseoutPass(obj) {
    var password_old = document.getElementById('password_old');
    var password_new = document.getElementById('password_new');
    var confirm = document.getElementById('password_confirm');
    password_old.type = "password";
    password_new.type = "password";
    password_confirm.type = "password";
    document.getElementById("eye").className = "fa fa-eye";
  }

</script>