<?

require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
require_once 'Zend/Db/Statement/Exception.php';

class database {

	public $db = NULL;
	private $stmt = NULL;
	private $result = NULL;
	private $res_cur = 0;

	public function __construct($server, $user, $pass, $dbname) {
		$this->db = new Zend_Db_Adapter_Pdo_Mysql(array(
			'host'		=>	$server,
			'username' 	=>	$user,
			'password'	=>	$pass,
			'dbname'	=>	$dbname
		));
	}

	public function query($query_string) {
		$failed = 0;
		try {
			$r = $this->db->query($query_string);
		} catch (Zend_Db_Statement_Exception $e) {
			$this->result = array();
			$failed = 1;
		}
		if($failed != 1)
			$this->result = $r->fetchAll();
	}
	public function s_query($query_string) {
		$this->db->query($query_string);
	}
	public function getrows() {
		return $this->result;
	}
	public function num_rows() {
		return count($this->result);
	}

	public function get_single_row($table, $col, $value) {
	        $this->db->query("select * from ".$table." where ".$col." = '".$value."'");
	        $rows = $this->db->getrows();
	        if(is_array($rows))
	                return $rows[0];
	        else
	                return $rows;
	}

	public function get_all_rows($table, $col, $value) {
	        $this->db->query("select * from ".$table." where ".$col." = '".$value."'");
	        $rows = $this->db->getrows();
	        return $rows;
	}

        public function create_table($tablename, $fields_type, $fields_length, $fields_ai) {
                $sql = "CREATE TABLE IF NOT EXISTS `".$tablename."` (";
                $primary_key = "";
                foreach(array_keys($fields_type) as $key) {
                        if($primary_key == "")
                                $primary_key=$key;
                        $sql .= "`".$key."` ";
			switch ($fields_type[$key]) {
			case 'date':
				$sql .= $fields_type[$key];
				break;
			default:
				$sql .= $fields_type[$key]."(".$fields_length[$key].")";
			};
			$sql .= " NOT NULL";

			if(isset($fields_ai[$key]))
				$sql .= " auto_increment";

			$sql .= ",";
                }

                $sql .= " PRIMARY KEY  (`".$primary_key."`),
                        UNIQUE KEY `".$primary_key."` (`".$primary_key."`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

		echo $sql."\n";

                $this->s_query($sql);
                return $sql;
	}

}

?>
