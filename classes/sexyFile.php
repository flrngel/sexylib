<?
class sexyFile extends sexyModel{
        var $db;
        var $dir;
        var $files;
        var $abspath=""; // path here
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

        function upload($files){
                print_r($files);
                if( is_array($files['tmp_name']) ){
                        $var=array();
                        foreach( $files['tmp_name'] as $key => $val ){
                                $var[]=(object)array("tmp_name"=>$files['tmp_name'][$key],"realname"=>$files['name'][$key]);
                        }
                }else{
                        $var=(object)array("tmp_name"=>$files['tmp_name'],"realname"=>$files['name']);
                }

                if( is_array($var) ){
                        foreach( $var as $val ){
                                $res=$this->_upload($val->tmp_name,$val->realname);
                                if( $res ){
                                        $this->files[]=$res;
                                }
                        }
                }else{
                        $res=$this->_upload($var->tmp_name,$var->realname);
                        if( $res ){
                                $this->files[]=$res;
                        }
                }
                return $this->toString();
        }
}
?>
