<?php
class db extends PDO {
	function __construct($host="localhost", $dbname="comics", $login="", $pass="") {
		parent::__construct('mysql:host='.$host.';dbname='.$dbname, $login, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
		
		try { 
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch (PDOException $e) {
            die($e->getMessage());
        }
	}
	
	
	function __destruct() {
		$this->connection = null;
	}
}
?>