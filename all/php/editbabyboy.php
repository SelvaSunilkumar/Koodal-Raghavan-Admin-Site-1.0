<?php

include 'dbconnector.php';

$name = $_POST['name'];
$edit_name = $_POST['editname'];

$update_query = "UPDATE boyname SET name = '$edit_name' WHERE name='$name'";
$update_result = mysqli_query($connection,$update_query);

if ($update_result) {
    echo 'Modification : Successfull';
} else {
    echo 'MOdification: Failed';
}
?>