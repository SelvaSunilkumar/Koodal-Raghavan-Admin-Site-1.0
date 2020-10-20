<?php 

    $username = $_POST["username"];
    $password = $_POST["password"];
    $out = '';

    if($username == "koodaladmin" && $password == "admin@koodal120") {
        $out .= 'ok';
    } else {
        $out .= 'fail';
    }
    echo $out;

?>