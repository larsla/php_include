<?
function natsort2d( &$arrIn, $index = null )
{
  if(is_array($arrIn)) {
    $arrTemp = array();
    $arrOut = array();

    foreach ( $arrIn as $key=>$value ) {

        reset($value);
        $arrTemp[$key] = is_null($index)
                            ? current($value)
                            : $value[$index];
    }

    natsort($arrTemp);

    foreach ( $arrTemp as $key=>$value ) {
        $arrOut[$key] = $arrIn[$key];
    }

    $arrIn = $arrOut;
  }
}
?>
