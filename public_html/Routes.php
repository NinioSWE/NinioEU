<?php


Route::set('home', function () {
	$controller = new HomePage();
	$controller->run('HomePage');
	//HomePage::start('HomePage');
});

Route::set('', function () {
	$controller = new Index();
	$controller->run('Index');
	//Index::start('Index');
});

Route::set('about', function () {
	$controller = new AboutPage();
	$controller->run('AboutPage');
	//AboutPage::start('AboutPage');
});

Route::set('openings-moe', function () {
	$controller = new OpeningMoePage();
	$controller->run('OpeningMoePage');
	//OpeningMoePage::start('OpeningMoePage');
});

Route::set('anilist', function () {
	$controller = new AnilistPage();
	$controller->run('AnilistPage');
	//AnilistPage::start('AnilistPage');
});

Route::set('opentdb', function () {
	$controller = new OpenTDBPage();
	$controller->run('OpenTDBPage');
	//AnilistPage::start('AnilistPage');
});


Route::set('shoryuken', function () {
	$controller = new ShoryukenPage();
	$controller->run('ShoryukenPage');
	//ShoryukenPage::start('ShoryukenPage');
});



if (!in_array($_GET['url'],Route::$validRoutes)) {
	$controller = new Error404Page();
	$controller->run('Error404Page');
	//Error404Page::start('Error404Page');
}

?>