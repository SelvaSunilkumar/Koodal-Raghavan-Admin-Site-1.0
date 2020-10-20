<?php
include 'dbconnector.php';
$name = $_POST["name"];
$delete_query = "DELETE from girlname WHERE name= '$name'";
$delete_result = mysqli_query($connection,$delete_query);

if ($delete_result) {
    echo "Deleted";
} else {
    echo '<script>window.alert("Name Deleted Status : Failed");</script>';
}

?>