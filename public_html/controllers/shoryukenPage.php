<?php
class ShoryukenPage extends Controller {
	public $data = array();
	public function run ($viewName) {
		$this->data['SF5'] = $this->getTopPlayers('SF5');
		$this->data['MKX'] = $this->getTopPlayers('MKX');
		$this->data['UMVC3'] = $this->getTopPlayers('UMVC3');
		self::render($viewName,$this->data);
	}

	public function getTopPlayers($game) {

			$curlHandle = curl_init();

			curl_setopt($curlHandle, CURLOPT_URL, 'http://rank.shoryuken.com/api/top?game='.$game.'&format=xml');
			curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

			$data = curl_exec($curlHandle);
			//$this->data = print_r($data,true);

			curl_close($curlHandle);

			libxml_use_internal_errors(true);
			try {
				$xml = new SimpleXMLElement($data);
			}
			catch (Exception $e) 
			{
				return false;
			}

			libxml_use_internal_errors(false);
			if (!$xml) {
				return false;
			}
			else{
				//var_dump($xml);
				return $xml;
			}
	}
}