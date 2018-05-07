<?php
//Upload CLASS
class Upload {	
	public static function upload_imagen() {
		$target_dir = "files/";
		$target_file = $target_dir . basename($_FILES["archivo"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$image_info = getimagesize($_FILES["archivo"]["tmp_name"]);		
		// Check if file already exists
		if (file_exists($target_file)) {
			return array("error" => "The file already exists.");
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["archivo"]["size"] > 50000000) {
			return array("error" => "The file is too big.");
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" && $imageFileType != "pdf" ) {
			return array("error" => "Only JPG, JPEG, PNG, GIF or PDF files allowed.");
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			return array("error" => "There was an error uploading the file.");
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)) {
				return array("error" => '<div class="form-group"><label for="exampleInputPassword1"><b>Uploaded to</b></label><input type="text" class="form-control" value="files/'. basename( $_FILES["archivo"]["name"]).'"></div>');
			} else {
				return array("error" => "There was an error uploading the file.");
			}
		}		
	}
}
?>