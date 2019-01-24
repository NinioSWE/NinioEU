<?php
class OpeningMoePage extends Controller {
	public $data = array();
	public function run ($viewName) {
		//print_r (self::query('SELECT * FROM players'));
		//$this->updateDatabase();
		if (isset($_GET['fileName'])) {
			$this->data['page'] = 'video';
			$this->data['fileName'] = $_GET['fileName'];
			$this->data['openingsList'] = self::query('SELECT * FROM openingsMoe WHERE fileName = ?',array($this->data['fileName']));
			self::render($viewName,$this->data);
		}
		elseif (isset($_GET['update'])) {
			$this->updateDatabase();
		}
		else {
			if (isset($_GET['openingsSearch'])) {
				$this->data['openingsList'] = self::query('SELECT * FROM openingsMoe WHERE title LIKE ?', array('%'.$_GET['openingsSearch'].'%'));
				//var_dump('SELECT * FROM openingsMoe WHERE title LIKE "%'.$_GET['openingsSearch'].'%"');
			}else {
				$this->data['openingsList'] = self::query('SELECT * FROM openingsMoe');
			}
			$this->data['page'] = 'standard';
			self::render($viewName,$this->data);
		}
	}

	public function updateDatabase() {

			$curlHandle = curl_init();

			curl_setopt($curlHandle, CURLOPT_URL, 'https://openings.moe/api/list.php');
			curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

			$data = curl_exec($curlHandle);
			//$this->data = print_r($data,true);

			curl_close($curlHandle);

			$obj = json_decode($data);
			self::query('TRUNCATE TABLE openingsMoe');
			foreach ($obj as $post){
				$post->file = urlencode(preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
					    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
					}, $post->file));
				self::query('INSERT INTO openingsMoe (title,fileName,openingTitle) VALUES (?,?,?)',array($post->source,$post->file,$post->title));
			}

	}
}