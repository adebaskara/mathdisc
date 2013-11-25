<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo base_url('assets/css/metro-bootstrap.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/metro-bootstrap-responsive.css'); ?>" rel="stylesheet">

<script src="<?php echo base_url('assets/js/jquery/jquery.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery/jquery.widget.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/metro/metro-notify.js') ?>"></script>
<script src="<?php echo base_url('assets/js/metro/metro-progressbar.js') ?>"></script>
<script src="<?php echo base_url('assets/js/metro/metro-tab-control.js') ?>"></script>


<?php 
	foreach ($scripts as $script) {
		$this->load->view('scripts/' . $script);
	}
?>