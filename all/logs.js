function logLoader(purpose) {
    
    var formdata = new FormData();
    formdata.append("message",purpose);
    
    var ajax = new XMLHttpRequest();
    ajax.addEventListener("load",onLogLoadHandler,false);
    var url = encodeURI("php/logs.php");
    ajax.open("POST","php/logs.php");
    ajax.send(formdata);
    console.clear();
}

function onLogLoadHandler(event) {
}