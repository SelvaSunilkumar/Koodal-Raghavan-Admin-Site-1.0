<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="./logs.js"></script>
        <?php 
            include 'php/dbconnector.php';
        ?>
        <script>
            function _(el) {
                return document.getElementById(el);
            }

            user = localStorage.getItem("user");

            function deleteFile() {
                var fileUrl = _("fileurl").value;
                if (fileUrl != '') {
                    if (user == "user") {
                        var formdata = new FormData();
                        formdata.append("fileurl",fileUrl);
                        $.ajax({
                            url:"php/deletenalvarthaivideo.php",
                            method:"POST",
                            data:formdata,
                            contentType:false,
                            cache:false,
                            processData:false,
                            success:function(data) {
                                $("#status").html(data);
                                logLoader(user + ">>Delete Nalvarthai Video>>" + event.target.responseText);
                            },
                            error:function() {
                                $("#status").html("Upload Error");
                                logLoader(user + ">>Delete Nalvarthai Video>>Upload Error");
                            }
                        });
                        /*var ajax = new XMLHttpRequest();
                        ajax.addEventListener("load",onComplete,false);
                        ajax.open("POST","php/deletenalvarthaivideo.php");
                        ajax.send(formdata);*/
                    } else {
                        logLoader(user + ">>Delete Nalvarthai Video>>Access Denied");
                    }
                }
                else {
                    window.alert("Please select a File from the List to Delete");
                }
            }

            function onComplete(event) {
                _("status").value = event.target.responseText;
                logLoader(user + ">>Delete Nalvarthai Video>>" + event.target.responseText);
            }

            function uploadFile() {
                if (user == "user") {
                    if(_("file").value != "") {
                        var file = _("file").files[0];
                        var folder = _("foldername").value;
                        var filename = _("filename").value;
                        var fileUrl = _("fileurl").value;
                        var formdata = new FormData();
                        formdata.append("file",file);
                        formdata.append("filename",filename);
                        formdata.append("foldername",folder);
                        formdata.append("url",fileUrl);
                        $.ajax({
                            xhr:function() {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress",function(evt){
                                    if(evt.lengthComputable) {
                                        var percentComplete = ((evt.loaded / evt.total) * 100);
                                        $("#progressbar").width(percentComplete+'%');
                                        $("#status").html(percentComplete+'%');
                                    }
                                },false);
                                return xhr;
                            },
                            url:"php/videonalvarthai.php",
                            method:"POST",
                            data:formdata,
                            contentType:false,
                            cache:false,
                            processData:false,
                            success:function(data) {
                                $("status").html(data);
                                logLoader(user + ">>Edit Nalvarthai Video>>File Upload>>" + data);
                            },
                            error:function() {
                                $("status").html("Upload Error");
                                logLoader(user + ">>Edit Nalvarthai Video>>File Upload>> Upload Error");
                            }
                        });
                        /*var ajax = new XMLHttpRequest();
                        ajax.upload.addEventListener("progress",progressHandler,false);
                        ajax.addEventListener("load",completeHandler,false);
                        ajax.addEventListener("error",errorHandler,false);
                        ajax.addEventListener("abort",abortHandler,false);
                        ajax.open("POST","php/videonalvarthai.php");
                        ajax.send(formdata);*/
                    } else {
                        if (confirm("Do you want to make changes with out changing the file or Url") == true) {
                            var folder = _("foldername").value;
                            var filename = _("filename").value;
                            var fileUrl = _("fileurl").value;
                            var formdata = new FormData();
                            formdata.append("filename",filename);
                            formdata.append("foldername",folder);
                            formdata.append("url",fileUrl);
                            $.ajax({
                                url:"php/editnalvarthaivideo.php",
                                method:"POST",
                                data:formdata,
                                contentType:false,
                                cache:false,
                                processData:false,
                                success:function(data) {
                                    $("status").html(data);
                                    logLoader(user + ">>Edit Nalvarthai Video>>" + data);
                                },
                                error:function() {
                                    $("status").html("Upload Error");
                                    logLoader(user + ">>Edit Nalvarthai Video>> Upload Error");
                                }
                            });
                            /*var ajax = new XMLHttpRequest();
                            ajax.addEventListener("load",onComplete,false);
                            ajax.open("POST","php/editnalvarthaivideo.php");
                            ajax.send(formdata);*/
                        }
                    }
                } else {
                    logLoader(user + ">>Edit Nalvarthai Video>>Access Denied");
                }
            }

            function onComplete(event) {
                _("status").innerHTML = event.target.responseText;
                logLoader(user + ">>Edit Nalvarthai Video>>" + event.target.responseText);
            }

            function progressHandler(event) {   
                var percent = (event.loaded / event.total) * 100;
                _("progressbar").value = Math.round(percent);
                _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
            }

            function completeHandler(event) {
                _("status").innerHTML = event.target.responseText;
                _("progressbar").value = 0;
                logLoader(user + ">>Edit Nalvarthai Video>>File Upload>>" + event.target.responseText);
            }

            function errorHandler(event) {
                _("status").innerHTML = "Upload Failed";
                logLoader(user + ">>Edit Nalvarthai Video>>File Upload Error");
            }

            function abortHandler(event) {
                _("status").innerHTML = "Upload Aborted/Interrupted";
                logLoader(user + ">>Edit Nalvarthai Video>>File Upload Aborted/Interrupted");
            }

        </script>
        <title>Thinam Oru Nalvarthai - Video</title>
        <link rel="shortcut icon" type="image/icon" href="icons/title_icon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            
            <div class="topelement">
                <h2>Thinam Oru Nalvarthai - Video</h2>
                <p>You can change and Delete the Video file Permanently from Database on <b>Two Clicks</b><br>
                <u><b>How to Delete a File</b></u> : Select the file to be deleted from the list down and press <b>DELETE button.</b><br>
                <u><b>How to Edit a File</b></u> : Select the file to be Edited from the list down and also can attach file from System <i>(if required of audio change)</i> and press <b>EDIT button.</b><br>
                <u><b>Note </b></u> : If you <b>Delete</b> or <b>Edit</b> the name, Click <b>Refresh button</b> after DELETE or EDIT</p>
                <div class="boxform">
                    <div class="form-group">
                        <input type="text" id="search" placeholder="Search" class="form-control" onkeyup="myFunction()">
                    </div>
                    <form class="form-inline" method="POST">
                        <div class="form-group">
                            <label>Folder Name : </label>
                            <input class="form-control" name="foldername" id="foldername" type="text">
                        </div>
                        <div class="form-group">
                            <label>File Name : </label>
                            <input class="form-control" name="filename" id="filename" type="text">
                        </div>
                        <div class="form-group">
                            <label>File Url : </label>
                            <input class="form-control" name="fileurl" id="fileurl" type="text" readonly>
                        </div>
                        <div class="form-group">
                            <label>Attach File : </label>
                            <input class="form-control" type="file" id="file">
                            <div class="prog">
                                <progress id="progressbar" value="0" max="100" style="width: 100%; height: 20px;"></progress>
                                <p id="status"></p>
                            </div>
                        </div>
                        <input type="button" value="Delete" onclick="deleteFile()" action="javascript:void(0)">
                        <input type="button" value="Upload File" onclick="uploadFile()" action="javascript:void(0)">
                        <button class="refresh" action="javascript:void(0)" onclick="refresh();">Refresh</button>
                    </form>
                    <script>
                        function refresh() {
                            window.location.reload();
                        }
                    </script>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table" id="table">
                    <thead>
                        <th>Folder Name</th>
                        <th>File Name</th>
                        <th>Location/URL</th>
                    </thead>
                    <tbody>
                        <?php 
                            if (!$connection) {
                                echo '<tr><td>*</td><td>Connection Failed to create with Database</td><td>*</td></tr>';
                            }
                            else {
                                $fetch_query = "SELECT * FROM dailyvideo";
                                $fetch_result = mysqli_query($connection,$fetch_query);

                                while ($fetch_row = mysqli_fetch_array($fetch_result)) {
                                    $folder_name = $fetch_row['folder'];
                                    $file_name = $fetch_row['name'];
                                    $url = $fetch_row['url'];

                                    echo "<tr>";
                                    echo "<td>$folder_name</td>";
                                    echo "<td>$file_name</td>";
                                    echo "<td>$url</td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <script>
                function myFunction() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("search");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("table");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        tfile = tr[i].getElementsByTagName("td")[1];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }  
                        if (tfile) {
                            txtValue = tfile.textContent || tfile.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }         
                    }
                }
            </script>
            <script>
                $(document).ready(function() {
                    $('#table tbody tr').click(function() {
                        var tableData = $(this).children("td").map(function() {
                            return $(this).text();
                        }).get();
                        var folderName = tableData[0];
                        var fileName = tableData[1];
                        var fileurl = tableData[2];
                        document.getElementById("foldername").value = folderName;
                        document.getElementById("filename").value = fileName;
                        document.getElementById("fileurl").value = fileurl;

                        document.body.scrollTop = 0;
                        document.documentElement.scrollTop = 0;
                    });
                });

                function _(el) {
                return document.getElementById(el);
            }
            function checkAttachment() {
                var fileAttachment = document.getElementById("file").value;
                var folderName = _("foldername").value;
                var fileName = _("filename").value;
                var fileUrl = _("fileurl").value;
                if (fileAttachment != '') {
                    var file = _("file").files[0];
                    var formData = new FormData();
                    formData.append("file",file);
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress",progressHandler,false);
                    ajax.addEventListener("load",completeHandler,false);
                    ajax.addEventListener("error",errorHandler,false);
                    ajax.addEventListener("abort",abortHandler,false);
                    ajax.open("POST","uploadnalvarthaivideo.php");
                    ajax.send(formData);
                }
                else {
                    window.alert("File not Attached");
                }
            }

            function progressHandler(event) {
                var percent = (event.loaded / event.total) * 100;
                _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
                _("progressbar").value = Math.round(percent);
            }

            function completeHandler(event) {
                _("status").innerHTML = event.target.responseText;
                _("progressbar").value = 100;
            }

            function errorHandler(event) {
                _("status").innerHTML = "Upload Terminated";
            }

            function abortHandler(event) {
                _("status").innerHTML = "Upload Interrupted/Aborted";
            }
            </script>
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
            background: rgb(141, 139, 139);
            color: aliceblue;
        }
        .boxform {
            border: 1px solid black;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .prog {
            margin-top: 5px;
            border: 1px solid black;
            padding: 10px;
            border-radius: 10px;
        }

        input[type=button] {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type=button]:hover {
            color: #000;
        }

        button {
            margin-top: 5px;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 10px;
            padding-right: 10px;
            border: none;
            border-radius: 5px;
        }
        .modify {
            background: #4CAF50;
            color: #fff;
        }
        .modify:hover {
            color: #000;
        }

        .refresh {
            background: rgb(61, 99, 224);
            color: #fff;
        }
        .refresh:hover {
            background: rgb(28, 91, 128);
        }
    </style>
</html>