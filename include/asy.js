
  function stateClose(id){
    document.getElementById(id).style.display="none";
  }  // 얘는 너무 다양한 페이지에서 자주 쓰임.



function asyChecker(asyAlert) {
  var head = '';
  var body = '';
  var my_location = location.href;
  var state = '';

  this.checkAsyCmdState = function(jobid, url ,num, time_id) {
    state = document.querySelector('#state'+num);
    //ajax 사용해서 비동기 명령어 상태가 어떻게 되는지 조회한다.
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.onreadystatechange = function(){
      if(xhr.readyState === 4 && xhr.status === 200) {
        var temp = xhr.responseText;
        state.innerHTML=temp;
        if(isAsyDone(temp)){
          clearInterval(time_id);
          makeAlertMessageType(temp);
          makeAlertMessageBody(temp);
          stateRenew();
          alertAsyDone(num);
        }
      }
    }
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    var data = '';
    data += "jobid="+jobid;
    data += "&jobRank="+num;
    xhr.send(data);  
  }

  function isAsyDone(text) {
    if(text.match('done')) {
      return true;
    }
    return false;
  }

  function makeAlertMessageType(text) {
    var res;
    if(text.match('VM')) {
      head = 'Server';
      res = text.split('<displayname>');
      body = res[1];
    }
    else if(text.match('Volume')){
      head = 'Volume';
      res = text.split('<diskname>');
      body = res[1];
    }
    else if(text.match('IP')) {
      head = 'IP';
    }
    else if(text.match('PortForwarding')) {
      head = 'Port Forwarding';
    }
    else if(text.match('FirewallRule')) {
      head = 'Fire Wall';
    }
    else if(text.match('Nic')) {
      head = 'CIP';
    } 
    else {
      head = '';
    }
  }

  function makeAlertMessageBody(text) {
    if(text.match('DestroyVM')){
      body += ' 서버 삭제가 완료 되었습니다.';
      if(my_location.match('myServer.php') == 'myServer.php') {
        renewServerList();
      }
    } 
    else if(text.match('StopVM')) {
      body += ' 종료가 완료 되었습니다.';
    } 
    else if(text.match('DeployVM')) {
      body += ' 생성이 완료 되었습니다.';
    } 
    else if(text.match('RebootVM')) {
      body += ' 재시작이 완료 되었습니다.';
    } 
    else if(text.match('StartVM')) {
      body += ' 시작이 완료 되었습니다.';
    } 
    else if(text.match('ResetVMPassword')) {
      body += ' 비밀번호 재생성이 완료 되었습니다.';
    }  // disk
    else if(text.match('CreateVolume')) {
      body += ' 생성이 완료 되었습니다.';
    } 
    else if(text.match('AttachVolume')) {
      body += ' 와 서버 연결이 완료 되었습니다.';
    } 
    else if(text.match('DetachVolume')) {
      body += ' 와 서버 연결 해제가 완료 되었습니다.';
    } //ip
    else if(text.match('AssociateIPAddr')) {
      body = ' IP 생성이 완료 되었습니다.';
    } 
    else if(text.match('DisassociateIPAddr')) {
      body = ' IP 삭제가 완료 되었습니다.';
    } //portForwarding
    else if(text.match('CreatePortForwardingRule')) {
       body = ' port forwarding 생성이 완료 되었습니다.';
    } 
    else if(text.match('DeletePortForwardingRule')) {
      body = ' port forwarding 삭제가 완료 되었습니다.';
    }  //firewall
    else if(text.match('CreateFirewallRule')) {
      body = ' 방화벽 규칙 생성이 완료 되었습니다.';
    } else if(text.match('DeleteFirewallRule')) {
      body = ' 방화벽 규칙 삭제가 완료 되었습니다.';
    } 
    else if (text.match('AddNicToVM')) {
      body = 'CIP와 서버 연결이 완료 되었습니다.';
    }
    else if (text.match('RemoveNicFromVM')) {
      body = 'CIP와 서버 연결 해제가 완료 되었습니다.';
    }
    if(text.match('fail')) {
      body = ' 오류가 발생했습니다.';
    }
  }

  function stateRenew(){
    if (head.match('Port Forwarding')) {
      if(my_location.match('listPublicIP.php')){
        stateClose('stateViewer');
      }
    }
    else if(head.match('Fire Wall')) {
      if(my_location.match('listFireWallRules.php')){
        stateClose('stateViewer');
      }
    } 
    else if(head.match('Server')) {
      if(my_location.match('myServer.php')){
        stateClose('serverState');
        if(body.match('삭제')) {
          renewServerList();
        }
      }
    } 
    else if(head.match('Volume')) {
      if(my_location.match('listVolume.php')){
        stateClose('diskState');
      }
    } 
    else if(head.match('CIP')) {
      if(my_location.match('listNAS.php')){
        stateClose('NASList');
        stateClose('NASState');
      }
    }
  }

  function renewServerList(){
    var xhr = new XMLHttpRequest();
    xhr.open('GET','renewMyServer.php');
    xhr.send();
    xhr.onreadystatechange = function(){
      if(xhr.readyState === 4 && xhr.status === 200) {
        document.querySelector('#myVM').innerHTML = xhr.responseText;
      }
    }
    stateClose('serverState');
  }

  function alertAsyDone(num){
    state.innerHTML = body;
    asyAlert.render('asyAlert['+num+']', head, body, 'default');
  }
}
    
    