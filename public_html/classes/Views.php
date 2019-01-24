<?php
class Views {
	public $test = 'test';
	public static function createView($viewName) {
		require_once ('./views/Header.php');
		require_once ('./views/'.$viewName.'.php');
		require_once ('./views/Footer.php');
	}
}