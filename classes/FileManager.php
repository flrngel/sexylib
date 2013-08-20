<?
class FileManager{
	var $db;
	function __construct(){
		$this->db=new DBMysql;
	}

	function upload($tmp_name){
		$filename=sha1(uniqid());
		if( move_uploaded_file($tmp_name,$_SERVER['DOCUMENT_ROOT']."/../uploads/".$filename) ){
		}
		return $filename;
	}

	function multi_upload($files){
		$res=Array();
		if( is_array( $files ) ){
			foreach( $files['tmp_name'] as $tmp_name ){
				$res[]=$this->upload($tmp_name);
			}
		} else {
			$res[0] = $this->upload($files['tmp_name'][0]);
		}
		return $res;
	}
}
?>
