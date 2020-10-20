function _(el) {
    return document.getElementById(el);
}

var user = localStorage.getItem("user");

function uploadData() {
    var date = _("date").value;
    var heading = _("heading").value;
    var tml_month = _("tml_month").value;
    var tml_date = _("tml_date").value;
    var day = _("day").value;
    var thidhi = _("thidhi").value;
    var star = _("star").value;
    var event = _("event").value;

    var d = new Date(date);
    var dday = d.getDate();
    var dmonth = d.getMonth() + 1;
    var dyear = d.getFullYear();
    date = dday + "-" + dmonth + "-" + dyear;

    var cookie = document.cookie.split(';').map(cookie => cookie.split('=')).reduce((accumulator,[key,value]) => ({...accumulator,[key.trim()]:decodeURIComponent(value)}),{});
    
    var title;
    var title1;
    var title2;
    var url = cookie.url;
    var url1 = cookie.url1;
    var url2 = cookie.url2;

    if (url == "null") {
        title = url;
    } else {
        title = _("title").value;
    }

    if (url1 == "null") {
        title1 = url1;
    } else {
        title1 = _("title1").value;
    }

    if (url2 == "null") {
        title2 = url2;
    } else {
        title2 = _("title2").value;
    }
    var formdata = new FormData();
    formdata.append("date",date);
    formdata.append("heading",heading);
    formdata.append("tml_month",tml_month);
    formdata.append("tml_date",tml_date);
    formdata.append("day",day);
    formdata.append("thidhi",thidhi);
    formdata.append("star",star);
    formdata.append("event",event);
    formdata.append("url",url);
    formdata.append("title",title);
    formdata.append("url1",url1);
    formdata.append("title1",title1);
    formdata.append("url2",url2);
    formdata.append("title2",title2);
    $.ajax({
        xhr:function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress",function(evt){
                if(evt.lengthComputable) {
                    var percentComplete = ((evt.loaded / evt.total) * 100);
                    $("#progressbar").width(percentComplete+'%');
                    $("#final").html(Math.round(percentComplete) +'%');
                }
            },false);
            return xhr;
        },
        url:"php/newdbdhinachariyai.php",
        method:"POST",
        data:formdata,
        contentType:false,
        cache:false,
        processData:false,
        beforeSend:function() {
            $("#progressbar").width('0%');
        },
        success:function(data) {
            $("#final").html(data);
            logLoader(user + ">>New Dhinachariyai>>Database Data Upload>>" + data);
        },
        error:function() {
            $("#final").html("Upload Error");
            logLoader(user + ">>New Dhinachariyai>>Database Data Upload>> Upload Error");
        }
    });
    /*var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress",finalProgress,false);
    ajax.addEventListener("load",completeFinal,false);
    ajax.addEventListener("error",errorFinal,false);
    ajax.addEventListener("abort",abortFinal,false);
    ajax.open("POST","php/newdbdhinachariyai.php");
    ajax.send(formdata);*/
}

/*function finalProgress(event) {
    var percent = (event.loaded / event.total) * 100;
    _("progressbar").value = Math.round(percent);
    _("final").innerHTML = Math.round(percent) + ("% Completed...");
}

function completeFinal(event) {
    var result = event.target.responseText;
    _("final").innerHTML = result;
    logLoader(user + ">>New Dhinachariyai>>Database Data Upload>>" + result);
}

function errorFinal(event) {
    _("final").innerHTML = "Database not Updated.... ERROR";
    logLoader(user + ">>New Dhinachariyai>>Database Data Upload>>Upload Error");
}

function abortFinal(event) {
    _("final").innerHTML = "Database not Update... Interupted/Aborted";
    logLoader(user + ">>New Dhinachariyai>>Database Data Upload>>Upload Aborted/Interrupted");
}*/

function validateForm() {
    if (user == "user") {
        var date = _("date").value;
        var heading = _("heading").value;
        var tml_month = _("tml_month").value;
        var tml_date = _("tml_date").value;
        var day = _("day").value;
        var thidhi = _("thidhi").value;
        var star = _("star").value;
        var event = _("event").value;
        var file = _("file").value;
        var title = _("title").value;
        var file1 = _("file1").value;
        var title1 = _("title1").value;
        var file2 = _("file2").value;
        var title2 = _("title2").value;

        document.cookie="url=null";
        document.cookie="url1=null";
        document.cookie="url2=null";

        if(date == "" || heading == "" || tml_month == "" || tml_date == "" || day == "" || thidhi == "" || star == "" || event == "" || (file != "" && title == "") || (file1 != "" && title1 == "") || (file2 != "" && title2 == "")) {
            window.alert("You have missed Some fields there,,,");

            if (date == "") {
                _("date").style.borderColor = "#db2612";
            }
            if (heading == "") {
                _("heading").style.borderColor = "#db2612";
            }
            if (tml_month == "") {
                _("tml_month").style.borderColor = "#db2612";
            }
            if (tml_date == "") {
                _("tml_date").style.borderColor = "#db2612";
            }
            if (day == "") {
                _("day").style.borderColor = "#db2612";
            }
            if (thidhi == "") {
                _("thidhi").style.borderColor = "#db2612";
            }
            if (star == "") {
                _("star").style.borderColor = "#db2612";
            }
            if (event == "") {
                _("event").style.borderColor = "#db2612";
            }
            if (_("file").value != "" && title == "") {
                _("title").style.borderColor = "#db2612";
            }
            if ((_("file1").value != "" && title1 == "")) {
                _("title1").style.borderColor = "#db2612";
            }
            if (_("file2").value != "" && title2 == "") {
                _("title2").style.borderColor = "#db2612";
            }
        }
        else {
            if(_("file").value != "") {
                uploadDate();
            } else {
                uploadData();
            }
        }
    } else {
        logLoader(user + ">>New Dhinachariyai>>Access Denied");
    }
}

function uploadThird() {
    var filename = _("title2").value;
    var file = _("file2").files[0];
    var formdata = new FormData();
    formdata.append("name",filename);
    formdata.append("file",file);
    $.ajax({
        xhr:function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress",function(evt){
                if(evt.lengthComputable) {
                    var percentComplete = ((evt.loaded / evt.total) * 100);
                    $("#progress2").width(percentComplete+'%');
                    $("#status2").html(percentComplete+'%');
                }
            },false);
            return xhr;
        },
        url:"php/newdhinachariyai.php",
        method:"POST",
        data:formdata,
        contentType:false,
        cache:false,
        processData:false,
        beforeSend:function() {
            $("#progress2").width('0%');
        },
        success:function(data) {
            var result = data;
            var status;
            if(data == "fail") {
                document.cookie = "url2=null";
                status = "Failed";
            } else {
                document.cookie = "url2=" + result;
                status = "Uploaded";
            }
            $("#status2").html(status);
            logLoader(user + ">>New Dhincachariyai>>File Upload 3>>" + status);
            if (data != "fail") {
                uploadData();
            } else {
                window.alert("Upload Aborted");
            }
        },
        error:function() {
            $("#status2").html("Upload Error");
            logLoader(user + ">>New Dhincachariyai>>File Upload 3>> Upload Error");
        }
    });
    /*var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress",progressThird,false);
    ajax.addEventListener("load",completeThird,false);
    ajax.addEventListener("error",errorThird,false);
    ajax.addEventListener("abort",abortThird,false);
    ajax.open("POST","php/newdhinachariyai.php");
    ajax.send(formdata);*/
    
}

/*function progressThird(event) {
    var percent = (event.loaded / event.total) *100;
    _("progress2").value = Math.round(percent);
    _("status2").innerHTML = Math.round(percent) + "% uploaded... please wait !";
}

function completeThird(event) {
    var result = event.target.responseText;
    var status;
    if (result == "fail") {
        document.cookie = "url2=null";
        status = "Failed";
    } else {
        document.cookie = "url2=" + data;
        status = "Uploaded";
    }
    _("status2").innerHTML = status;
    logLoader(user + ">>New Dhincachariyai>>File Upload 3>>" + status);
    uploadData();
}

function errorThird(event) {
    _("status2").innerHTML = "Upload Failed...Error";
    logLoader(user + ">>New Dhinachariyai>>File Upload 3>>Upload Error");
}

function abortThird(event) {
    _("status2").innerHTML = "Uploaded Aborted/Interrupted";
    logLoader(user + ">>New Dhinachariyai>>File Upload 3>>Upload Aborted/Interrupted");
}*/

function uploadSecondFile() {
    var filename = _("title1").value;
    var file = _("file1").files[0];
    var formdata = new FormData();
    formdata.append("name",filename);
    formdata.append("file",file);
    $.ajax({
        xhr:function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress",function(evt){
                if(evt.lengthComputable) {
                    var percentComplete = ((evt.loaded / evt.total) * 100);
                    $("#progress1").width(percentComplete+'%');
                    $("#status1").html(percentComplete+'%');
                }
            },false);
            return xhr;
        },
        url:"php/newdhinachariyai.php",
        method:"POST",
        data:formdata,
        contentType:false,
        cache:false,
        processData:false,
        beforeSend:function() {
            $("#progress1").width('0%');
        },
        success:function(data) {
            var result = data;
            var status;
            if (data == "fail") {
                document.cookie="url1=null";
                status = "Failed";
            } else {
                document.cookie = "url1=" + result;
                status = "Uploaded";
            }

            $("#status1").html(status);
            logLoader(user + ">>new Dhinachariyai>>File Upload 2>>" + status);

            if (data != "fail") {
                if(_("file2").value != "") {
                    uploadThird();
                }
                else {
                    uploadData();
                }
            } else {
                window.alert("Upload Aborted");
            }
        },
        error:function() {
            $("#status1").html("Upload Error");
            logLoader(user + ">>new Dhinachariyai>>File Upload 2>> Upload Error");
        }
    });
    /*var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress",progressSecond,false);
    ajax.addEventListener("load",completeSecond,false);
    ajax.addEventListener("error",errorSecond,false);
    ajax.addEventListener("abort",abortSecond,false);
    ajax.open("POST","php/newdhinachariyai.php");
    ajax.send(formdata);*/
}

/*function progressSecond(event) {
    var percent = (event.loaded / event.total) * 100;
    _("progress1").value = Math.round(percent);
    _("status1").innerHTML = Math.round(percent) + "% uploaded... please wait !";
}

function completeSecond(event) {
    var result = event.target.responseText;
    var status;
    if (result == "fail") {
        document.cookie="url1=null";
        status = "Failed";
    }
    else {
        document.cookie = "url1=" + result;
        status = "Uploaded";
    }
    _("status1").innerHTML = status;

    logLoader(user + ">>new Dhinachariyai>>File Upload 2>>" + status);

    if (result != "fail") {
        if(_("file2").value != "") {
            uploadThird();
        }
        else {
            uploadData();
        }
    } else {
        window.alert("Uploading terminated, Please carry out again !!!");
    }
}

function errorSecond(event) {
    _("status1").innerHTML = "Upload Failed... Error";
    logLoader(user + ">>new Dhinachariyai>>File Upload 2>>Upload Error");
}

function abortSecond(event) {
    _("status1").innerHTML = "Upload Aborted/Interrupted";
    logLoader(user + ">>new Dhinachariyai>>File Upload 2>>Upload Aborted/Interrupted");
}*/

function uploadDate() {
    var filename = _("title").value;
    if(_("file").value != "") {
        var file = _("file").files[0];
        var formdata = new FormData();
        formdata.append("file",file);
        formdata.append("name",filename);
        $.ajax({
            xhr:function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress",function(evt){
                    if(evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $("#progress").width(percentComplete+'%');
                        $("#status").html(percentComplete+'%');
                    }
                },false);
                return xhr;
            },
            url:"php/newdhinachariyai.php",
            method:"POST",
            data:formdata,
            contentType:false,
            cache:false,
            processData:false,
            beforeSend:function() {
                $("#progress").width('0%');
            },
            success:function(data) {
                var result = data;
                var status;
                if (result == "fail") {
                    document.cookie="url=null";
                    status = "Failed";
                }
                else {
                    document.cookie="url=" + result;
                    status = "Uploaded";
                }
                //_("status").innerHTML = status;
                $("status").html(status);

                logLoader(user + ">>New Dhinachariyai>>File Upload 1>>" + status);

                if (result != "fail") {
                    if(_("file1").value != "") {
                        uploadSecondFile();
                    }
                    else {
                        uploadData();
                    }
                } else {
                    window.alert("Uploading Terminated, Please carry out again !!!");
                }
            },
            error:function() {
                $("status").html("Upload Error");
                logLoader(user + ">>New Dhinachariyai>>File Upload 1>> Upload Error");
            }
        });
        /*var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress",progressHandler,false);
        ajax.addEventListener("load",completeHandler,false);
        ajax.addEventListener("error",errorHandler,false);
        ajax.addEventListener("abort",abortHandler,false);
        ajax.open("POST","php/newdhinachariyai.php");
        ajax.send(formdata);*/

    }
    else {
        uploadData();
    }
}

/*function progressHandler(event) {
    var percent = (event.loaded / event.total) * 100;
    _("progress").value = Math.round(percent);
    _("status").innerHTML = Math.round(percent) + "% uploaded... please wait !";
}

function completeHandler(event) {
    var result = event.target.responseText;
    var status;
    if (result == "fail") {
        document.cookie="url=null";
        status = "Failed";
    }
    else {
        document.cookie="url=" + result;
        status = "Uploaded";
    }
    _("status").innerHTML = status;

    logLoader(user + ">>New Dhinachariyai>>File Upload 1>>" + status);

    if (result != "fail") {
        if(_("file1").value != "") {
            uploadSecondFile();
        }
        else {
            uploadData();
        }
    } else {
        window.alert("Uploading Terminated, Please carry out again !!!");
    }
}

function errorHandler(event) {
    _("status").innerHTML = "Upload Failed... Error";
    logLoader(user + ">>new Dhinachariyai>>File Upload 1>>Upload Error");
}

function abortHandler(event) {
    _("status").innerHTML = "Upload Aborted/Interrupted";
    logLoader(user + ">>new Dhinachariyai>>File Upload 1>>Upload Aborted/Interrupted");
}*/