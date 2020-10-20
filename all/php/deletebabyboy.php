<?php
include 'dbconnector.php';
$name = $_POST["name"];
$delete_query = "DELETE from boyname WHERE name= '$name'";
$delete_result = mysqli_query($connection,$delete_query);

if ($delete_result) {
    echo "Deleted";
} else {
    echo 'Failed';
}

?>