<script id="login_script" type="text/javascript">

$(document).ready(function() {
	$('#tombol_submit_form_login').click(function() {
		$('#progress-message').text('Login diproses');
		$('#progress-bar .progress').removeClass('hidden').addClass('active');
		$('#progress-bar .progress-bar').removeClass('progress-bar-danger').addClass('progress-bar-info');
		$.post(
			$('#form_login').attr('action'),
			$('#form_login').serialize(),
			function(json) {
				if (json.sukses) {
					window.location = json.redirect;
				} else {
					$('#progress-bar .progress').removeClass('active');
					$('#progress-bar .progress-bar').removeClass('progress-bar-info').addClass('progress-bar-danger');
					// re-captcha
					$('#recaptcha_reload').click();
					// tampilkan peringatan login gagal
					$('#progress-message').text(json.message);
				}
			},
			'json'
		);
		
		return false;
	});
});

</script>
