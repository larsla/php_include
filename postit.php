<?php
function post_it($datastream, $url) {
	$url = preg_replace("@^http://@i", "", $url);
	$host = substr($url, 0, strpos($url, "/"));
	$uri = strstr($url, "/");

	$reqbody = "";
	foreach($datastream as $key=>$val) {
		if (!empty($reqbody)) $reqbody.= "&";
		$reqbody.= $key."=".urlencode($val);
	}

	$contentlength = strlen($reqbody);
	$reqheader =  "POST $uri HTTP/1.1\r\n".
		"Host: $host\n". "User-Agent: PostIt\r\n".
		"Content-Type: application/x-www-form-urlencoded\r\n".
		"Content-Length: $contentlength\r\n\r\n".
		"$reqbody\r\n";

	$socket = fsockopen($host, 80, $errno, $errstr);

	if (!$socket) {
		$result["errno"] = $errno;
		$result["errstr"] = $errstr;
		return $result;
	}

	fputs($socket, $reqheader);

	while (!feof($socket)) {
		$result[] = fgets($socket, 4096);
	}

	fclose($socket);

	return $result;
}
?>
