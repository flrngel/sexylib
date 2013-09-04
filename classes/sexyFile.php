<?
class sexyFile extends sexyModel{
	var $db;
	var $dir;
	var $files;
	var $abspath="/dotname/htdata/dotname/";
	var $table="files";
	var $table_perm=array("filename","realname");

	function __construct($subpath){
		$this->db=new DB\Mysql;
		$this->files=array();
		$this->dir=$subpath."/";
	}

	private function toString(){
		return implode("|",$this->files);
	}

	function toArray($str){
		return explode("|",$str);
	}

	function _upload($tmp_name,$realname){
		if( !file_exists( $tmp_name ) ) return false;
		$filename=sha1(uniqid());
		$target=$this->dir.$filename;
		$filepath=$this->abspath.$target;
		echo $filepath;
		if( move_uploaded_file($tmp_name,$filepath) ){
		}
		print_r(array("filename"=>$target,"realname"=>$realname));
		$this->_insert($this->table_perm,array("filename"=>$target,"realname"=>$realname));
		return $target;
	}

	function upload($var){
		if( is_array($var) ){
			foreach( $var as $key=>$val ){
				$res=$this->_upload($val);
				if( $res ){
					$this->files[]=$res;
				}
			}
		}else{
			$res=$this->_upload($var);
			if( $res ){
				$this->files[]=$res;
			}
		}
		return $this->toString();
	}
}
?>
