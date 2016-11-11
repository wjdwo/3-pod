
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<script src='display.js'>
</script>

<script type="text/javascript">
function isEnglihOrNum(str){
    var err = 0; 
  
    for (var i=0; i<str.length; i++)  { 
       var chk = str.substring(i,i+1); 
       if(!chk.match(/[0-9]|[a-z]|[A-Z]|[-]|[_]/)) { 
            err = err + 1; 
        } 
    }    

    if (err > 0) { 
        return false;
    }
    return true; 
    
}

function checkDisplayName() {
    var dis = document.getElementById('sendform').displayname.value;
    if(dis==""){
        Alert.render('서버 명','이름을 입력해 주세요.','default'); 
        document.getElementById('sendform').displayname.focus();
        return false;
    }
    else if(isEnglihOrNum(dis)==false){
        Alert.render('서버 명','영문 및 숫자만 사용 가능 합니다.','default');
        document.getElementById('sendform').displayname.focus();
        return false;
    }
    else{
        window.open("serverNameCheckSubmit.php?server_name="+dis,'','left=300, top=300, width=400, height=300, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, copyhistory=no, resizable=no');
    }
}

function submitForm(){
    var form = document.getElementById('sendform');
    if(form.displayname.readOnly != true){
        Alert.render('서버 명','서버 명 중복 체크를 해주세요.','default');
        return false;
    }

    form.method="post";
    form.action="deployServer.php";
    form.submit();
    Alert.render('서버 신청','화면이 바뀔 때 까지<br>잠시만 기다려 주십시요.... ','');
}
</script>

</head>
<body>
<?php
$server_root_path = $_SERVER['DOCUMENT_ROOT'];
include_once($server_root_path.'/includeFiles.php');
include_once($server_root_path.'/'.CLOUD_PATH.'pageInclude/menuPageInclude.php');
?>
<?php

$URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";

$listProductcmdArr = array(
  "command" => "listZones",
  "available" => "true",
    "apikey" => API_KEY
);
$seceret_key = SECERET_KEY;
$result = callCommand($URL, $listProductcmdArr, $seceret_key);

?>

<table class="gray_line hoverOn">
<tbody>
<form name ="sendform" id ="sendform" method="post">
<tr>

    <td class="tweenty_width">서버 명</td>
    <td><input class="transparent" type="text" name="displayname" value=""/></td>
    <td class="tweenty_width"><input type="button" value="중복 확인" class="button2" onclick="checkDisplayName()"/></td>
</tr>

<tr>
    <td class="tweenty_width">위치</td>
    <td colspan="2"><select name="zoneid" id="zoneid" onchange="display('zoneid','product')">
        <option value="">-</option>
<?php
    for($i=0; $i<(int)$result['count']; $i++){
        echo "<option value='".$result['zone'][$i]['id']."'>".$result['zone'][$i]['name']."</option>";
    }
?>
    </select></td>
</tr>
<tr>
    <td class="tweenty_width">상품 타입</td>
    <td colspan="2" id="product_space"><select id="product" onchange="display('product','templateid')">
        <option value="">-</option>
    </select></td>
</tr>
<tr>
    <td class="tweenty_width">OS</td>
    <td colspan="2" id="templateid_space"><select name='templateid' id="templateid" onchange="display('templateid','serviceofferingid')">
        <option value="">-</option>
    </select></td>
</tr>
<tr>
    <td class="tweenty_width">CORE X RAM</td>
    <td colspan="2" id="serviceofferingid_space"><select name="serviceofferingid" id="serviceofferingid" onchange="display('serviceofferingid','diskofferingid')">
        <option value="">-</option>
    </select>
    </td>

</tr>
<tr>
    <td class="tweenty_width">Data Disk</td>
    <td colspan="2"><select name="diskofferingid" id ="diskofferingid">
        <option value="">yes</option>
        <option value="rootonly" selected='selected'>no</option>
    </select></td>
</tr>
<tr>
    <td>요금제 선택</td>
    <td colspan="2"><select name="usageplantype" id ="usageplantype">
        <option value="hourly" selected>시간제</option>
        <option value="monthly">월 단위</option>
    </select></td>
</tr>
<tr><td colspan="3">
    <input type='button' value='제출' class='button' onclick="submitForm()"/>
</td></tr>

</form>
</tbody>
</table>

</body>
</html>
