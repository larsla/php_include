<?

require_once("php_include/form.php");
require_once("php_include/db.php");

class db_form extends simple_form {
	private $conf = NULL;
	private $db = NULL;
	private $table = NULL;
	private $selectname = NULL;
	private $acl_name = NULL;
	protected $output = NULL;

	protected function hook_construct() {
		require("conf/dbform.php");
		$this->conf = $dbform_conf;
		$this->db = new database($this->conf['server'], $this->conf['username'], $this->conf['password'], $this->conf['dbname']);
	}

        public function adddbselect($selectname, $humanname, $aclname) {
		$this->output .= "<tr><td>".$humanname.":</td><td>";
		$this->output .= "<select class=\"texta\" name=\"".$selectname."\">";
		$sql = "SELECT * FROM `".$this->conf['table']."` WHERE `selectname` = '".$selectname."'";
		$this->db->query($sql);
		$rows = $this->db->getrows();
		natsort2d($rows, 'humanname');
		foreach($rows as $row) {
			$this->output .= "<option value=\"".$row['identifier']."\" ";
			$this->output .= ">".$row['humanname']."</option>";
		}
		global $auth;
		if($auth->isAllowed($aclname))
			$this->output .= "</select><b><a class=\"a_button\" onclick=\"opener.location.href='?page=dbform&selectname=".$selectname."'; window.close()\">+</a></b></td></tr>";
		else
			$this->output .= "</select></td></tr>";

	}

}


/*
if(isset($got['dbform']) && $got['dbform'] == 1) {
	$selectname = validate($got['selectname'], "simpletext");
	$returnpage = validate($got['page'], "simpletext");
	$form = new simple_form("add_item", "Lägg till sak", $returnpage, "dbform_save", "Spara", "Avbryt");
	$form->addinput("identifier", "text", "", 40, 40, "Identifierare:", "Ett unikt ord som beskriver valet. T.ex LaptopU9410");
	$form->addinput("humanname", "text", "", 40, 40, "Namn", "Läsbart namn på saken, t.ex Bärbar dator U9410");
	$form->addinput("selectname", "hidden", $selectname, 0, 0, "", "");
	echo $form->output();
	exit(0);
}

if(isset($got['func']) && $got['func'] == "dbform_save") {
	require("conf/dbform.php");

	$selectname = validate($posted['selectname'], "simpletext");
	$identifier = validate($posted['identifier'], "simpletext");
	$humanname = validate($posted['humanname'], "text");


	print_r($got);
	print_r($posted);

	$sql = "INSERT INTO `".$dbform_conf['table']."` (`selectname`, `identifier`, `humanname`, `addedby`) VALUES ('".$selectname."', '".$identifier."', '".$humanname."', '".$auth->getUser()."')";

	$db = new database($dbform_conf['server'], $dbform_conf['username'], $dbform_conf['password'], $dbform_conf['dbname']);

	$db->s_query($sql);

	exit(0);
}
 */
