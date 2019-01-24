<?php


echo '<form action="/openings-moe" method="get">
	<div class="form-group">
		<input type="text" name="openingsSearch" class="form-control"  placeholder="Search an opening">
	</div>
</form>';


if ($data['page'] == 'standard') {
	echo '<table class="table table-hover">';
	foreach ($data['openingsList'] as $list) {

		echo'<tr class="table-active"><td><a href="http://ninio.eu/openings-moe?fileName='.urlencode($list['fileName']).'">'.$list['title'].' - '.$list['openingTitle'].'</a></td></tr>';
	}
	echo '</table>';
}
elseif ($data['page'] == 'video') {
	//var_dump($data['openingsList'][0]['title']);
	echo '
	<h1>' . $data['openingsList'][0]['title']. ' - ' .$data['openingsList'][0]['openingTitle']. '</h1>
	<video controls loop="true" autoplay="autoplay" class="openings-moe-video">
	<source src="https://openings.moe/video/'.$data['fileName'].'.mp4" type="video/mp4">
	</video>

	<div id="player">
		<i class="material-icons fa-volume-down">volume_down</i>
		<div id="volume" class="slider"></div>
		<i class="material-icons fa-volume-up">volume_up</i>
	</div>';
}
//var_dump($data);
?>