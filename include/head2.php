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
<div class="content">
  <script>

  var doneConfirm = new Array();

    function testSeparate3(jobid, url ,num, time_id){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.onreadystatechange = function(){
      if(xhr.readyState === 4 && xhr.status === 200) {
        var temp = xhr.responseText;
        document.querySelector('#state'+num).innerHTML = temp;
        doneConfirm[time_id] = new CustomAlert();
        if(temp.match('done')) {
          clearInterval(time_id);
        }
        if(temp.match('StopVM')) {
          doneConfirm[time_id].render('Server','서버 종료가 완료 되었습니다.','default');
        } else if(temp.match('DeployVM')){
          doneConfirm[time_id].render('Server','서버 생성이 완료 되었습니다.','default');
        } else if(temp.match('RebootVM')){
          doneConfirm[time_id].render('Server','서버 재시작이 완료 되었습니다.','default');
        } else if(temp.match('StartVM')) {
          doneConfirm[time_id].render('Server','서버 시작이 완료 되었습니다.','default');
        } else if(temp.match('ResetVMPassword')) {
          doneConfirm[time_id].render('Server','서버 비밀번호 재생성이 완료 되었습니다.','default');
        }  // disk
        else if(temp.match('CreateVolume')) {
          doneConfirm[time_id].render('volume','Disk 생성이 완료 되었습니다.','default');
        } else if(temp.match('AttachVolume')) {
          doneConfirm[time_id].render('volume','Disk 와 서버 연결이 완료 되었습니다.','default');
        } else if(temp.match('DetachVolume')) {
          doneConfirm[time_id].render('volume','Disk 와 서버 연결 해제가 완료 되었습니다.','default');
        } //ip
        else if(temp.match('AssociateIPAddr')) {
          doneConfirm[time_id].render('IP','IP 생성이 완료 되었습니다.','default');
        } else if(temp.match('DisassociateIPAddr')) {
          doneConfirm[time_id].render('IP','IP 삭제가 완료 되었습니다.','default');
        } //portForwarding
        else if(temp.match('CreatePortForwardingRule')) {
          doneConfirm[time_id].render('Port Forwarding','port forwarding 생성이 완료 되었습니다.','default');
        } else if(temp.match('DeletePortForwardingRule')) {
          doneConfirm[time_id].render('Port Forwarding','port forwarding 삭제가 완료 되었습니다.','default');
        }  //firewall
        else if(temp.match('CreateFirewallRule')) {
          doneConfirm[time_id].render('Fire Wall','방화벽 규칙 생성이 완료 되었습니다.','default');
        } else if(temp.match('DeleteFirewallRule')) {
          doneConfirm[time_id].render('Fire Wall','방화벽 규칙 삭제가 완료 되었습니다.','default');
        } 
        
      }
    }
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    var data = '';
    data += "jobid="+jobid;
    data += "&jobRank="+num;
    xhr.send(data);
    
  }
    
    var span_start=2;
    var span_end=1;
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
            <p><?=$_SESSION['processID'][$key]?> :<span id="state<?= $key ?>"></span></p>
            <script>
      <?php if($timeID==1) { ?>
              span_start = <?= $key?>;
      <?php } ?>
            span_end =  <?= $key?>  ;
              timeid[<?=$timeID?>] = setInterval("testSeparate3('<?= $_SESSION['processID'][$key] ?>','/<?=CLOUD_PATH?>include/asynchronousPart.php','<?= $key ?>', timeid[<?=$timeID?>])", 3000);
           
            </script>
<?php 

          }
          
        } 
?>

</div>

</div>