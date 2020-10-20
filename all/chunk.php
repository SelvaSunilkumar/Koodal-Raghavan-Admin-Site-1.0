<!DOCTYPE html>
<html>
<head>
	<title>Chunk Upload</title>
</head>
<body>
	<form method="POST" enctype="multipart/form-data">
		<input type="file" name="file" required>
		<input type="submit" name="submit" value="submit">
	</form>
</body>
</html>
<?php 
	if (isset($_POST['submit'])) {
		$filepath = "../../unrestricted/check/uploads";
		if (!file_exists($filepath)) {
			mkdir($filepath,0755);
		}

		$tmp_file = $_FILES['file']['tmp_name'];
		$orig_file_size = filesize($tmp_file);
		$target_file = $filepath.'/'.$_FILES['file']['name'];

		$chunk_size = 256;
		$upload_start = 0;

		$handle = fopen($tmp_file,"rb");

		$fp = fopen($target_file,'w');

		while ($upload_start < $orig_file_size) {
			$contents = fread($handle,$chunk_size);
			fwrite($fp,$contents);

			$upload_start += strlen($contents);
			fseek($handle,$upload_start);
			echo ". ";
		}

		fclose($handle);
		fclose($fp);
		unlink($_FILES['file']['tmp_name']);

		echo "File Uploaded sucessfully..";
	}
?>