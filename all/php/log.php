<?php

    include 'dbconnector.php';

    $date = $_POST["date"];
    $user = $_POST["user"];
    $ip = $_POST["ip"];
    $purpose = $_POST["purpose"];
    $status = $_POST["status"];

    $log_entry_query = "INSERT INTO `logs`(`date`, `user`, `ip`, `purpose`, `status`) VALUES ('$date','$user','$ip','$purpose','$status')";
    $log_entry_result = mysqli_query($connection,$log_entry_query);

    if ($log_entry_result) {
        echo "ok";
    } else {
        echo "fail";
    }

?>