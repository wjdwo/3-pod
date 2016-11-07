<?php
function var_dump_enter($var){
    echo "<pre>";
    var_dump($var); 
    echo "</pre>";
}
function objectsIntoArray($arrObjData, $arrSkipIndices = array())
{
    $arrData = array();
 
    if (is_object($arrObjData))
        $arrObjData = get_object_vars($arrObjData);
 
    if (is_array($arrObjData))
        {
        foreach ($arrObjData as $index => $value)
                {
            if (is_object($value) || is_array($value))
                $value = objectsIntoArray($value, $arrSkipIndices);
            if (in_array($index, $arrSkipIndices))
                continue;
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}
 
function callCommand($URL, $cmdArr, $SECRET)
{
 //       echo "Command start<br/>";
        $fArray = array_keys($cmdArr);
        $vArray = array_values($cmdArr);
        $f = array(); $v = array(); $cmd = array(); $cmd1 = array();
        for ( $i = 0; $i < count($cmdArr); $i++ )
        {
        $vArray[$i]= strtok($vArray[$i], "&");
 
        $f[$i] = strtolower(urlencode($fArray[$i]));
        $v[$i] = strtolower(urlencode($vArray[$i]));
        array_push($cmd, $f[$i]."=".$v[$i]);
        }
        sort($cmd);
 
        for ( $i = 0; $i < count($cmdArr); $i++ )
                array_push($cmd1, $fArray[$i]."=".$vArray[$i]);
        sort($cmd1);
 
        $cmdStr = "";
        for ( $i = 0; $i < count($cmd); $i++)
        {
        if ( $i == count($cmd) - 1 )
                $cmdStr = $cmdStr . $cmd[$i];
        else
                $cmdStr = $cmdStr . $cmd[$i] . "&";
        }
        $signature = urlencode(base64_encode(hash_hmac("sha1", $cmdStr, $SECRET, true)));
        $url = $URL;
        for ( $i = 0; $i < count($cmd1); $i++)
                $url = $url . $cmd1[$i] . "&";
        $xmlUrl = $url . "signature=" . $signature;
 
        $orig_error_reporting = error_reporting();
        error_reporting(0);

        $str = file_get_contents($xmlUrl);

        if($str == FALSE) {
            return array("jobid"=>"ERROR");
        }
        $obj = simplexml_load_string($str);

        $arrXml = objectsIntoArray($obj);
       
        error_reporting($orig_error_reporting);
        return $arrXml;
}

function callCommandJSON($URL, $cmdArr, $SECRET)
{
 //       echo "Command start<br/>";
        $cmdArr['response']='json';
        $fArray = array_keys($cmdArr);
        $vArray = array_values($cmdArr);
        $f = array(); $v = array(); $cmd = array(); $cmd1 = array();
        for ( $i = 0; $i < count($cmdArr); $i++ )
        {
        $vArray[$i]= strtok($vArray[$i], "&");
 
        $f[$i] = strtolower(urlencode($fArray[$i]));
        $v[$i] = strtolower(urlencode($vArray[$i]));
        array_push($cmd, $f[$i]."=".$v[$i]);
        }
       sort($cmd);
 
        for ( $i = 0; $i < count($cmdArr); $i++ )
                array_push($cmd1, $fArray[$i]."=".$vArray[$i]);
        sort($cmd1);
 
        $cmdStr = "";
        for ( $i = 0; $i < count($cmd); $i++)
        {
        if ( $i == count($cmd) - 1 )
                $cmdStr = $cmdStr . $cmd[$i];
        else
                $cmdStr = $cmdStr . $cmd[$i] . "&";
        }
        $signature = urlencode(base64_encode(hash_hmac("sha1", $cmdStr, $SECRET, true)));
        $url = $URL;
        for ( $i = 0; $i < count($cmd1); $i++)
                $url = $url . $cmd1[$i] . "&";
        $xmlUrl = $url . "signature=" . $signature;
 
        $orig_error_reporting = error_reporting();
        error_reporting(0);
        $str = file_get_contents($xmlUrl);
        if($str == FALSE) {
            return array("jobid"=>"ERROR");
        }
        $obj = json_decode($str);
        $arrJson = objectsIntoArray($obj);
       
        error_reporting($orig_error_reporting);
        return $arrJson;
}



?>
