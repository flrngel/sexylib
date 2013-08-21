<?
	if( $_GET['pass'] != "FusRoDah!!" ) exit("logged..");
	if( !file_exists("../uploads/".$_GET['name']) ) exit("logged..");

	if( $_GET['type'] == 'image' )
		header("Content-Type: image/jpeg");
	else
		header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment;; filename=$_GET[name]");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".(string)(filesize("../uploads/".$_GET['name']))); 
	header("Cache-Control: cache");
	header("Expires: Mon, 26 Jul 2017 05:00:00 GMT");
	//header("Cache-Control: cache, must-revalidate");
	//header("Pragma: no-cache");
	//header("Expires: 0");

	echo file_get_contents("../uploads/".$_GET['name']);
?>
