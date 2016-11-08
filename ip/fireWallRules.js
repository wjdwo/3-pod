

  function firewall(num){
    stateClose('viewer');
    document.getElementById('stateViewer').innerHTML = '';
    document.getElementById('stateViewer').style.display="table-row-group";
    var ipaddressid = document.forms[num].ipaddressid.value;
    var ipadrressname = document.forms[num].ipaddress.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST','fireWallRulesList.php'); 
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    var data = 'ipaddressid='+ipaddressid;
    data += '&ipaddress='+ ipadrressname;
    xhr.send(data);
    xhr.onreadystatechange = function(){
      if(xhr.readyState === 4 && xhr.status === 200) {
        document.getElementById('stateViewer').innerHTML = xhr.responseText; 
      }
    }
  }

  function addFireWall(num){
    stateClose('stateViewer');
    document.getElementById('viewer').innerHTML = '';
    document.getElementById('viewer').style.display="table-row-group";
    var ipaddressid = document.forms[num].ipaddressid.value;
    var ipadrressname = document.forms[num].ipaddress.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST','fireWallRulesAdd.php'); 
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    var data = 'ipaddressid='+ipaddressid;
    data += '&ipaddress='+ ipadrressname;
    xhr.send(data);
    xhr.onreadystatechange = function(){
      if(xhr.readyState === 4 && xhr.status === 200) {
        document.getElementById('viewer').innerHTML = xhr.responseText; 
      }
    }
  }


  function deleteFireWallRules(num){
    num = parseInt(num) + parseInt(publicIp_length);
    document.forms[num].action = 'deleteFireWallRules.php';
    document.forms[num].method = "post";
    document.forms[num].submit();
    Alert.render('Fire Walls','삭제 요청을 진행 하고 있습니다 잠시만 기다려 주세요. ','');
  }

  function addFireWallRules(){
    var startPort = document.getElementById('startport').value;
    var endPort = document.getElementById('endport').value;
    var protocol = document.getElementById('protocol').value;
    var cidrList = document.getElementById('cidrlist').value;

    var form = document.getElementById('addFireWallForm');
    form.action ="fireWallRulesCreate.php";
    form.startport.value = startPort;
    form.endport.value = endPort;
    form.protocol.value = protocol;
    form.cidrlist.value = cidrList;
    form.submit();
    Alert.render('Fire Walls','신청 요청을 진행 하고 있습니다 잠시만 기다려 주세요. ','');
  }
