<div class="grid container">
	<div class="row">
		<div class="span3">
		</div>
		<div class="span9">
			<h1>Add<small> Movie</small></h1>
			<div class="tab-control" data-role="tab-control">
				<ul class="tabs">
					<li class="active"><a href="#search_imdb_page">Search IMDb</a></li>
					<li><a href="#add_data_page">Add Data</a></li>
				</ul>

				<div class="frames">
					<div class="frame" id="add_data_page">
						<form id="add_movie_data" action="<?php echo base_url('imdb/add') ?>" method="post">
							<fieldset>
								<legend>Add Data</legend>
								<label for="Title">Title</label>
								<div class="input-control text" data-role="input-control">
									<input id="Title" type="text" name="Title" />
								</div>
								<label for="Year">Year</label>
								<div class="input-control text" data-role="input-control">
									<input id="Year" type="text" name="Year" />
								</div>
								<label for="Rated">Rated</label>
								<div class="input-control text" data-role="input-control">
									<input id="Rated" type="text" name="Rated" />
								</div>
								<label for="Released">Released</label>
								<div class="input-control text" data-role="input-control">
									<input id="Released" type="text" name="Released" />
								</div>
								<label for="Runtime">Runtime</label>
								<div class="input-control text" data-role="input-control">
									<input id="Runtime" type="text" name="Runtime" />
								</div>
								<label for="Genre">Genre</label>
								<div class="input-control text" data-role="input-control">
									<input id="Genre" type="text" name="Genre" />
								</div>
								<label for="Director">Director</label>
								<div class="input-control text" data-role="input-control">
									<input id="Director" type="text" name="Director" />
								</div>
								<label for="Writer">Writer</label>
								<div class="input-control text" data-role="input-control">
									<input id="Writer" type="text" name="Writer" />
								</div>
								<label for="Actors">Actors</label>
								<div class="input-control text" data-role="input-control">
									<input id="Actors" type="text" name="Actors" />
								</div>
								<label for="Plot">Plot</label>
								<div class="input-control text" data-role="input-control">
									<input id="Plot" type="text" name="Plot" />
								</div>
								<label for="Poster">Poster</label>
								<div class="input-control text" data-role="input-control">
									<input id="Poster" type="text" name="Poster" />
								</div>
								<label for="imdbRating">IMDb Rating</label>
								<div class="input-control text" data-role="input-control">
									<input id="imdbRating" type="text" name="imdbRating" />
								</div>
								<label for="imdbVotes">IMDb Votes</label>
								<div class="input-control text" data-role="input-control">
									<input id="imdbVotes" type="text" name="imdbVotes" />
								</div>
								<label for="imdbID">IMDb ID</label>
								<div class="input-control text" data-role="input-control">
									<input id="imdbID" type="text" name="imdbID" />
								</div>
								<label for="Type">Type</label>
								<div class="input-control text" data-role="input-control">
									<input id="Type" type="text" name="Type" />
								</div>
								<button id="save_movie" class="image-button image-left bg-dark fg-white place-right">Save Movie
									<i class="icon-floppy bg-emerald fg-white"></i>
								</button>
							</fieldset>
						</form>
					</div>
					<div class="frame" id="search_imdb_page">
						<form id="imdb_search" action="" method="post">
							<fieldset>
								<legend>Search IMDb</legend>
								<label for="query_title">Title</label>
								<div class="input-control text" data-role="input-control">
									<input id="query_title" type="text" name="query_title" />
								</div>
								<button type="submit" class="image-button image-left info"><i class="icon-search bg-dark"></i>Search</button>
								<img id="search_progress" src="<?php echo base_url('assets/images/icons/preloader-w8-line-black.gif') ?>" style="height:13px; display:none" />
							</fieldset>
						</form>

						<div id="result_control" style="display:none">
							<button id="check_all" class="button primary">Check All</button>
							<button id="uncheck_all" class="button">Uncheck All</button>
							<button id="save_selected" class="image-button image-left bg-dark fg-white place-right">Save Selected
								<i class="icon-floppy bg-emerald fg-white"></i>
							</button>
							<input type="hidden" data-toBeSaved="0" data-saved="0" id="save_progress_data" />
						</div>

						<div class="row">
							<div id="save_progress" class="progress-bar small" data-role="progress-bar" data-value="0"></div>
						</div>

						<table id="search_result" class="table hovered" style="display:none">
							<thead>
								<tr>
									<th>No.</th>
									<th>Title</th>
									<th>Year</th>
									<th>IMDb ID</th>
									<th>Type</th>
									<th>Select?</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script id="imdb_script" type="text/javascript">

function notify(message, bgColor, fgColor) {
	$.Notify({
		content: message,
		style: {background: bgColor, color: fgColor},
		shadow: true,
		position: 'top-left'
	});
}

$(document).ready(function(){
	var imdbAPI = 'http://www.omdbapi.com/';
	$('#save_selected').click(function(){
		$('#save_progress_data').data('saved', 0);
		var toBeSaved = $('#search_result tbody tr td input:checked').length;
		$('#save_progress_data').data('toBeSaved', toBeSaved);
		var save_progress = $('#save_progress').progressbar();
		$('#search_result tbody tr td input:checked').each(function(){
			var imdbID = $(this).val();
			$.get(
				imdbAPI,
				'i=' + imdbID,
				function(data){
					if (isNaN(parseInt(data.imdbRating))) {
						data.imdbRating = 0;
					}
					console.log(data);
					$.post(
						'<?php echo base_url('imdb/add') ?>',
						data,
						function(json) {
							if(json.success) {
								notify(json.message, 'green', 'white');
							}
							else {
								notify(json.message, 'orange', 'white');
							}

							var saved = parseInt($('#save_progress_data').data('saved'));
							$('#save_progress_data').data('saved', ++saved);
							var toBeSaved = parseInt($('#save_progress_data').data('toBeSaved'));
							save_progress.progressbar('value', saved/toBeSaved * 100);
						},
						'json'
					);
				},
				'json'
			);
		});

		return false;
	});

	$('#check_all').click(function(){
		$('#search_result tbody tr td input').prop('checked', true);
	});

	$('#uncheck_all').click(function(){
		$('#search_result tbody tr td input').prop('checked', false);
	});

	$('#imdb_search').submit(function(){
		var query_title = $('#query_title').val();
		
		if (query_title == '') {
			return false;
		}

		$('#search_result').fadeOut();
		$('#search_progress').fadeIn();
		$.get(
			imdbAPI,
			's=' + query_title,
			function(data) {
				$('#search_result tbody *').remove();
				$('#hidden_search_result *').remove();
				$('#search_result, #result_control').fadeIn();
				$('#search_progress').fadeOut();

				var row = $(document.createElement('tr'));
				var cell = $(document.createElement('td'));
				var checkbox = $(document.createElement('input')).attr('type', 'checkbox');
				var hidden = $(document.createElement('input')).attr('type', 'hidden');

				if (typeof data.Search == 'undefined') {
					var newRow = row.clone();
					var newCell = cell.clone();
					var errorMessage = 'Movie not found!';
					if (typeof data.Error != 'undefined') {
						errorMessage = data.Error;
					}
					
					newCell.text(errorMessage).addClass('text-center').attr('colspan', 6);
					newRow.append(newCell).appendTo($('#search_result tbody'));
					return;
				}

				var result = data.Search;
				var num = 1;
				for (var i = 0; i < result.length - 1; i++) {
					if (result[i].Type != 'movie')
						continue;

					var newRow = row.clone();
					var number = cell.clone().addClass('text-center');
					var title = cell.clone();
					var year = cell.clone().addClass('text-center');
					var imdbID = cell.clone().addClass('text-center');
					var type = cell.clone().addClass('text-center');
					var choose = checkbox.clone().prop('checked', true);
					var checkboxCell = cell.clone().addClass('text-center');

					number.text(num++);
					title.text(result[i].Title);
					year.text(result[i].Year);
					imdbID.text(result[i].imdbID);
					type.text(result[i].Type);
					choose.val(result[i].imdbID);
					checkboxCell.append(choose);

					newRow.append(number).append(title)
						.append(year).append(imdbID)
						.append(type).append(checkboxCell)
						.appendTo($('#search_result tbody'));
				}
			},
			'json'
		);
		return false;
	});
});

</script>