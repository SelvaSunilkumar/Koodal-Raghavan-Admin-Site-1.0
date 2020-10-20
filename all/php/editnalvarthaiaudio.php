<?php 

    include 'dbconnector.php';

    $folder_name = $_POST["foldername"];
    $file_name = $_POST["filename"];
    $file_url = $_POST["url"];

    $update_query = "UPDATE dailyaudio SET folder='$folder_name',name='$file_name' WHERE url='$file_url'";
    $update_result = mysqli_query($connection,$update_query);

    if ($update_result) {
        echo "Database Modified, Please refresh page";
    } else {
        echo "Database Modification failed to Process";
    }

?>