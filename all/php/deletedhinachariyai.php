<?php 

include 'dbconnector.php';

$date = $_POST["date"];

$delete_query = "DELETE FROM dhinachariyai WHERE date='$date'";
$delete_result = mysqli_query($connection,$delete_query);

if ($delete_result) {
    echo "Sucessfull";
} else {
    echo "fail";
}

?>