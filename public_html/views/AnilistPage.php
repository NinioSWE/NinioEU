
<?php
if (isset($_GET['search'])) {
		echo '<h3>Anilist ('.$_GET['search'].')</h3>';
	}
	else {
		echo '<h3>Anilist (Ninio)</h3>';
	}
?>
<p>This is my test of the Anilist API.</p>
<form action="/anilist" method="get">
	<div class="form-group">
		<input type="text" name="search" class="form-control"  placeholder="Search a user">
	</div>
</form>


<?php
if ($data['anime'] == null) {
	echo '<h3>The user you seached for was not found!</h3>';
}

$isNewStatus = '';
$anime = $data['anime'];


foreach ($anime as $post){
	if ($post['title'] == '') {
		continue;
	}

	$content = array($post['title'], $post['score'],$post['image'],$post['status']);

	/*if($post->status == 1){
		$statusText = "\"Currently watching\" (dropped)";
	}
	if($post->status == 2){
		$statusText = "Completed";
	}
	if($post->status == 3){
		$statusText = "On hold(dropped)";
	}
	if($post->status == 4){
		$statusText = "Dropped";
	}
	if($post->status == 6){
		$statusText = "Planed to watch";
	}*/
	$statusText = $post['status'];
	if($isNewStatus != $post['status']) {
		echo '<h3 class="status-border">'.$statusText.'</h3>';
		$isNewStatus = $post['status'];
	}

	$level = '';
	switch ($content[1]) {
		case 10:
			$level = 'gold';
			break;
		case 9:
			$level = 'silver';
			break;
		case 8:
			$level = 'bronze';
			break;
		default:
			$level = 'regular';
			break;

	}
	echo "<div class='anime-box'>";
		switch ($content[1]) {
			case 10:
				echo'<div class="anime-medal"><img src="/images/gold.png"></div>';
				break;
			case 9:
				echo'<div class="anime-medal"><img src="/images/silver.png"></div>';
				break;
			case 8:
				echo'<div class="anime-medal"><img src="/images/bronze.png"></div>';
				break;
			default:
				echo'<div class="anime-medal-regular"><div class="anime-score">'.$content[1].'</div></div>';
				break;
		}
		echo "<div class='anime-box-inner ".$level."'>";
			echo "<img src='".$content[2]."'>";
		echo "</div>";
		echo "<div class='anime-box-inner-lower ".$level."'>";
			echo "<p>".$content[0]."</p>";
		echo "</div>";
	echo "</div>";

}