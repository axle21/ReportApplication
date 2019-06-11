<?php $this->load->view('templates/temp'); ?>
<body class="skin-blue sidebar-mini sidebar-mini-collapsed sidebar-collapse">


<div class="wrapper">
	<div class="content-wrapper">
	  	<section class="content">
			<div class="row">
			   <div class ="col-xs-2"> </div>
				<div class="col-xs-8">
					<div class="row">
						<div class="xmid">
					       <div class="box box box-primary">
		                      <div class="box-header with-border">
		                          <h3 class="box-title"><font size="5">Welcome!</font></h3>
		                      </div>
	                          <div class="box-header with-border">
	                              You are logged in as <?php echo ucfirst($this->session->userdata('username'));?>
	                          </div>
	                       </div>
	      				</div>
					</div>
				</div>
				<div class ="col-xs-2"> </div>
			</div>
	  	</section>
	</div>
</div>

<footer class="main-footer">
    <center><strong>© <?php echo date("Y");?> | AMTI</strong></center>
</footer>

