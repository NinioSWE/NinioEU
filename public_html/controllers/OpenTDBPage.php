<?php
class OpenTDBPage extends Controller {
	public $data = array();
	public function run ($viewName) {
		if(isset($_GET['newquestion'])){
			$this->data['jsonFile'] = $this->getAnimeQuestionRaw();
			self::render('jsonfilePage',$this->data);
		}else{
			$this->data['jsonFile'] = $this->getAnimeQuestion();
			self::render($viewName,$this->data);
		}
	}

	public function getAnimeQuestion() {
			$curlHandle = curl_init();

			curl_setopt($curlHandle, CURLOPT_URL, 'https://opentdb.com/api.php?amount=50&category=31');
			curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

			$data = curl_exec($curlHandle);
			//$this->data = print_r($data,true);

			curl_close($curlHandle);
			//var_dump(json_decode($data));
			$obj = json_decode($data);
			return $obj;
	}

	public function getAnimeQuestionRaw() {
			$curlHandle = curl_init();

			curl_setopt($curlHandle, CURLOPT_URL, 'https://opentdb.com/api.php?amount=10&category=31&difficulty=medium&type=multiple');
			curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

			$data = curl_exec($curlHandle);
			//$this->data = print_r($data,true);

			curl_close($curlHandle);
			//var_dump(json_decode($data));
			return $data;
	}
}