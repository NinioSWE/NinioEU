<?php
class OpenTDBPage extends Controller {
	public $data = array();
	public function run ($viewName) {
		$data['jsonFile'] = getAnimeQuestion();
		self::render($viewName,$this->data);
	}

	public function getAnimeQuestion($game) {

			$curlHandle = curl_init();

			curl_setopt($curlHandle, CURLOPT_URL, 'https://opentdb.com/api.php?amount=10&category=31&difficulty=medium&type=multiple');
			curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

			$data = curl_exec($curlHandle);
			$json = json_decode($data);
			//$this->data = print_r($data,true);

			curl_close($curlHandle);
			return $json;
	}
}