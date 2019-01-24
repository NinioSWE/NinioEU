<?php
class Controller extends Database{
	public static function render($viewName, $data = array()) {
		if($viewName != 'jsonfilePage'){
			require_once ('./views/Header.php');
			require_once ('./views/'.$viewName.'.php');
			require_once ('./views/Footer.php');
		}
		else{
			if(file_exists('./views/jsonfilePage.php')){
				require_once ('./views/jsonfilePage.php');
			}
		}
	}
}