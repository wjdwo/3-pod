<?php
function var_dump_enter($var) {
    echo "<pre>";
    var_dump($var); 
    echo "</pre>";
}

function objectsIntoArray($arrObjData, $arrSkipIndices = array()) {
    $arrData = array();
 
    if (is_object($arrObjData))
        $arrObjData = get_object_vars($arrObjData);
 
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value))
                $value = objectsIntoArray($value, $arrSkipIndices);
            if (in_array($index, $arrSkipIndices))
                continue;
            $arrData[$index] = $value;
        }
    }
    return $arrData;
} //검색 하면 나오는 코드임.
 
function makeSignature($cmdArr, $SECERET) {

    $f = array_keys($cmdArr);
    $v = array_values($cmdArr);
    $cmdForSignature = array();

    for ( $i = 0; $i < count($cmdArr); $i++ ) {
        $v[$i]= strtok($v[$i], "&");

        //문자열 소문자로 만들기. 
        $f[$i] = strtolower(urlencode($f[$i]));
        $v[$i] = strtolower(urlencode($v[$i]));

        array_push($cmdForSignature, $f[$i]."=".$v[$i]);
    }
    sort($cmdForSignature);
    $cmdStr = "";
    for ( $i = 0; $i < count($cmdForSignature); $i++) {
        if ( $i == count($cmdForSignature) - 1 )
            $cmdStr = $cmdStr . $cmdForSignature[$i];
        else
            $cmdStr = $cmdStr . $cmdForSignature[$i] . "&";
    }
    $signature = urlencode(base64_encode(hash_hmac("sha1", $cmdStr, $SECERET, true)));
    return $signature;
}

function makeURLWithoutSignature($cmdArr,$URL) {

    $fArray = array_keys($cmdArr);
    $vArray = array_values($cmdArr);
    $cmd = array();

    for ( $i = 0; $i < count($cmdArr); $i++ )
        array_push($cmd, $fArray[$i]."=".$vArray[$i]);
    sort($cmd);
 

    $url = $URL;
    for ( $i = 0; $i < count($cmd); $i++)
        $url = $url . $cmd[$i] . "&";

    return $url;

}

function getFilesStr($url){
    $orig_error_reporting = error_reporting();
    error_reporting(0);
    $str = file_get_contents($url);
    error_reporting($orig_error_reporting);

    return $str;
}

function callCommand($URL, $cmdArr, $SECRET) {

    $signature = makeSignature($cmdArr, $SECRET);
    $url = makeURLWithoutSignature($cmdArr, $URL);
    $xmlUrl = $url . "signature=" . $signature;
    $str = getFilesStr($xmlUrl);

    if($str == FALSE) {
        return array("jobid"=>"ERROR");
    }

    $obj = simplexml_load_string($str);
    $arrXml = objectsIntoArray($obj);   

    return $arrXml;
} //kt OpenAPI 개발자 포럼에 있던 코드를 내가 맞춰서 쓸 수 있도록 refactoring 함.

function callCommandJSON($URL, $cmdArr, $SECRET)
{
    $cmdArr['response']='json';
    $signature = makeSignature($cmdArr, $SECRET);
    $url = makeURLWithoutSignature($cmdArr, $URL);
    $jsonUrl = $url . "signature=" . $signature;
    $str = getFilesStr($jsonUrl);
    if($str == FALSE) {
        return array("jobid"=>"ERROR");
    }

    $obj = json_decode($str);
    $arrJson = objectsIntoArray($obj);
       
    return $arrJson;
} //callCommand 함수 참고해서 고침.



?>
