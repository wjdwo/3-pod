<?php @session_start(); ?>
<?php 
include_once($server_root_path.'/'.CLOUD_PATH.'include/api_constants.php');
include_once($server_root_path.'/'.CLOUD_PATH.'login_certify.php');
include_once($server_root_path.'/'.CLOUD_PATH.'customAlert/customAlert.html');


?>

<link rel="stylesheet" type="text/css" href="/<?=CLOUD_PATH?>include/design.css">
<link rel="stylesheet" type="text/css" href="/<?=CLOUD_PATH?>include/menu_design.css">
<link rel="stylesheet" type="text/css" href="/<?=CLOUD_PATH?>alertBar/alert_bar_design.css">

<div class="ultimatedropdown">
<ul>
<li><a href="/<?=CLOUD_PATH?>index.php">HOME</a></li>
<li><a href="javascript:vold(0)">Server</a>
  <ul>
    <li><a href="/<?=CLOUD_PATH?>server/newServer.php">New Server</a></li>
    <li><a href="/<?=CLOUD_PATH?>server/myServer.php">My Server</a></li>
  </ul>
</li>
<li><a href="javascript:vold(0)">IP</a>
  <ul>
    <li><a href="/<?=CLOUD_PATH?>ip/newPublicIP.php">New Public IP</a></li>
    <li><a href="/<?=CLOUD_PATH?>ip/listPublicIP.php">My Public IP</a></li>
    <li><a href="/<?=CLOUD_PATH?>ip/listFireWallRules.php">Firewall Rules</a></li>
  </ul>
</li>
<li><a href="javascript:vold(0)">Volume</a>
  <ul>
    <li><a href="/<?=CLOUD_PATH?>volume/newVolume.php">New Volume</a></li>
    <li><a href="/<?=CLOUD_PATH?>volume/listVolume.php">My Volume</a></li>

  </ul>
</li>

<li><a href="javascript:vold(0)">NAS</a>
  <ul>
    <li><a href="/<?=CLOUD_PATH?>NAS/newNas.php">New NAS</a></li>
    <li><a href="/<?=CLOUD_PATH?>NAS/listNAS.php">My NAS</a></li>
    <li><a href="/<?=CLOUD_PATH?>NAS/cifsAccount.php">CIFS Account</a></li>
  </ul>
</li>

<?php
  if(isset($_SESSION['ID'])){
    echo "<li><a href='/".CLOUD_PATH."sessionDestroy.php'>Log Out</a></li>";
  } else {
    echo "<li><a href='#'>Log In</a></li>"; 
  }
?>
</ul>
<br style="clear: left" />
</div>

<div class="css3droppanel" >
<input type="checkbox" id="paneltoggle" />
<label for="paneltoggle" title="Click to open Panel"></label>
<div class="content">
  <script>

  var doneConfirm = new Array();
  function stateClose(){
    document.getElementById('serverState').style.display="none";
  }
  function renewPage(){
    var xhr = new XMLHttpRequest();
    xhr.open('GET','renewMyServer.php');
    xhr.send();
    xhr.onreadystatechange = function(){
      if(xhr.readyState === 4 && xhr.status === 200) {
       // alert(xhr.responseText);
        document.querySelector('#myVM').innerHTML = xhr.responseText;
      }
    }
    stateClose();
  }
    function testSeparate3(jobid, url ,num, time_id){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.onreadystatechange = function(){
      if(xhr.readyState === 4 && xhr.status === 200) {
        var temp = xhr.responseText;
        var state = document.querySelector('#state'+num);
        var head = '';
        var body = '';
        var my_location = location.href;

        state.innerHTML=temp;
      //  alert(temp);
        doneConfirm[time_id] = new CustomAlert();
        if(temp.match('done')) {
          clearInterval(time_id);
        }
        if(temp.match('DestroyVM') == 'DestroyVM') {
        //  alert('vm destroy!'); 
          head = 'Server'; body = ' 서버 삭제가 완료 되었습니다.';
          if(my_location.match('myServer.php') == 'myServer.php') {
          //  sleep(3);
            renewPage();
          }
        } else if(temp.match('StopVM') == 'StopVM') {
          head = 'Server'; body = ' 서버 종료가 완료 되었습니다.';
        } else if(temp.match('DeployVM') == 'DeployVM') {
          head = 'Server'; body = ' 서버 생성이 완료 되었습니다.';
        } else if(temp.match('RebootVM') == 'RebootVM') {
          head = 'Server'; body = ' 서버 재시작이 완료 되었습니다.';
        } else if(temp.match('StartVM') == 'StartVM') {
          head = 'Server'; body = ' 서버 시작이 완료 되었습니다.';
        } else if(temp.match('ResetVMPassword') == 'ResetVMPassword') {
          head = 'Server'; body = ' 서버 비밀번호 재생성이 완료 되었습니다.';
        }  // disk
        else if(temp.match('CreateVolume') == 'CreateVolume') {
          head = 'Volume'; body = ' Disk 생성이 완료 되었습니다.';
        } else if(temp.match('AttachVolume') == 'AttachVolume') {
          head = 'Volume'; body = ' Disk 와 서버 연결이 완료 되었습니다.';
        } else if(temp.match('DetachVolume') == 'DetachVolume') {
          head = 'Volume'; body = ' Disk 와 서버 연결 해제가 완료 되었습니다.';
        } //ip
        else if(temp.match('AssociateIPAddr') == 'AssociateIPAddr') {
          head = 'IP'; body = ' IP 생성이 완료 되었습니다.';
        } else if(temp.match('DisassociateIPAddr') == 'DisassociateIPAddr') {
          head = 'IP'; body = ' IP 삭제가 완료 되었습니다.';
        } //portForwarding
        else if(temp.match('CreatePortForwardingRule') == 'CreatePortForwardingRule') {
          head = 'Port Forwarding'; body = ' port forwarding 생성이 완료 되었습니다.';
        } else if(temp.match('DeletePortForwardingRule') == 'DeletePortForwardingRule') {
          head = 'Port Forwarding'; body = ' port forwarding 삭제가 완료 되었습니다.';
        }  //firewall
        else if(temp.match('CreateFirewallRule') == 'CreateFirewallRule') {
          head = 'Fire Wall'; body = ' 방화벽 규칙 생성이 완료 되었습니다.';
        } else if(temp.match('DeleteFirewallRule') == 'DeleteFirewallRule') {
          head = 'Fire Wall'; body = ' 방화벽 규칙 삭제가 완료 되었습니다.';
        } 
        if(temp.match('fail') == 'fail'){
          body = ' 오류가 발생했습니다.';
        }
        if(head != '') {
          state.innerHTML = body;
          doneConfirm[time_id].render(head,body,'default');
        }
      }
    }
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    var data = '';
    data += "jobid="+jobid;
    data += "&jobRank="+num;
    xhr.send(data);
    
  }

    var timeid = new Array();
  </script>
    
<?php
        if(!isset($_SESSION['processID'])){
           echo "<p><span>요청 하신 작업이 없습니다.</span></p>";
        }
        else if(count($_SESSION['processID'])==0){
            echo "<p>요청 하신 작업이 없습니다.</p>"; 
        }
        else if(count($_SESSION['processID'])!=0){ 
          $timeID=0; 
          foreach($_SESSION['processID'] as $key => $value ) {
            $timeID++;
            ?>
            <p><?=$key?> :<span id="state<?= $key ?>"></span></p>
            <script>
              timeid[<?=$timeID?>] = setInterval("testSeparate3('<?= $_SESSION['processID'][$key] ?>','/<?=CLOUD_PATH?>include/asynchronousPart.php','<?= $key ?>', timeid[<?=$timeID?>])", 3000);
            </script>
<?php 
          }    
        } 
?>

</div>

</div>