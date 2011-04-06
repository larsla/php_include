<?
function randomkeys($length)
{
        $pattern = "1234567890aBcDeFgHiJkLmNoPqRsTuVwXyZ";
        $key  = $pattern{rand(0,35)};
        for($i=1;$i<$length;$i++) {
                $key .= $pattern{rand(0,35)};
        }
        return $key;
}
?>
