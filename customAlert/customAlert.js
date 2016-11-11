function CustomAlert(){
    var result;
    this.render = function(head,dialog,foot){
        result = false;
        setAlertPosition();
        window.addEventListener("resize",setAlertPosition);
        document.getElementById('dialogboxhead').innerHTML = head;
        document.getElementById('dialogboxbody').innerHTML = dialog;
        if(foot=='default'){
            document.getElementById('dialogboxfoot').innerHTML = '<button class="button2" onclick="Alert.ok()">OK</button>';
        } else {
            document.getElementById('dialogboxfoot').innerHTML = foot;
        }

    }
    this.ok = function(){
        document.getElementById('dialogbox').style.display = "none";
        document.getElementById('dialogoverlay').style.display = "none";
    }
    function setAlertPosition() {
        var winW = window.innerWidth;
        var winH = window.innerHeight;
        var dialogoverlay = document.getElementById('dialogoverlay');
        var dialogbox = document.getElementById('dialogbox');
        dialogoverlay.style.display = "block";
        dialogoverlay.style.height = winH+"px";

        dialogbox.style.left = (winW/2) - (550 * .5)+"px";
        dialogbox.style.top = "100px";
        dialogbox.style.display = "block";
    }
}
var Alert = new CustomAlert();

function asyAlerter(){
    var result;
    var dialogoverlay;
    var dialogbox;
    var div;
    var dialogboxhead;
    var dialogboxbody;
    var dialogboxfoot;
    var button;

    this.render = function(obj_var, head,dialog,foot){
        result = false;
        makeAlertView();
        setAlertPosition();
        window.addEventListener("resize",setAlertPosition);

        dialogboxhead.innerHTML = head;
        dialogboxbody.innerHTML = dialog;
        if(foot=='default'){
            makeButton(obj_var);
            dialogboxfoot.appendChild(button);
        } 
    }

    this.ok = function(){
        deleteAlertView();
    }


    function makeAlertView() {
        dialogoverlay = document.createElement('div');
        dialogbox = document.createElement('div');
        div = document.createElement('div');
        dialogboxhead = document.createElement('div');
        dialogboxbody = document.createElement('div');
        dialogboxfoot = document.createElement('div');

        dialogoverlay.setAttribute('class', 'dialogoverlay');
        dialogbox.setAttribute('class', 'dialogbox');
        dialogboxhead.setAttribute('class', 'dialogboxhead');
        dialogboxbody.setAttribute('class', 'dialogboxbody');
        dialogboxfoot.setAttribute('class', 'dialogboxfoot');

        div.appendChild(dialogboxhead);
        div.appendChild(dialogboxbody);
        div.appendChild(dialogboxfoot);
        dialogbox.appendChild(div);
        
        document.body.appendChild(dialogoverlay);
        document.body.appendChild(dialogbox);
    }

    function setAlertPosition() {
        var winW = window.innerWidth;
        var winH = window.innerHeight;
        dialogoverlay.style.display = "block";
        dialogoverlay.style.height = winH+"px";

        dialogbox.style.left = (winW/2) - (550 * .5)+"px";
        dialogbox.style.top = "100px";
        dialogbox.style.display = "block";
    }

    function makeButton(obj_var) {
        button = document.createElement('button');
        button.setAttribute('class','button2');
        button.setAttribute('onclick', obj_var+".ok()");
        button.innerHTML = "OK";
    }

    
    function deleteAlertView() {
        
    //    dialogboxfoot.removeChild(button);
    //    div.removeChild(dialogboxhead);
    //    div.removeChild(dialogboxbody);
    //    div.removeChild(dialogboxfoot);
    //    dialogbox.removeChild(div);
        
        dialogoverlay.parentNode.removeChild(dialogbox);
        dialogoverlay.parentNode.removeChild(dialogoverlay);
    }
    
}

function deletePost(id){
    var db_id = id.replace("post_", "");
    // Run Ajax request here to delete post from database
    document.body.removeChild(document.getElementById(id));
}

function CustomConfirm(){
    var anyFunction;
    var parameters;
    this.render = function(head,dialog,func,par,no){
        anyFunction = func;
        parameters = par;
        setAlertPosition();
        window.addEventListener("resize",setAlertPosition);
        
        document.getElementById('dialogboxhead').innerHTML = head;
        document.getElementById('dialogboxbody').innerHTML = dialog;
        if(no == "use") {
            document.getElementById('dialogboxfoot').innerHTML = '<button class=\'button2\' onclick="Confirm.yes();">Yes</button> <button  class=\'button2\' onclick="Confirm.no()">No</button>';
        } else {
            document.getElementById('dialogboxfoot').innerHTML = '<button class=\'button2\' onclick="Confirm.yes();">Yes</button>'
        }
    }
    this.no = function(){
        document.getElementById('dialogbox').style.display = "none";
        document.getElementById('dialogoverlay').style.display = "none";
        anyFunction=''; parameters='';
    }
    this.yes = function(){
        anyFunction(parameters); //익명의 함수.
        anyFunction=''; parameters='';
        document.getElementById('dialogbox').style.display = "none";
        document.getElementById('dialogoverlay').style.display = "none";
    }
    function setAlertPosition() {
        var winW = window.innerWidth;
        var winH = window.innerHeight;
        var dialogoverlay = document.getElementById('dialogoverlay');
        var dialogbox = document.getElementById('dialogbox');
        dialogoverlay.style.display = "block";
        dialogoverlay.style.height = winH+"px";

        dialogbox.style.left = (winW/2) - (550 * .5)+"px";
        dialogbox.style.top = "100px";
        dialogbox.style.display = "block";
    }
}
var Confirm = new CustomConfirm();
/*
function CustomConfirm2(){
    var parameters;
    this.render = function(head,dialog,func,par,no){
        parameters = par;
        setAlertPosition();
        window.addEventListener("resize",setAlertPosition);
        
        document.getElementById('dialogboxhead').innerHTML = head;
        document.getElementById('dialogboxbody').innerHTML = dialog;
        if(no == "use") {
            document.getElementById('dialogboxfoot').innerHTML = '<button class=\'button2\' onclick="Confirm.yes(\''+func+'\');">Yes</button> <button  class=\'button2\' onclick="Confirm.no()">No</button>';
        } else {
            document.getElementById('dialogboxfoot').innerHTML = '<button class=\'button2\' onclick="Confirm.yes(\''+func+'\');">Yes</button>'
        }
    }
    this.no = function(){
        document.getElementById('dialogbox').style.display = "none";
        document.getElementById('dialogoverlay').style.display = "none";
      //  anyFunction=''; 
        parameters='';
    }
    this.yes = function(func){
    //    alert(this.anyFunction);
        window[func](parameters);
     //   anyFunction=''; 
        parameters='';
        document.getElementById('dialogbox').style.display = "none";
        document.getElementById('dialogoverlay').style.display = "none";
    }
    function setAlertPosition() {
        var winW = window.innerWidth;
        var winH = window.innerHeight;
        var dialogoverlay = document.getElementById('dialogoverlay');
        var dialogbox = document.getElementById('dialogbox');
        dialogoverlay.style.display = "block";
        dialogoverlay.style.height = winH+"px";

        dialogbox.style.left = (winW/2) - (550 * .5)+"px";
        dialogbox.style.top = "100px";
        dialogbox.style.display = "block";
    }
}
*/
function CustomPrompt(){
    var parameters;
    this.render = function(head,dialog,type,func,para) {
        parameters = para;
        setAlertPosition();
        window.addEventListener("resize",setAlertPosition);

        document.getElementById('dialogboxhead').innerHTML = head;
        document.getElementById('dialogboxbody').innerHTML = dialog;
        document.getElementById('dialogboxbody').innerHTML += '<input type="'+type+'" class="transparent" id="prompt_value1">';
        document.getElementById('dialogboxfoot').innerHTML = '<button class="button2" onclick="Prompt.ok(\''+func+'\')">OK</button> <button class="button2" onclick="Prompt.cancel()">Cancel</button>';
    }
    this.cancel = function(){
        document.getElementById('dialogbox').style.display = "none";
        document.getElementById('dialogoverlay').style.display = "none";
        parameters='';
    }
    this.ok = function(func){
        var prompt_value1 = document.getElementById('prompt_value1').value;

        if( window[func](parameters,prompt_value1) == true) {
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        parameters='';
    }

    function setAlertPosition() {
        var winW = window.innerWidth;
        var winH = window.innerHeight;
        var dialogoverlay = document.getElementById('dialogoverlay');
        var dialogbox = document.getElementById('dialogbox');
        dialogoverlay.style.display = "block";
        dialogoverlay.style.height = winH+"px";

        dialogbox.style.left = (winW/2) - (550 * .5)+"px";
        dialogbox.style.top = "100px";
        dialogbox.style.display = "block";
    }
}
var Prompt = new CustomPrompt();