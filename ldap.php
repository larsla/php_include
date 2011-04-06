<?

class ldap {

	private $ldap = NULL;
	private $stmt = NULL;
	private $result = NULL;
	private $res_cur = 1;
	public $code = "";

	public function __construct($server, $user, $pass) {
		date_default_timezone_set("Europe/Stockholm");

		$this->ldap=ldap_connect($server)
			or $this->code="confail";

		#echo "LDAP: ".$this->ldap."\n";
		       
		if ($this->ldap != NULL) {
			ldap_set_option($this->ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($this->ldap, LDAP_OPT_REFERRALS, 0);

			ldap_bind($this->ldap, $user, $pass)
				or $this->code="bindfail";
		}
		if ($this->code == "")
			$this->code="success";
	}

	public function search($dn, $filter) {
		#echo "dn: ".$dn."\n";
		#echo "filter: ".$filter."\n";
		$sr=ldap_search($this->ldap, $dn, $filter);
		$this->result = ldap_get_entries($this->ldap, $sr);
		return $this->result["count"];
	}
	public function delete($dn) {
		return ldap_delete($this->ldap, $dn);
	}
	public function numrows() {
		return $this->result["count"];
	}
	private function convert($arr) {
		#print_r($arr);
		$out = NULL;
		if(is_array($arr)) {
			foreach(array_keys($arr) as $key) {
				if(is_array($arr[$key])) {
					if($arr[$key]['count'] > 1) {
						for($i = 0; $i < $arr[$key]['count']; $i++) {
							if(is_array($arr[$key][$arr[$key][$i]])) {
								if($arr[$key][$arr[$key][$i]]['count'] > 1) {
									for($b = 0; $b < $arr[$key][$arr[$key][$i]]['count']; $b++)
										$out[$key][$arr[$key][$i]][] = $arr[$key][$arr[$key][$i]][$b];
								} else {
									$out[$key][$arr[$key][$i]] = $arr[$key][$arr[$key][$i]][0];
								}
							} else {
								$out[$key][$i] = $arr[$key][$i];
							}
						}
					} else {
						$out[$key] = $arr[$key][0];
					}
				} else {
					$out[$key] = $arr[$key];
				}
			}
		}
		return $out;
	}
	public function getrows() {
		$out = NULL;
		#print_r($this->result);
		for($this->res_cur = 0; $this->res_cur < $this->result["count"]; $this->res_cur++) {
			$out[$this->res_cur] = $this->convert($this->result[$this->res_cur]);
			//if ($this->res_cur < $this->result["count"]) { // Varför var den här?
			//	if(is_array($this->result)) {
			//		foreach(array_keys($this->result[$this->res_cur]) as $key) {
			//			if(is_array($this->result[$this->res_cur][$key])) {
			//				if($this->result[$this->res_cur][$key]['count'] > 1) {
			//					for($i = 0; $i < $this->result[$this->res_cur][$key]['count']; $i++)
			//						$out[$this->res_cur][$key][$i] = $this->result[$this->res_cur][$key][$i];
			//				} else {
			//					$out[$this->res_cur][$key] = $this->result[$this->res_cur][$key][0];
			//				}
			//			} else {
			//				$out[$this->res_cur][$key] = $this->result[$this->res_cur][$key];
			//			}
			//		}
			//	}
			//}
		}
		$this->result = NULL;
		$this->res_cur = 1;
		return $out;
	}
	public function add($cn, $dn, $data) {
		$sr=ldap_search($this->ldap, $dn, "(".$cn.")");
		$entries = ldap_get_entries($this->ldap, $sr);

		if($entries["count"] > 0) {
			echo $cn.",".$dn." already exists, doing nothing";
		} else {
			$r=ldap_add($this->ldap, $cn.",".$dn, $data)
			    or die("LDAP add misslyckades");
		}
	}
	public function update($cn, $dn, $data) {
		$sr=ldap_search($this->ldap, $dn, "(".$cn.")");
		$entries = ldap_get_entries($this->ldap, $sr);

		if($entries["count"] == 0) {
			return 1;
			#echo $cn.",".$dn." does not exist, doing nothing";
		} else {
			$r=ldap_add($this->ldap, $cn.",".$dn, $data)
				or die("LDAP add misslyckades");
			return 1;
		}
	}
	public function mod_replace($dn, $data) {
		#$sr=ldap_search($this->ldap, $dn, "(".$cn.")");
		#$entries = ldap_get_entries($this->ldap, $sr);

		#if($entries["count"] == 0) {
		#	echo $cn.",".$dn." does not exist, doing nothing";
		#} else {
			$r=ldap_mod_replace($this->ldap, $dn, $data)
				or die("LDAP add misslyckades");
		#}
	}
	public function read($entry) {
		$sr=ldap_read($this->ldap, $entry, "objectClass=*");
		$out=$this->convert(ldap_get_entries($this->ldap, $sr));
		return $out[0];
	}
}

?>
