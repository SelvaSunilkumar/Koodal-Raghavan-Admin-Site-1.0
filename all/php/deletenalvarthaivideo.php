<?php 

    include 'dbconnector.php';
    $file_url = $_POST['fileurl'];

    $delete_query = "DELETE FROM dailyvideo WHERE url='$file_url'";
    $delete_result = mysqli_query($connection,$delete_query);
    if ($delete_result) {
        echo 'Completed';
    }
    else {
        echo 'Failed';
    }

?>