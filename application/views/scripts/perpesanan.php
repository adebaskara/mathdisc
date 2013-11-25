<script type="text/javascript">
$(document).ready(function(){
	$('#daftar_pesan .clickable, #daftar_pesan .clickable a').click(function(){
		var anchor = this;
		var panel = $(this).parent();
		if($(this).hasClass('panel')) {
			anchor = $('a', this);
			panel = this;
		}

		var url = $(anchor).attr('href');
		$.get(url, function(data){
			$('#modal_rincian_pesan .modal-body').html($('.panel', data).clone());
		});

		$(panel).removeClass('panel-success').addClass('panel-default');
		$('#modal_rincian_pesan').modal('show');
		return false;
	});
});
</script>