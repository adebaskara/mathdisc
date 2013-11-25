
	<?php
		// isi template_part bisa langsung konten utama
		// atau boleh diapit oleh .row .col-xx-*
		$this->load->view($template_part, array(
			'page_title' => $page_title
		)); 

		foreach ($scripts as $script) {
			$this->load->view('scripts/' . $script);
		}
	?>
