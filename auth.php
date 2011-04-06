<?

include("Zend/Ldap.php");
require_once 'Zend/Auth.php';
require_once 'Zend/Auth/Adapter/DbTable.php';
require_once 'Zend/Session/Namespace.php';
include("Zend/Auth/Adapter/Ldap.php");
include("Zend/Config.php");
include("Zend/Config/Ini.php");
include("Zend/Log.php");
include("Zend/Log/Writer/Stream.php");

#require("include/acl.php");

class auth {

	public $auth = NULL;
	private $acl = NULL;
	private $db = NULL;
	private $config = NULL;
	private $log_path = NULL;
	private $options = NULL;

	public function __construct() {
		$this->auth = Zend_Auth::getInstance();
		#require("conf/authdb.php");
		#$this->db = new database($authdb_conf['server'], $authdb_conf['username'], $authdb_conf['password'], $authdb_conf['dbname']);
		$this->config = new Zend_Config_Ini('conf/auth.ini', 'production');
		$this->log_path = $this->config->ldap->log_path;
		$this->options = $this->config->ldap->toArray();
		unset($this->options['log_path']);

		#$this->acl = new acl();
	}

	public function isValid() {
		return $this->auth->hasIdentity();
	}
	public function hasIdentity() {
		return $this->auth->hasIdentity();
	}
	public function getIdentity() {
		return $this->auth->getIdentity();
	}
        public function getUser() {
		#$data = $this->auth->getStorage()->read();
		#return $data->username;
		return $this->getIdentity();
	}

	public function login($username, $password) {
		#$authAdapter = new Zend_Auth_Adapter_DbTable($this->db->db, 'users', 'username', 'password');
		#$authAdapter->setIdentity($username)
		#	    ->setCredential($password);

		$this->auth = Zend_Auth::getInstance();
		$authAdapter = new Zend_Auth_Adapter_Ldap($this->options, $username, $password);

		$result = $this->auth->authenticate($authAdapter);

		if($result->isValid()) {
			#$authSession = new Zend_Session_Namespace('Zend_Auth');
			#$authSession->setExpirationSeconds((60*60*3));  
			#$data = $authAdapter->getResultRowObject(null, 'password');
			#$this->auth->getStorage()->write($data);
			return true;
		} else {
			foreach ($result->getMessages() as $message) {
				echo "$message\n";
			}
			return false;
		}
	}

	public function logout() {
		$this->auth->clearIdentity();
	}

	public function isAllowed($func) {
		#return $this->acl->isAllowed($this->getUser(), $func);
	}
}


?>
