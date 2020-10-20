<!DOCTYPE html>
<html>
    <head>
        <title>Edit Dhinachariyai</title>
        <link rel="shortcut icon" type="image/icon" href="icons/title_icon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="./logs.js"></script>
        <?php 
            include 'php/dbconnector.php';
        ?>
        <script>

            function _(el) {
                return document.getElementById(el);
            }

            var user = localStorage.getItem("user");

            function refresh() {
                window.location.reload();
            }

            function uploadData() {
                var date = _("date").value;
                var heading = _("heading").value;
                var tml_month = _("tml_month").value;
                var tml_day = _("tml_date").value;
                var day = _("day").value;
                var thidhi = _("thidhi").value;
                var star = _("star").value;
                var event = _("event").value;
                var title = _("title").value;
                var title1 = _("title1").value;
                var title2 = _("title2").value;
                var file = _("file").value;
                var file1 = _("file1").value;
                var file2 = _("file2").value;

                var cookie = document.cookie.split(';').map(cookie => cookie.split('=')).reduce((accumulator,[key,value]) => ({...accumulator,[key.trim()]:decodeURIComponent(value)}),{});
                var url = cookie.url;
                var url1 = cookie.url1;
                var url2 = cookie.url2;

                if (url == "null" && file =="") {
                    url = "no";
                } 

                if (url1 == "null" && file1 == "") {
                    url1 = "no";
                }

                if (url2 == "null" && file2 == "") {
                    url2 == "no";
                }
                
                var d = new Date(date);
                var dday = d.getDate();
                var dmonth = d.getMonth() + 1;
                var dyear = d.getFullYear();
                var date = dday + "-" + dmonth + "-" + dyear;
                var formdata =  new FormData();
                formdata.append("date",date);
                formdata.append("heading",heading);
                formdata.append("tml_month",tml_month);
                formdata.append("tml_day",tml_day);
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
                    url:"php/editdhinachariyai.php",
                    method:"POST",
                    data:formdata,
                    contentType:false,
                    cache:false,
                    processData:false,
                    success:function(data) {
                        logLoader(user + ">>Edit Dhinachariyai>>Database Modification>>" + data);
                        var status;
                        if (data == "fail") {
                            status = "Database Update Failed";
                        } else {
                            status = data;
                        }
                        window.alert(status);
                    }
                });
                /*var ajax = new XMLHttpRequest();
                ajax.addEventListener("load",finalComplete,false);
                ajax.open("POST","php/editdhinachariyai.php");
                ajax.send(formdata);*/
            }

            function finalComplete(event) {
                var response = event.target.responseText;
                var status;
                logLoader(user + ">>Edit Dhinachariyai>>Database Modification>>" + response);
                if (response == "fail") {
                    status = "Database Update Failed";
                } else{
                    status = response;
                }
                window.alert(status);
            }

            function uploadFirstFile() {
                if(_("file").value != "") {
                    var file = _("file").files[0];
                    var filename = _("title").value;
                    var formdata = new FormData();
                    formdata.append("file",file);
                    formdata.append("name",filename);
                    $.ajax({
                        xhr:function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress",function(evt) {
                                if(evt.lengthComputable) {
                                    var percentComplete = ((evt.loaded / evt.total) * 100);
                                    $("#progress").width(percentCompleted + '%');
                                    $("#status").html(Math.round(percentComplete) + '%');
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
                            var status;
                            logLoader(user + ">>Edit Dhinachariyai>>Upload File 1>>" + data);
                            if(data == "fail") {
                                document.cookie = "url=null";
                                status = "Failed to Upload";
                            } else {
                                document.cookie = "url=" + data;
                                status = "Uploaded";
                            }
                            $("#status").html(status);
                            uploadSecondFile();
                        },
                        error:function() {
                            logLoader(user + ">>Edit Dhinachariyai>>Upload File 1>>File Upload Error");
                            alert("Error");
                        }
                    });
                    /*var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress",progressFirstFile,false);
                    ajax.addEventListener("load",completeFirstFile,file);
                    ajax.addEventListener("error",errorFirstFile,false);
                    ajax.addEventListener("abort",abortFirstFile,false);
                    ajax.open("POST","php/newdhinachariyai.php");
                    ajax.send(formdata);*/
                }
                else {
                    uploadSecondFile();
                }
            }

            function progressFirstFile(event) {
                var percent = (event.loaded / event.total) * 100;
                _("progress").value = Math.round(percent);
                _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
            }

            function completeFirstFile(event) {
                var result = event.target.responseText;
                logLoader(user + ">>Edit Dhinachariyai>>Upload File 1>>" + result);
                var status;
                if (result == "fail") {
                    document.cookie = "url=null";
                    status = "Failed to Upload";
                } else {
                    document.cookie = "url=" + result;
                    status = "Uploaded";
                }
                _("status").innerHTML = status;
                uploadSecondFile();
            }

            function errorFirstFile(event) {
                _("status").innerHTML = "Upload Error !";
                logLoader(user + ">>Edit Dhinachariyai>>Upload File1>>Upload Error");
            }

            function abortFirstFile(event) {
                _("status").innerHTML = "Upload Interrupted/Aborted";
                logLoader(user + ">>Edit Dhinachariyai>>Upload File1>>Upload Aborted/Interrupted");
            }

            function uploadSecondFile() {
                if (_("file1").value != "") {
                    var file = _("file1").files[0];
                    var filename = _("title1").value;
                    var formdata = new FormData();
                    formdata.append("file",file);
                    formdata.append("name",filename);
                    $.ajax({
                        xhr:function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress",function(evt) {
                                if(evt.lengthComputable) {
                                    var percentComplete = ((evt.loaded / evt.total) * 100);
                                    $("#progress1").width(percentCompleted + '%');
                                    $("#status1").html(Math.round(percentComplete) + '%');
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
                            var status;
                            logLoader(user + ">>Edit Dhinachariyai>>Upload File 1>>" + data);
                            if(data == "fail") {
                                document.cookie = "url=null";
                                status = "Failed to Upload";
                            } else {
                                document.cookie = "url1=" + data;
                                status = "Uploaded";
                            }
                            $("#status1").html(status);
                            uploadThirdFile();
                        },
                        error:function() {
                            logLoader(user + ">>Edit Dhinachariyai>>Upload File 1>>File Upload Error");
                            alert("Error");
                        }
                    });
                    /*var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress",progressSecondFile,false);
                    ajax.addEventListener("load",completeSecondFile,false);
                    ajax.addEventListener("error",errorSecondFile,false);
                    ajax.addEventListener("abort",abortSecondFile,false);
                    ajax.open("POST","php/newdhinachariyai.php");
                    ajax.send(formdata);*/
                } else {
                    uploadThirdFile();
                }
            }

            function progressSecondFile(event) {
                var percent = (event.loaded / event.total) * 100;
                _("progress1").value = Math.round(percent);
                _("status1").innerHTML = Math.round(percent) + "% uploaded...";
            }

            function completeSecondFile(event) {
                var result = event.target.responseText;
                logLoader(user + ">>Edit Dhinachariyai>>Upload File2>>" + result);
                var status;
                if (result == "fail") {
                    document.cookie = "url1=null";
                    status = "Failed to Upload";
                } else {
                    document.cookie = "url1=" + result;
                    status = "Uploaded";
                }
                _("status1").innerHTML = status;
                uploadThirdFile();
            }

            function errorSecondFile(event) {
                _("status").innerHTML = "Upload Error";
                logLoader(user + ">>Edit Dhinachariyai>>Upload File2>>Upload Error");
            }

            function abortSecondFile(event) {
                _("status").innerHTML = "Upload Interrupted/Aborted";
                logLoader(user + ">>Edit Dhinachariyai>>Upload File2>>Upload Aborted/Interrupted");
            }

            function uploadThirdFile() {
                if (_("file2").value != "") {
                    var file = _("file2").files[0];
                    var filename = _("title2").value;
                    var formdata = new FormData();
                    formdata.append("file",file);
                    formdata.append("name",filename);
                    $.ajax({
                        xhr:function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress",function(evt) {
                                if(evt.lengthComputable) {
                                    var percentComplete = ((evt.loaded / evt.total) * 100);
                                    $("#progress2").width(percentCompleted + '%');
                                    $("#status2").html(Math.round(percentComplete) + '%');
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
                            var status;
                            logLoader(user + ">>Edit Dhinachariyai>>Upload File 1>>" + data);
                            if(data == "fail") {
                                document.cookie = "url=null";
                                status = "Failed to Upload";
                            } else {
                                document.cookie = "url2=" + data;
                                status = "Uploaded";
                            }
                            $("#status2").html(status);
                            //uploadSecondFile();
                            uploadData();
                        },
                        error:function() {
                            logLoader(user + ">>Edit Dhinachariyai>>Upload File 1>>File Upload Error");
                            alert("Error");
                        }
                    });
                    /*var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress",progressThirdFile,false);
                    ajax.addEventListener("load",completeThirdFile,false);
                    ajax.addEventListener("error",errorThirdFile,false);
                    ajax.addEventListener("abort",abortThirdFile,false);
                    ajax.open("POST","php/newdhinachariyai.php");
                    ajax.send(formdata);*/
                } else {
                    uploadData();
                }
            }

            function progressThirdFile(event) {
                var percent = (event.loaded / event.total) * 100;
                _("progress2").value = Math.round(percent);
                _("status2").innerHTML = Math.round(percent) + ("% uploaded...");
            }

            function completeThirdFile(event) {
                var result = event.target.responseText;
                var status;
                logLoader(user + ">>Edit Dhinachariyai>>Upload Folder3>>" + result);
                if (result == "fail") {
                    document.cookie = "url2=null";
                    status = "Upload Failed";
                } else {
                    document.cookie = "url2=" + result;
                    status = "Uploaded";
                }
                _("status2").innerHTML = status;
                uploadData();
            }

            function errorThirdFile(event) {
                _("status2").innerHTML = "Upload Error";
                logLoader(user + ">>Edit Dhinachariyai>>Upload Folder3>>Upload Error");
            }

            function abortThirdFile(event) {
                _("status2").innerHTML = "Upload Interrupted/Aborted";
                logLoader(user + ">>Edit Dhinachariyai>>Upload Folder3>>Upload Interrupted/Aborted");
            }
 
            function deleteForm() {
                var date = _("date").value;

                if (date == "") {
                    window.alert("Please select a Date to Delete");
                } else {
                    if (user == "user") {
                        if (confirm("Do you want to delete " + date + " and its corresponding data")) {
                            var d = new Date(date);
                            var dday = d.getDate();
                            var dmonth = d.getMonth() + 1;
                            var dyear = d.getFullYear();
                            var date = dday + "-" + dmonth + "-" + dyear;
                            var formdata = new FormData();
                            formdata.append("date",date);
                            $.ajax({
                                url:"php/deletedhinachariyai.php",
                                method:"POST",
                                data:formdata,
                                contentType:false,
                                cache:false,
                                processData:false,
                                success:function(data) {
                                    logLoader(user + ">>Delete Dhinachariyai>>" + data);
                                    if(data == "fail") {
                                        window.alert("Failed to Delete Date and corresponding Details");
                                        // _("result").innerHTML = "Failed to Modify Database";
                                        $("#result").html("Failed to Modify Database");
                                    } else {
                                        //_("result").innerHTMl = "Database Modified Sucessfully";
                                        $("#result").html("Database Modified Sucessfully");
                                        if (confirm("Deleted Date, Do you want to refresh this Page")) {
                                            window.location.reload();
                                        }
                                    }
                                }
                            });
                            /*var ajax = new XMLHttpRequest();
                            ajax.addEventListener("load",onDeleteComplete,false);
                            ajax.open("POST","php/deletedhinachariyai.php");
                            ajax.send(formdata);*/
                        } else{
                            console.log("No, Dont Delete");
                        }
                    } else {
                        logLoader(user + ">>Delete Dhinachariyai>>Access Denied");
                    }
                }
            }

            function onDeleteComplete(event) {
                var result = event.target.responseText;
                var status;
                logLoader(user + ">>Delete Dhinachariyai>>" + result);
                if (result == "fail") {
                    window.alert("Failed to Delete Date and corresponding Details");
                    _("result").innerHTML = "Failed to Modify Database";
                } else {
                    _("result").innerHTMl = "Database Modified Sucessfully";
                    if (confirm("Deleted Date, Do you want to refresh this Page")) {
                        window.location.reload();
                    }
                }
            }

            function validateForm() {
                if (user == "user") {
                    var date = _("date").value;
                    var heading = _("heading").value;
                    var tml_month = _("tml_month").value;
                    var tml_day = _("tml_date").value;
                    var day = _("day").value;
                    var thidhi = _("thidhi").value;
                    var star = _("star").value;
                    var event = _("event").value;
                    var title = _("title").value;
                    var title1 = _("title1").value;
                    var title2 = _("title2").value;
                    var file = _("file").value;
                    var file1 = _("file1").value;
                    var file2 = _("file2").value;

                    if (date == "" || heading == "" || tml_month == "" || tml_day == "" || day == "" || thidhi == "" || star == "" || event == "" || (file != "" && title == "") || (file1 != "" && title1 == "") || (file2 != "" && title2 == "")) {
                        if (date == "") {
                            _("date").style.borderColor = "#db2612";
                        }
                        if (heading == "") {
                            _("heading").style.borderColor = "#db2612";
                        }
                        if (tml_month == "") {
                            _("tml_month").style.borderColor = "#db2612";
                        }
                        if (tml_day == "") {
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
                        if (file != "" && title == "") {
                            _("title").style.borderColor = "#db2612";
                        }
                        if (file1 != "" && title1 == "") {
                            _("title1").style.borderColor = "#db2612";
                        }
                        if (file2 != "" && title2 == "") {
                            ("title2").style.borderColor = "#db2612";
                        }
                    } else {
                        document.cookie = "url = null";
                        document.cookie = "url1 = null";
                        document.cookie = "url2 = null";

                        uploadFirstFile();

                        /*if (file != "") {
                            uploadFirstFile();
                        }
                        if (file1 != "") {
                            uploadSecondFile();
                        }
                        if (file2 != "") {
                            uploadThirdFile();
                        }
                        //code to update server

                        
                        }*/
                    }
                } else {
                    logLoader(user + ">>Edit Dhinachariyai>>Access Denied");
                }
            }

        </script>
    </head>
    <body>
        <div class="container">
            <div class="topelement">
            <h2>Dhinachariyai</h2>
                <p>You can change and Delete the Date file Permanently from Database on <b>Two Clicks</b><br>
                <u><b>How to Delete a Date</b></u> : Select the file to be deleted from the list down and press <b>DELETE button.</b><br>
                <u><b>How to Edit a Date</b></u> : Select the file to be Edited from the list down and also can attach file from System <i>(if required of audio change)</i> and press <b>EDIT button.</b><br>
                <u><b>Note </b></u> : If you <b>Delete</b> or <b>Edit</b> the date, Click <b>Refresh button</b> after DELETE or EDIT</p>

                <div class="boxform">
                    <form method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" name="search" id="search" placeholder="Search by Date" onkeyup="myFunction()">
                        </div>
                        <div class="form-inline">
                            <label for="date">Date : </label>
                            <input type="date" id="date" class="form-control" required>
                            <label for="heading">Heading : </label>
                            <textarea class="form-control" id="heading"></textarea>
                            <label for="tml_month">Tml Month : </label>
                            <input type="text" id="tml_month" class="form-control">
                            <label for="tml_date">Tml Date : </label>
                            <input type="number" id="tml_date" class="form-control"> 
                        </div>                       
                        <div class="form-inline">
                            <label for="day">Day : </label>
                            <input type="text" id="day" class="form-control">
                            <label for="thidhi">Thidhi : </label>
                            <input type="text" id="thidhi" class="form-control">
                            <label for="star">Star : </label>
                            <input type="text" id="star" class="form-control">
                            <label for="event">Event : </label>
                            <textarea id="event" class="form-control"></textarea>
                        </div>
                        <div class="form-inline">
                            <label for="file">Attachment 1</label>
                            <input type="file" class="form-control" id="file">
                            <label for="title">Title : </label>
                            <input type="text" id="title" class="form-control">
                            <div class="form-group">
                                <progress id="progress" value="1" max="100" style="widht= 100%;height= 10px;"></progress>
                                <p id="status">0% uploaded</p>
                            </div>
                        </div>
                        <div class="form-inline">
                            <label for="file1">Attachment 2</label>
                            <input type="file" class="form-control" id="file1">
                            <label for="title1">Title : </label>
                            <input type="text" id="title1" class="form-control">
                            <div class="form-group">
                                <progress id="progress1" value="1" max="100" style="widht= 100%;height= 10px;"></progress>
                                <p id="status1">0% uploaded</p>
                            </div>
                        </div>
                        <div class="form-inline">
                            <label for="file2">Attachment 3</label>
                            <input type="file" class="form-control" id="file2">
                            <label for="title2">Title : </label>
                            <input type="text" id="title2" class="form-control">
                            <div class="form-group">
                                <progress id="progress2" value="1" max="100" style="widht= 100%;height= 10px;"></progress>
                                <p id="status2">0% uploaded</p>
                            </div>
                        </div>
                        <div>
                            <p id="result"></p>
                        </div>
                        <div class="form-inline">
                            <input type="button" id="de" value="Delete" action="javascript:void(0)" onclick="deleteForm()" class="form-control">
                            <input type="button" id="de" value="Edit" action="javascript:void(0)" onclick="validateForm()" class="form-control">
                            <input type="button" id="re" value="Refresh" class="form-control" onclick="refresh()">
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                            <th>Date</th>
                            <th>Heading</th>
                            <th>Tml Month</th>
                            <th>Tml Date</th>
                            <th>Tml Day</th>
                            <th>Thidhi</th>
                            <th>Star</th>
                            <th>Event</th>
                            <th>Title</th>
                            <th>Title1</th>
                            <th>Title2</th>
                        </thead>
                        <tbody>
                            <?php 
                                $get_query = "SELECT * FROM dhinachariyai";
                                $get_result = mysqli_query($connection,$get_query);

                                while ($get_row = mysqli_fetch_array($get_result)) {
                                    $date = $get_row['date'];
                                    $heading = $get_row['heading'];
                                    $tml_month = $get_row['tml_month'];
                                    $tml_day = $get_row['tml_day'];
                                    $day = $get_row['day'];
                                    $thidhi = $get_row['thidhi'];
                                    $star = $get_row['star'];
                                    $event = $get_row['event'];
                                    $title = $get_row['title1'];
                                    $title1 = $get_row['title2'];
                                    $title2 = $get_row['title3'];

                                    echo "<tr>";
                                    echo "<td>$date</td>";
                                    echo "<td>$heading</td>";
                                    echo "<td>$tml_month</td>";
                                    echo "<td>$tml_day</td>";
                                    echo "<td>$day</td>";
                                    echo "<td>$thidhi</td>";
                                    echo "<td>$star</td>";
                                    echo "<td>$event</td>";
                                    echo "<td>$title</td>";
                                    echo "<td>$title1</td>";
                                    echo "<td>$title2</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    <script>
                        function myFunction() {
                            var input, filter, table, tr, td, i, txtValue;
                            input = document.getElementById("search");
                            filter = input.value.toUpperCase();
                            table = document.getElementById("table");
                            tr = table.getElementsByTagName("tr");
                            for (i = 0; i < tr.length; i++) {
                                tdate = tr[i].getElementsByTagName("td")[0];
                                if (tdate) {
                                    txtValue = tdate.textContent || tdate.innerText;
                                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                        tr[i].style.display = "";
                                    } else {
                                        tr[i].style.display = "none";
                                    }
                                }       
                            }
                        }
                    </script>
                </div>
                <script>
                    $(document).ready(function() {
                        $('#table tbody tr').click(function() {
                            var tabledata = $(this).children("td").map(function() {
                                return $(this).text();
                            }).get();
                            var date = tabledata[0];
                            var heading = tabledata[1];
                            var tml_month = tabledata[2];
                            var tml_day = tabledata[3];
                            var day = tabledata[4];
                            var thidhi = tabledata[5];
                            var star = tabledata[6];
                            var event = tabledata[7];
                            var title = tabledata[8];
                            var title1 = tabledata[9];
                            var title2 = tabledata[10];

                            var fields = date.split('-');
                            var string;
                            if (fields[0] < 10) {
                                string = "0" + fields[0];
                            }
                            else {
                                string = fields[0];
                            }
                            var month;
                            if (fields[1] <10) {
                                month = "0" + fields[1];
                            }
                            else {
                                month = fields[1];
                            }
                            _("date").value = fields[2] + "-" + month + "-" + string;
                            _("heading").value = heading;
                            _("tml_month").value = tml_month;
                            _("tml_date").value = tml_day;
                            _("day").value = day;
                            _("thidhi").value = thidhi;
                            _("star").value = star;
                            _("event").value = event;
                            _("title").value = title;
                            _("title1").value = title1;
                            _("title2").value = title2;

                            console.log(month);

                            document.body.scrollTop = 0;
                            document.documentElement.scrollTop = 0;
                        });
                    });
                </script>
            </div>
        </div>
    </body>
    <style>
        .table thead {
            background:rgb(141, 139, 139);
        }
        .table tr{
            background: #fff;
        }
        .table tr:hover {
            background: #bbbdbf;
        }
        #de {
            color: #fff;
            background-color: #31b554;
        }
        #de:hover {
            color: #000;
        }
        #re {
            color: #fff;
            background-color: #4287f5;
        }
        #re:hover {
            background-color: #335ea3;
        }
    </style>
</html>