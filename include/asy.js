//맨 아래거가 쓰이는 거임.

 function setCookie(cName, cValue, cDay){
        var expire = new Date();
        expire.setDate(expire.getDate() + cDay);
        cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)를 합니다.
        if(typeof cDay != 'undefined') cookies += ';expires=' + expire.toGMTString() + ';';
        document.cookie = cookies;
}
 
    // 쿠키 가져오기
    function getCookie(cName) {
        cName = cName + '=';
        var cookieData = document.cookie;
        var start = cookieData.indexOf(cName);
        var cValue = '';
        if(start != -1){
            start += cName.length;
            var end = cookieData.indexOf(';', start);
            if(end == -1)end = cookieData.length;
            cValue = cookieData.substring(start, end);
        }
        return unescape(cValue);
    }
  
/*
  function test(jobid){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'asynchronousPart.php');
    xhr.onreadystatechange = function(){
      document.querySelector('#state').innerHTML = xhr.responseText;
    }
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    var data = '';
    data += "jobid="+jobid;
    xhr.send(data);
  }

  function testSeparate(jobid, num){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'asynchronousPart.php');
    xhr.onreadystatechange = function(){
      document.querySelector('#state'+num).innerHTML = xhr.responseText;
   //   alert(document.querySelector('#state'+num).innerHTML);
    }
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    var data = '';
    data += "jobid="+jobid;
    data += "&jobRank="+num;
    xhr.send(data);
    
  }

  function testSeparate2(jobid, num, timeid){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/asynchronousPart.php');
    xhr.onreadystatechange = function(){
      if(xhr.readyState === 4 && xhr.status === 200) {
        document.querySelector('#state'+num).innerHTML = xhr.responseText;
        var temp = getCookie(jobid);
        alert(temp);
    //  alert(getCookie(num));
        if(temp =="DONE"){
          clearInterval(timeid);
        }
   //   alert(document.querySelector('#state'+num).innerHTML);
      }
    }
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    var data = '';
    data += "jobid="+jobid;
    data += "&jobRank="+num;
    xhr.send(data);
    
  }*/ //이제 이거 쓰면 큰일난다.

   myServer = function(){
    location.replace('myServer.php');
   }


    function testSeparate3(jobid, url ,num, timeid){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.onreadystatechange = function(){
      if(xhr.readyState === 4 && xhr.status === 200) {
        var temp = xhr.responseText;
        document.querySelector('#state'+num).innerHTML = temp;
      //  var temp = getCookie(jobid);
      //  alert(temp);
    //  alert(getCookie(num));
    //    if(temp =="DONE"){
    //      clearInterval(timeid);
    //    }
        if(temp.match('StopVM')) {
          Confirm.render('Server','서버 종료가 완료 되었습니다.','','')
        }
        if(temp.match('done')) {
          clearInterval(timeid);
        }
   //   alert(document.querySelector('#state'+num).innerHTML);
      }
    }
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    var data = '';
    data += "jobid="+jobid;
    data += "&jobRank="+num;
    xhr.send(data);
    
  }
    
     