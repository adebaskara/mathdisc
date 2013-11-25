<script id="geografi_script" type="text/javascript">

$(document).ready(function() {
	if ($('#provinsi').val() == '') {
		$('#kabupaten').prop('disabled', true);
	}
	
	$('#provinsi').change(function() {
		var provinsi = this.value;
		$('#kabupaten').val('');
		if (provinsi == '') {
			$('#kabupaten').prop('disabled', true);
			$('#kabupaten option').each(function() {
				$(this).show();
			});
		} else {
			$('#kabupaten').prop('disabled', false);
			$('#kabupaten option').each(function() {
				if($(this).data('provinsi') != provinsi) {
					$(this).hide();
				} else {
					$(this).show();
				}
			});
		}
	});
});

</script>