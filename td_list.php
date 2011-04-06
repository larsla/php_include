<?

class td_list {
	private $html = NULL;
	private $list = array();
	private $style = "odd";

	public function __construct($array) {
		$this->html = "<table><tr class=\"".$this->style."\">";
		foreach($array as $entry)
			$this->html .= "<td>".$entry."</td>";
		$this->html .= "</tr>\n";
		$this->chstyle();
	}
	public function addentry($array) {
		$this->list[] = $array;
	}
	public function output() {
		foreach($this->list as $entries) {
			$this->html .= "<tr class=\"".$this->style."\">";
			foreach($entries as $entry)
				$this->html .= "<td>".$entry."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			$this->html .= "</tr>\n";
			$this->chstyle();
		}
		$this->html .= "</table>";
		return $this->html;
	}
	private function chstyle() {
		if($this->style == "odd")
			$this->style = "even";
		else
			$this->style = "odd";
	}
	public function sort($key) {
		natsort2d($this->list, $key);
	}
	public function unique() {
		foreach ($this->list as $key=>$value) {
			$this->list[$key] = "'" . serialize($value) . "'";
		}
		$this->list = array_unique($this->list);
		foreach ($this->list as $key=>$value) {
			$this->list[$key] = unserialize(trim($value, "'"));
		} 
	}
}

?>
