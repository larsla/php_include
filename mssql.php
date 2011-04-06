<?
require_once("php_include/db.php");
require_once 'Zend/Db/Adapter/Pdo/Mssql.php';

class mssql extends database {
        public function __construct($server, $user, $pass, $dbname) {
                #$this->db = new Zend_Db_Adapter_Pdo_Mssql(array(
		$config = array(
                        'host'          =>      $server,
                        'username'      =>      $user,
                        'password'      =>      $pass,
                        'dbname'        =>      $dbname,
			'pdoType'	=>	'dblib'
		);
                #));
		$this->db = Zend_Db::factory('Pdo_Mssql', $config);
        }
}
