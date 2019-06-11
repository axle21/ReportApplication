<?php
// $this->load->view('templates/header');
  if($this->session->userdata('role')=='0001') {
    echo "<title> ADMIN </title>";
  }
  else {
    echo "<title> AMTI </title>";
  }
?>

<!-- <body class="skin-blue sidebar-mini sidebar-mini-collapsed sidebar-collapsed"> -->

    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url('main/home');?>" class="logo">
          
          <span class="logo-mini">AMTI</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><font size="2">Accent Micro Technologies Inc.</font></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <!-- <li class="dropdown user user-menu" style="pointer-events:none;opacity:0.8;">     disable <li> -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs">
                  
             Greetings, <?php echo ucfirst($this->session->userdata('fname'))." ".ucfirst($this->session->userdata('lname'));?>
                  </span>
                </a>
                
                <ul class="dropdown-menu">
                  <li class="user-footer">

                      <a href="<?php echo base_url('main/change_password');?>" class="btn btn-default"><i class="fa fa-lock"></i><span>Change Password</span></a>
                    
                      <a href="<?php echo base_url('main/logout');?>" class="btn btn-default" style="margin-top:10px;"><i class="fa fa-sign-out"></i><span>Logout</span></a>
                    
                  </li>
                  
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <aside class="main-sidebar">

        <section class="sidebar">

          <ul class="sidebar-menu">
            <!-- <li class="header"></li> -->
            <?php 

                if($this->session->userdata('is_logged')) {

                  $user_uname= $this->session->userdata('username');
                  $permission_id1 = array();
                  $module_id1 = array();
                  $additional_module_id1 = array();
                    
                  // check permissions under group

                  $result = $this->user_model->check_user_id($user_uname);

                  if($result != "none") {

                      $user_id=$result;
                      $result = $this->user_model->check_group_archive($user_id);

                      if($result != "none") {
                      
                          $group_id=$result;
                          $result = $this->user_model->check_permission_1($group_id);

                          if($result != "none") {
                              
                              foreach($result as $id) {
                                  
                                  $permission_id=$id['permission_id'];

                                  $result = $this->user_model->check_permission_archive($permission_id);
                                  
                                  if ($result != "none") {

                                    foreach($result as $id) {
                                          $permission_name=$id['permission_name']; 
                                          $permission_icon=$id['permission_icon'];

                                          $permission_id1[] = array(
                                          'permission' => $permission_id,
                                          'permission_name' => $permission_name,
                                          'permission_icon' => $permission_icon);
                                      }

                                      $result2 = $this->user_model->check_module($permission_id);
                                      foreach($result2 as $id2) {
                                      
                                          $module_id=$id2['module_id'];
                                          $result3 = $this->user_model->check_module_archive2($module_id);
                                          
                                          foreach($result3 as $id3) {
                                  
                                              $module_id1[] = array(
                                                  'permission' => $permission_id,
                                                  'module' => $id3['module_id'],
                                                  'module_url' => $id3['module_url'],
                                                  'module_name' => $id3['module_name']
                                              );
                                          }      
                                      }
                                  }

                                  else {}
                              }       
                          }

                          else {}
                      }

                      else {}
                  }

                  else {}

                  // check permissions_additional

                  $result = $this->user_model->check_user_id($user_uname);

                  if($result != "none") {
                      $user_id=$result;
                      $result = $this->user_model->check_permission_2($user_id);

                      if($result != "none") {
                                  
                          foreach($result as $id) {
                                      
                              $permission_id=$id['permission_id'];

                              $result = $this->user_model->check_permission_archive($permission_id);

                              if ($result != "none") {

                                  foreach($result as $id) {
                                          $permission_name=$id['permission_name']; 
                                          $permission_icon=$id['permission_icon'];

                                          $permission_id1[] = array(
                                          'permission' => $permission_id,
                                          'permission_name' => $permission_name,
                                          'permission_icon' => $permission_icon);
                                      }

                                  $result2 = $this->user_model->check_module($permission_id);
                                  foreach($result2 as $id2) {
                                          
                                      $module_id=$id2['module_id'];
                                      $result3 = $this->user_model->check_module_archive2($module_id);
                                      
                                      foreach($result3 as $id3) {
                                          
                                          $module_id1[] = array(
                                          'permission' => $permission_id,
                                          'module' => $id3['module_id'],
                                          'module_url' => $id3['module_url'],
                                          'module_name' => $id3['module_name']);            
                                      }             
                                  }
                              }

                              else {}
                          }                 
                      }

                      else {}
                  }

                  else {} 

                  // check modules_additional

                  $result = $this->user_model->check_user_id($user_uname);

                  if($result != "none") {
                      $user_id=$result;
                         
                      $result2 = $this->user_model->check_additional_module($user_id);
                      foreach($result2 as $id) {
                              
                          $module_id=$id['module_id'];
                          $result3 = $this->user_model->check_module_archive2($module_id);
           
                          foreach($result3 as $id2) {
                              
                              $additional_module_id1[] = array(
                              'module' => $id2['module_id'],
                              'module_url' => $id2['module_url'],
                              'module_name' => $id2['module_name']);            
                          }             
                      } 
                  }

                  else {} 
                      
                 $permissions = array();
                 $modules = array();
                 foreach($permission_id1 as $id) {

                    if (in_array($id['permission'], $permissions)) {

                    }

                    else {
                          $permission_id=$id['permission'];
                          $permission_name=$id['permission_name'];
                          $permission_icon=$id['permission_icon'];

                          echo "<li class='treeview'>";
                          echo "<a href='#'>";
                          echo "<i class='$permission_icon'></i> <span>$permission_name</span> <i class='fa fa-angle-left pull-right'></i>";
                          echo "</i></a><ul class='treeview-menu'>";

                              foreach($module_id1 as $id1) {

                                  if ($id1['permission'] == $permission_id) {
                                                        
                                        if (in_array($id1['module'], $modules)) {
                                                         
                                        }

                                        else {
                                              $module_id=$id1['module'];
                                              $module_name=$id1['module_name'];

                                              $module_url = explode("/", $id1['module_url']);      
                                              $module_url = $module_url[0]."/".$module_url[1];    
                                              

                                              echo "<li><a href=".base_url("$module_url")."?mid=$module_id title='$module_name'><i class='fa fa-circle-o'></i>$module_name</a><li>";

                                              array_push($modules, $module_id);
                                        }
                                  }                
                              }
                          echo "</ul>";
                          echo "</li>";

                          array_push($permissions, $permission_id);
                        }
                    }

                    echo "<li class='header'></li>";

                    foreach($additional_module_id1 as $id1) {

                      if (in_array($id1['module'], $modules)) {
                                                       
                      }

                      else {
                              $module_id=$id1['module'];
                              $module_name=$id1['module_name'];

                              $module_url = explode("/", $id1['module_url']);      
                              $module_url = $module_url[0]."/".$module_url[1];    

                              echo "<li class=' treeview'>";
                              echo "<a href=".base_url("$module_url")."?mid=$module_id>";
                              echo "<i class='fa fa-circle-o'></i><span>$module_name</span>";
                              echo "</i></a></li>";

                              array_push($modules, $module_id);                               
                        } 
                    }
                }

                else
                { 
                  redirect('main/login');

                }

            ?>

         </ul>
      </section>
  </aside>

  <script type="text/javascript">
    
    var idleTime = 0;
    $(document).ready(function () {
        
        idleInterval = setInterval(timerIncrement, 100);

        $('body').mousemove(function (e) {
          idleTime = 0;
        });

        $('body').keypress(function (e) {
          idleTime = 0;
        });

        $('body').click(function() {
          idleTime = 0;
        });
    });

    function timerIncrement() {
      
        idleTime = idleTime + 1;
        if (idleTime == 9000) {             // ----------------------------------- session expires after 15 minutes of inactivity
            alert('Your session has expired');
            window.location ="http://reports.amti.com.ph/main/logout";
        }
    }
  </script>
