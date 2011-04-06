<?
function validate($input, $type) {
 if($input != "") {
         if($type == "singleword" || $type == "simpletext")
          if(!preg_match("/^[a-zA-Z0-9åäöÅÄÖ\.\_\-]+$/", $input))
           die($input.", invalid input");
         if($type == "number")
          if(!preg_match("/^[0-9]+$/", $input))
           die($input.", invalid input");
         if($type == "ip")
          if(!preg_match("/^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$/", $input))
           die($input.", invalid ip address");
         if($type == "text")
          if(!preg_match("/^[0-9a-zA-ZåäöÅÄÖ\.\+\-\_\,\ ]+$/", $input))
           die($input.", invalid input");
         if($type == "ipnet")
          if(!preg_match("/^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+\/[0-9]+$/", $input))
           die($input.", invalid ip net");
         if($type == "hostname")
          if(!preg_match("/^[0-9a-zA-Z\.\-\_]+$/", $input))
           die($input.", invalid hostname");
         if($type == "bool")
          if(!preg_match("/^[0-1]$/", $input))
           die($input.", invalid bool");
         if($type == "mac")
          if(!preg_match("/^([0-9a-fA-F][0-9a-fA-F]:){5}([0-9a-fA-F][0-9a-fA-F])$/", $input))
           die($input." invalid mac-address");
         if($type == "number")
          if(!preg_match("/^([0-9]+)$/", $input))
           die($input." is not a number");
         if($type == "name")
          if(!preg_match("/^([0-9a-zA-ZåäöÅÄÖ]+\ *[0-9a-zA-ZåäöÅÄÖ]*)$/", $input))
           die($input." is not a valid name");
}

 return $input;
}

?>
