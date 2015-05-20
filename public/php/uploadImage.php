<?php


if (isset($_FILES['files'])) {
	
	$arr = array('error'=>0,
		'errorMsg'=>"",
		'imgName'=>$_FILES['files']['name'],
		'newName'=>""
		);

	if ($_FILES["files"]["error"] > 0)
	  {
	  	$arr['error'] = 1;
	  	$arr['errorMsg'] = $_FILES["files"]["error"];
	  }
	else
	  {
	  	$newName = '';
		$arr['error'] = 0;
		if(!isset($_GET['currentImage']) || strlen($_GET['currentImage']) < 1){
			$path = $_FILES['files']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$newName = 'pic'.date('m-d-Y_hisa').".".$ext;
		}else{
			$newName = $_GET['currentImage'];
		}
		$arr['newName'] = $newName;

		$target = 'sociosImg/'.$newName;

		$fn = $_FILES['files']['tmp_name'];
		$size = getimagesize($fn);
		$ratio = $size[0]/$size[1]; 
		if( $ratio > 1) {
		    $width = 500;
		    $height = 500/$ratio;
		}
		else {
		    $width = 500*$ratio;
		    $height = 500;
		}
		$src = imagecreatefromstring(file_get_contents($fn));
		$dst = imagecreatetruecolor($width,$height);
				
		imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
		imagedestroy($src);
		imagejpeg($dst,$target);
		imagedestroy($dst);

	  }

	echo json_encode($arr);

	}
	
?>