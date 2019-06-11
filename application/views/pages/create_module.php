<?php $this->load->view('templates/temp'); ?>
<body class="skin-blue sidebar-mini sidebar-mini-collapsed sidebar-collapse">

  <div class="wrapper">
    <div class="content-wrapper">
      <section class="content">
        
        <div class="row">
          <div class="col-lg-3"> </div>
          <div class="col-lg-6">
          <div class="col-xs-12">
            <div class="box box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Add Module<i class="fa fa-plus-square" style="margin-left: 10px;"></i></h3>
              </div>

              <form class="form-horizontal" method="post" action="<?php echo base_url('module/edit'); ?>">
                <div class="box-body">

                  <?php 
                    if ($this->session->flashdata('alert')) {
                      echo $this->session->flashdata('alert');
                    }
                  ?>

                  <br>
                  
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Module Name: </label>
                    <div class="col-sm-6">
                      <input name="module_name" id="module_name" class="form-control" type="text" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Url: </label>
                    <div class="col-sm-6">
                      <input name="module_url" id="module_url" class="form-control" type="text" required>
                    </div>
                  </div>

                  <div class="row">
                  <div class="col-lg-3"> </div>
                  <div class="col-lg-6"> 
                <input type="checkbox" name="module_level" id="module_level">    Requires additional variable(s)
               </div>
               <div class="col-lg-3"> </div>
               </div>
               <br>

                <div class="box-footer">
                  <a href="javascript: history.go(-1)">
                    <button class="btn btn-default btn-flat" type="button">
                      Cancel
                      <i class="fa fa-remove" style="margin-left: 5px;"></i>
                    </button>
                  </a>
                  <button class="btn btn-info btn-flat pull-right" type="submit" name="add">
                    Save Module
                    <i class="fa fa-save" style="margin-left: 5px;"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
       <div class="col-lg-3"> </div>
      </section>

    </div>

    <footer class="main-footer">
        <strong>© <?php echo date("Y");?> | AMTI</strong>
    </footer>

  </div>