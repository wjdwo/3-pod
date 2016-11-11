
//  var doneConfirm = new Array();
  function stateClose(id){
    document.getElementById(id).style.display="none";
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
    stateClose('serverState');
  }

  function stopAskAsy(text, time_id) {
    if(text.match('done')){
      clearInterval(time_id);
    }
  }

  function makeAlertHeadAndName(text) {
    var message = new Array();
    if(text.match('VM')) {
      message[0] = 'Server';
      var res = text.split('<displayname>');
      message[1] = res[1];
    }
    else if(text.match('Volume')){
      message[0] = 'Volume';
      var res = text.split('<diskname>');
      message[1] = res[1];
    }
    else if(text.match('IP')) {
      message[0] = 'IP';
    }
    else if(text.match('PortForwarding')) {
      message[0] = 'Port Forwarding';
    }
    else if(text.match('FirewallRule')) {
      message[0] = 'Fire Wall';
    }
    else if(text.match('Nic')) {
      message[0] = 'CIP';
    } 
    else {
      message[0] = '';
    }
    return message;
  }
/*
  function makeAlertMessage(text, my_location) {
    var temp_message = makeAlertHeadAndName(text);
    var head = temp_message[0];
    var body = temp_message[1];
    
    if(text.match('VM')) {
      head = 'Server';
      var res = text.split('<displayname>');
      body = res[1];
    }
    else if(text.match('Volume')){
      head = 'Volume';
      var res = text.split('<diskname>');
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
    } else {
      head ='';
    }

    if(text.match('DestroyVM')){
      body += ' 서버 삭제가 완료 되었습니다.';
      if(my_location.match('myServer.php') == 'myServer.php') {
        renewPage();
      }
    } else if(text.match('StopVM')) {
      body += ' 종료가 완료 되었습니다.';
    } else if(text.match('DeployVM')) {
      body += ' 생성이 완료 되었습니다.';
    } else if(text.match('RebootVM')) {
      body += ' 재시작이 완료 되었습니다.';
    } else if(text.match('StartVM')) {
      body += ' 시작이 완료 되었습니다.';
    } else if(text.match('ResetVMPassword')) {
      body += ' 비밀번호 재생성이 완료 되었습니다.';
    }  // disk
    else if(text.match('CreateVolume')) {
      body += ' 생성이 완료 되었습니다.';
    } else if(text.match('AttachVolume')) {
      body += ' 와 서버 연결이 완료 되었습니다.';
    } else if(text.match('DetachVolume')) {
      body += ' 와 서버 연결 해제가 완료 되었습니다.';
    } //ip
    else if(text.match('AssociateIPAddr')) {
      body = ' IP 생성이 완료 되었습니다.';
    } else if(text.match('DisassociateIPAddr')) {
      body = ' IP 삭제가 완료 되었습니다.';
    } //portForwarding
    else if(text.match('CreatePortForwardingRule')) {
       body = ' port forwarding 생성이 완료 되었습니다.';
    } else if(text.match('DeletePortForwardingRule')) {
      body = ' port forwarding 삭제가 완료 되었습니다.';
    }  //firewall
    else if(text.match('CreateFirewallRule')) {
      body = ' 방화벽 규칙 생성이 완료 되었습니다.';
    } else if(text.match('DeleteFirewallRule')) {
      body = ' 방화벽 규칙 삭제가 완료 되었습니다.';
    } 
    else if (text.match('AddNicToVM')) {
      body = 'CIP와 서버 연결이 완료 되었습니다.';
    } else if (text.match('RemoveNicFromVM')) {
      body = 'CIP와 서버 연결 해제가 완료 되었습니다.';
    }
    if(text.match('fail')) {
      body = ' 오류가 발생했습니다.';
    }

/*
    if (head.match('Port Forwarding')) {
      if(my_location.match('listPublicIP.php')){
        stateClose('stateViewer');
      }
    } else if(head.match('Fire Wall')) {
      if(my_location.match('listFireWallRules.php')){
        stateClose('stateViewer');
      }
    } else if(head.match('Server')) {
      if(my_location.match('myServer.php')){
        stateClose('serverState');
      }
    } else if(head.match('Volume')) {
      if(my_location.match('listVolume.php')){
        stateClose('diskState');
      }
    } else if(head.match('CIP')) {
      if(my_location.match('listNAS.php')){
        stateClose('NASList');
        stateClose('NASState');
      }
    }
   // 
    if(head != '') {
      state.innerHTML = body;
      Alert2.render(head, body, 'default');
    }
  }
*/
  function checkAsyCmdState(jobid, url ,num, time_id) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.onreadystatechange = function(){
      if(xhr.readyState === 4 && xhr.status === 200) {
        var temp = xhr.responseText;
        var state = document.querySelector('#state'+num);
 
        var my_location = location.href;

        state.innerHTML=temp;

        stopAskAsy(temp, time_id);
        var temp_message = makeAlertHeadAndName(text);
        var head = temp_message[0];
        var body = temp_message[1];
//        makeAlertMessage(temp, my_location);
//        head = '';
//        body = '';
        if(temp.match('VM')) {
          head = 'Server';
          var res = temp.split('<displayname>');
          body = res[1];
        }
        else if(temp.match('Volume')){
          head = 'Volume';
          var res = temp.split('<diskname>');
          body = res[1];
        }
        if(temp.match('DestroyVM')){
          head = 'Server'; body += ' 서버 삭제가 완료 되었습니다.';
          if(my_location.match('myServer.php') == 'myServer.php') {
            renewPage();
          }
        } else if(temp.match('StopVM')) {
          head = 'Server'; body += ' 종료가 완료 되었습니다.';
        } else if(temp.match('DeployVM')) {
          head = 'Server'; body += ' 생성이 완료 되었습니다.';
        } else if(temp.match('RebootVM')) {
          head = 'Server'; body += ' 재시작이 완료 되었습니다.';
        } else if(temp.match('StartVM')) {
          head = 'Server'; body += ' 시작이 완료 되었습니다.';
        } else if(temp.match('ResetVMPassword')) {
          head = 'Server'; body += ' 비밀번호 재생성이 완료 되었습니다.';
        }  // disk
        else if(temp.match('CreateVolume')) {
          head = 'Volume'; body += ' 생성이 완료 되었습니다.';
        } else if(temp.match('AttachVolume')) {
          head = 'Volume'; body += ' 와 서버 연결이 완료 되었습니다.';
        } else if(temp.match('DetachVolume')) {
          head = 'Volume'; body += ' 와 서버 연결 해제가 완료 되었습니다.';
        } //ip
        else if(temp.match('AssociateIPAddr')) {
          head = 'IP'; body = ' IP 생성이 완료 되었습니다.';
        } else if(temp.match('DisassociateIPAddr')) {
          head = 'IP'; body = ' IP 삭제가 완료 되었습니다.';
        } //portForwarding
        else if(temp.match('CreatePortForwardingRule')) {
          head = 'Port Forwarding'; body = ' port forwarding 생성이 완료 되었습니다.';
        } else if(temp.match('DeletePortForwardingRule')) {
          head = 'Port Forwarding'; body = ' port forwarding 삭제가 완료 되었습니다.';
        }  //firewall
        else if(temp.match('CreateFirewallRule')) {
          head = 'Fire Wall'; body = ' 방화벽 규칙 생성이 완료 되었습니다.';
        } else if(temp.match('DeleteFirewallRule')) {
          head = 'Fire Wall'; body = ' 방화벽 규칙 삭제가 완료 되었습니다.';
        } 
        else if (temp.match('AddNicToVM')) {
          head = 'CIP'; body = 'CIP와 서버 연결이 완료 되었습니다.';
        } else if (temp.match('RemoveNicFromVM')) {
          head = 'CIP'; body = 'CIP와 서버 연결 해제가 완료 되었습니다.';
        }
        if(temp.match('fail')) {
          body = ' 오류가 발생했습니다.';
        }
        if (head.match('Port Forwarding')) {
          if(my_location.match('listPublicIP.php')){
            stateClose('stateViewer');
          }
        } else if(head.match('Fire Wall')) {
          if(my_location.match('listFireWallRules.php')){
            stateClose('stateViewer');
          }
        } else if(head.match('Server')) {
          if(my_location.match('myServer.php')){
            stateClose('serverState');
          }
        } else if(head.match('Volume')) {
          if(my_location.match('listVolume.php')){
            stateClose('diskState');
          }
        } else if(head.match('CIP')) {
          if(my_location.match('listNAS.php')){
            stateClose('NASList');
            stateClose('NASState');
          }
        }
        if(head != '') {
          state.innerHTML = body;
          Alert2.render(head, body, 'default');
        }
      }
    }
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    var data = '';
    data += "jobid="+jobid;
    data += "&jobRank="+num;
    xhr.send(data);  
  }



//  var doneConfirm = new Array();