<?php
class simple_form {
	protected $output = NULL;
	protected $formname = NULL;
	private $topic = NULL;
	protected $returnpage = NULL;
	private $returnfunc = NULL;
	private $submittext = "Save";
	private $canceltext = "Cancel";
	private $inputs = NULL;
	public $close_on_submit = FALSE;
	public $reload_on_submit = TRUE;
	public $redirect_after_submit = NULL;
	public $close_on_cancel = TRUE;
	public $redirect_on_cancel = NULL;

	public function __construct($formname, $topic, $returnpage, $returnfunc, $submittext, $canceltext) {
		$this->formname = $formname;
		$this->topic = $topic;
		$this->returnpage = $returnpage;
		$this->returnfunc = $returnfunc;
		$this->submittext = $submittext;
		$this->canceltext = $canceltext;

		$this->hook_construct();

		$this->output = $this->ret_header();
	}

	protected function hook_construct() {
		return TRUE;
	}

	public function addinput($name, $type, $value, $length, $size, $humanname, $comment) {
		#$this->inputs[$name] = array(type => $type, value => $value, length => $length, size => $size, humanname => $humanname, comment => $comment);
		$this->output .= "<tr><td>".$humanname."</td><td><input class=\"texta\" type='".$type."' value='".$value."' name='".$name."' length='".$length."' size='".$size."'>&nbsp;&nbsp;".$comment."</td></tr>";

	}

	public function addselect($name, $array, $humanname, $selected) {
		$this->output .= "<tr><td>".$humanname.":</td><td>";
		$this->output .= "<select class=\"texta\" name=\"".$name."\">";
		foreach(array_keys($array) as $key) {
			$this->output .= "<option value=\"".$key."\" ";
			if($selected == $key)
				$this->output .= "selected=\"selected\" ";
			$this->output .= ">".$array[$key]."</option>";
		}
		$this->output .= "</select></td></tr>";
	}

	private function ret_header() {
	        $out = "<b>".$this->topic."</b><br>";
		$out .= "<FORM name=\"".$this->formname."\" id=\"".$this->formname."\" ACTION=\"?page=".$this->returnpage."&func=".$this->returnfunc."&tmpl=popup&nt=1\" METHOD=\"POST\">";  
		$out .= "<table>";
		$out .= "<tr><td> </td><td> </td></tr>";

		return $out;
	}

	#private function ret_inputs() {
	#	$out = "";
	#	foreach(array_keys($this->inputs) as $key) {
	#		$input = $this->inputs[$key];
	#		$out .= "<tr><td>".$input['humanname']."</td><td><input class=\"texta\" type='".$input['type']."' value='".$input['value']."' name='".$key."' length='".$input['length']."' size='".$input['size']."'>&nbsp;&nbsp;".$input['comment']."</td></tr>";
	#	}
	#	return $out;
	#}

	private function ret_footer() {
		$out = "<tr><td><INPUT onclick=\"";
		if($this->pre_submit != FALSE)
			$out .= $pre_submit;
		$out .= "doSubmit('".$this->formname."');";
		if($this->reload_on_submit == TRUE)
			$out .= "sleep(500); opener.location.reload();";
		if($this->close_on_submit == TRUE)
			$out .= "window.close();";
		$out .= "\" TYPE=button VALUE=\"".$this->submittext."\"></td><td><input type=button onclick=\"";
		if($this->close_on_cancel == TRUE)
			$out .= "window.close();";
		$out .= "\" value=\"".$this->canceltext."\"></td></tr>";
		$out .= "</table>";
		$out .= "</FORM>";
		return $out;
	}

	public function output() {
		$this->output .= $this->ret_footer();
		return $this->output;
	}

}

?>
