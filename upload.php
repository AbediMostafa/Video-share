
<?php 
require 'logIN.php';
define('MOVPATH', __DIR__. "\\MOVIES\\" );
define('PICPATH', __DIR__. "\\PICTURES\\" );
function returnExt($value)
{
	$temp  = substr($value, -4);
	$arr = explode('.', $temp);
return $arr[1];	
}

function takePicture($videoname,$extension)
{
	$withoutExtension=str_replace(".$extension", "", $videoname);
    echo $video  = MOVPATH.$videoname;
	echo $pic    = PICPATH.$withoutExtension.".jpg";
	echo shell_exec("ffmpeg -itsoffset 5 -i  $video $pic &");
}

function generateNewName($oldName)
{
	$mName = rand(1,10)*rand(1,2009)*rand(1,15)*rand(1,5);
	$mName .= implode($oldName);
	return $mName;	
}

$ext = array('mpg', 'wma', 'mov', 'flv', 'mp4', 'avi', 'qt', 'wmv', 'rm');

	/*
	//$con = new mysqli($db_hostname,$db_username,'',$db_database) or mysqli_error();
	//$create_table_query = "create table videos ( videoname    varchar(128))";
	$res = $con->query($create_table_query);
	if (!$res)  $con->errno;
	$insert_query = "insert into videos values"."('$mName','$mExt','$description')";
	$res1 = $con->query($insert_query);
   if (!$res1) die ($con->error);	
	}
	*/
$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
 
if ($fn) {

	// AJAX call
	file_put_contents('uploads/' . $fn,	file_get_contents('php://input'));
	echo "$fn uploaded";
	exit();

}
else {

	// form submit
	$files = $_FILES['fileselect'];

	foreach ($files['error'] as $id => $err) {
		if ($err == UPLOAD_ERR_OK) {
			$mName = generateNewName($files['name'][$id]);
			$mExt = returnExt($mName);
			echo (in_array($mExt, $ext)) ?
			"pasvand $mExt sahih ast" : "pasvand $mExt ghalat ast";
			if (!is_dir('MOVIES'))mkdir('MOVIES');
			if (!is_dir('PICTURES'))mkdir('PICTURES');
			$path = MOVPATH. $mName;
				
			move_uploaded_file($files['tmp_name'][$id],$path);
			echo "<p>File $fn uploaded.</p>";
		}
	}

}
	
?>

