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

            var user = localStorage.getItem("user");

            function editName() {
                var name = _("name").value;
                var edit = _("editname").value;
                if (name != '' && edit != '') {
                    if (user == "user") {
                        var formdata = new FormData();
                        formdata.append("name",name);
                        formdata.append("editname",edit);
                        var ajax = new XMLHttpRequest();
                        ajax.addEventListener("load",onComplete,false);
                        ajax.open("POST","php/editbabyboy.php");
                        ajax.send(formdata);
                    } else {
                        logLoader(user + ">>Edit BabyName Boy>>Access Denied");
                    }
                }
                else {
                    window.alert("Some sort of Details are Missing...");
                }
            }

            function deleteName() {
                var name = _("name").value;
                if (name != '') {
                    if (user == "user") {
                        var formdata = new FormData();
                        formdata.append("name",name);
                        var ajax = new XMLHttpRequest();
                        ajax.addEventListener("load",onCompleteDelete,false);
                        ajax.open("POST","php/deletebabyboy.php");
                        ajax.send(formdata);
                    } else {
                        logLoader(user + ">>Delete BabyName Boy>>Access Denied");
                    }
                }
                else {
                    window.alert("Some sort of Details are Missing...");
                }
            }

            function onCompleteDelete(event) {
                _("status").innerHTML = event.target.responseText;
                logLoader(user + ">>Delete Baby Name Boy>>" + event.target.responseText);
            }

            function onComplete(event) {
                _("status").innerHTML = event.target.responseText;
                logLoader(user + ">>Edit Babyname Boy>>" + event.target.responseText);
            }
        </script>
        <title>Baby Names - Boy</title>
        <link rel="shortcut icon" type="image/icon" href="icons/title_icon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            
            <div class="topelement">
                <h2>Baby Names - Boy</h2>
                <p>You can change and delete a Name permanently from Database on just <b>Two Clicks</b><br>
                <u><b>How to Delete a Name</b></u> : Select a Name from the List and click <b>DELETE button</b><br>
                <u><b>How to Edit a Name</b></u> : Select a Name from the List and Type new Name in the Empty box <i>(other box)</i> and click <b>EDIT button</b><br>
                <u><b>Note </b></u> : If you <b>Delete</b> or <b>Edit</b> the name, Click <b>Refresh button</b> after DELETE or EDIT</p>
                <div class="boxform">
                    <form method="POST">
                        <div class="form-group">
                            <input type="text" id="search" placeholder="Search" class="form-control" onkeyup="myFunction()">
                        </div>
                        <div class="form-group">
                            <label>Baby Name : </label>
                            <input class="form-control" id="name" name="name" type="text" readonly>
                        </div>
                        <input type="button" class="modify" value="Delete Name" onclick="deleteName()" action="javascript:void(0)">
                        <div class="form-group">
                            <label>Edit Baby Name : </label>
                            <input class="form-control" id="editname" name="editname" type="text">
                        </div>
                        <input type="button" class="modify" value="Edit Name" onclick="editName()" action="javascript:void(0)">
                        <input type="button" class="refresh" value="Refresh" onclick="refresh()" action="javascript:void(0)">
                        <div class="form-group">
                            <p id="status"></p>
                        </div>
                    </form>
                    <script>
                        function refresh() {
                            window.location.reload();
                            //getCookies();
                        }
                    </script>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table" id="table">
                    <thead>
                        <th>Name</th>
                    </thead>
                    <tbody>
                        <?php 
                            if ($connection) {
                                $name_query = "SELECT * FROM boyname";
                                $name_result = mysqli_query($connection,$name_query);

                                while ($name_row = mysqli_fetch_array($name_result)) {
                                    $baby_name = $name_row['name'];
                                    echo "<tr>";
                                    echo "<td>$baby_name</td>";
                                    echo "</tr>";
                                }
                            }
                            else {
                                echo '<tr><td> * Connection Failed to Establish with Server *</td></tr>';
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
                        if (td) {
                            txtValue = td.textContent || td.innerText;
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
                        var name = tableData[0];
                        document.getElementById("name").value = name;

                        document.body.scrollTop = 0;
                        document.documentElement.scrollTop = 0;
                    })
                })
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

        button, input[type=button] {
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 10px;
            padding-right: 10px;
            border: none;
            border-radius: 5px;
        }
        .modify {
            background: #4CAF50;
        }
        .modify:hover {
            color: #fff;
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