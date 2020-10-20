<?php 


/*$folder = $_POST["foldername"];

$TempPath = "../../../unrestricted/Nalvarthai";
$filePath = "../../../unrestricted/Nalvarthai/$folder";

if (!file_exists($TempPath)) {
    if (!mkdir($TempPath, 0755, true)) {
       echo "Failed to create";
       return;
    }
 }
 $filePath = "../../../unrestricted/Nalvarthai/$folder";
 if (!file_exists($filePath)) {
    if (!mkdir($filePath, 0755, true)) {
       echo "failed to create folder";
       return;
    }
 }
 $fileName = $_POST["filename"];

 if (0 < $_FILES['file']['error']) {
     echo "file error";
 } else {
     if (move_uploaded_file($_FILES['file']['tmp_name'],$filePath.'/'.$fileName.'.mp4')) {
         echo "ok";
     } else {
         echo "fail";
     }
 }
 exit();*/
 function verbose($ok=1,$info=""){
    // failure to upload throws 400 error
    if ($ok==0) { echo "Failed"; }
    else {
       echo "ok";
    }
    exit();
 }
 // invalid upload
 if (empty($_FILES) || $_FILES['file']['error']) {
    verbose(0, "Failed to move uploaded file.");
 }
 // upload destination
 $folder = $_POST["foldername"];
 $TempPath = "../../../unrestricted/Nalvarthai";
 if (!file_exists($TempPath)) {
    if (!mkdir($TempPath, 0755, true)) {
       verbose(0, "Failed to create $TempPath");
    }
 }
 $filePath = "../../../unrestricted/Nalvarthai/$folder";
 if (!file_exists($filePath)) {
    if (!mkdir($filePath, 0755, true)) {
       verbose(0, "Failed to create $filePath");
    }
 }
 //$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
 $fileName = $_POST["filename"];
 $filePath = $filePath . DIRECTORY_SEPARATOR . $fileName.".mp4";
 // dealing with the chunks
 $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
 $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
 $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
 if ($out) {
    $in = @fopen($_FILES['file']['tmp_name'], "rb");
    if ($in) {
       while ($buff = fread($in, 4096)) { fwrite($out, $buff); }
    } else {
       verbose(0, "Failed to open input stream");
    }
    @fclose($in);
    @fclose($out);
    @unlink($_FILES['file']['tmp_name']);
 } else {
    verbose(0, "Failed to open output stream");
 }
 // check if file was uploaded
 if (!$chunks || $chunk == $chunks - 1) {
    rename("{$filePath}.part", $filePath);
 }
 verbose(1, "ok");

?>