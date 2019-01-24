<?php
class Database {

	public static $hostName = 'localhost';
	public static $dbName = 'nynxxoeg_anime';
	public static $username = 'nynxxoeg';
	public static $password = 'v641k0WMcy';

	 private static function connect() {
                try{
                        $pdo = new PDO('mysql:host='.self::$hostName.';dbname='.self::$dbName.';', self::$username, self::$password);
                }catch( PDOException $Exception ){
                        var_dump($Exception);
                }
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
        }
        public static function query($query, $params = array()) {
               // $test = self::connect();
                $statement = self::connect()->prepare($query);
                $statement->execute($params);
                if (explode(' ', $query)[0] == 'SELECT') {
                $data = $statement->fetchAll();
                return $data;
                }
        }

}