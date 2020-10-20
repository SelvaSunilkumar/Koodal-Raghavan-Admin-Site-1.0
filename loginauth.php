<?php 

$message = $_POST["message"];
//$message = "Successfull";
$root_path = "./all/logs";
if (!is_dir($root_path)) {
    mkdir($root_path,0755,true);
} else {
    if (!file_exists($root_path."/loginlog.txt")) {
        file_put_contents($root_path."/loginlog.txt",'');
    }
    $client_ip = $_SERVER['REMOTE_ADDR'];
    $time = date('d/m/y H:iA',time());

    $contents = file_get_contents($root_path."/loginlog.txt");
    $contents .= "$client_ip \t $time \t $message \r";

    if(file_put_contents($root_path."/loginlog.txt",$contents)) {
        echo 'ok';
    } else {
        echo 'fail';
    }
}

?>