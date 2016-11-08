

function destroyVM(){
  var server = document.getElementById('server_state_form');
  server.action = 'destroyVM.php';
  server.method = 'post';
  server.submit();
  Alert.render('Server','삭제 요청을 진행 하고 있습니다 잠시만 기다려 주세요. ','');
}
function startVM(){

  var server = document.getElementById('server_state_form');
  server.action = 'startVM.php';
  server.method = 'post';
  server.submit();
  Alert.render('Server','서버 시작 요청을 진행 하고 있습니다 잠시만 기다려 주세요. ','');
}
function stopVM(){
  var server = document.getElementById('server_state_form');
  server.action = 'stopVM.php';
  server.method = 'post';
  server.submit();
  Alert.render('Server','서버 중지 요청을 진행 하고 있습니다 잠시만 기다려 주세요. ','');
}
function restartVM(){
  var server = document.getElementById('server_state_form');
  server.action = 'restartVM.php';
  server.method = 'post';
  server.submit();
  Alert.render('Server','서버 재 시작 요청을 진행 하고 있습니다 잠시만 기다려 주세요. ','');
}
function resetPassword(){
  var server = document.getElementById('server_state_form');

  server.action = 'resetPassword.php';
  server.method = 'post';
  server.submit(); 
  Alert.render('Server','서버 비밀번호 변경 요청을 진행 하고 있습니다 잠시만 기다려 주세요. ','');
}
function stateClose(){
  document.getElementById('serverState').style.display="none";
}

function viewPassword(t){
    var id = t.innerHTML+'_id';
    var view_id = t.innerHTML;
    var postVal = document.getElementById(id).value; 
    var xhr = new XMLHttpRequest();
    xhr.open('POST','view_password.php');
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    var data = 'id='+postVal;
    xhr.send(data);
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200) {
          document.getElementById(view_id).innerHTML = xhr.responseText; 
        }
      }
  }

  function hiddenPassword(t){
    var postVal = t.innerHTML;
    document.getElementById(postVal).innerHTML="";
  }

  function showVMState(t){
    var postVal = t.innerHTML;
    var xhr = new XMLHttpRequest();
    xhr.open('POST','vmState.php');
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    var data = 'displayname='+postVal;
    xhr.send(data);
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200) {
          document.getElementById('serverState').innerHTML = xhr.responseText; 
        }
      }
    document.getElementById('serverState').style.display = 'table';
  }
/*
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
  */