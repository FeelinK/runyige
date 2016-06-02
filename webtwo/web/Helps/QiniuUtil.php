<?php
require_once(dirname(__FILE__) . '/qiniu/io.php');
require_once(dirname(__FILE__) . '/qiniu/rs.php');
require_once(dirname(__FILE__) . '/qiniu/conf.php');
require_once(dirname(__FILE__) . '/qiniu/fop.php');
require_once(dirname(__FILE__) . '/qiniu/utils.php');
class QiniuUtil{
	private $bucket_name = NULL;
	private $accessKey = NULL;
	private $secretKey = NULL;

    private static $self = NULL;


    public static function instance()
    {
        if (self::$self == NULL) {
            self::$self = new QiniuUtil();
        }

        return self::$self;
    }
	 public function upload_files($name,$file){
	 	//getenv("QINIU_BUCKET_NAME");
		Qiniu_SetKeys($this->accessKey, $this->secretKey);
		$putPolicy = new Qiniu_RS_PutPolicy($this->bucket_name.":".$name);
		$upToken = $putPolicy->Token(null);
		$putExtra = new Qiniu_PutExtra();
		//$putExtra->MimeType = 'image/jpeg';
		//list($ret, $err) = Qiniu_Put($upToken, $name, $file, null);
		list($ret, $err) = Qiniu_PutFile($upToken, $name, $file, $putExtra);
		//echo "====> Qiniu_PutFile result: \n";
		if ($err !== null) {
			return false;
			//return $err;
			//var_dump($err);exit;
		} else {
			return true;
			//return $ret;
			//var_dump($ret);exit;
		} 
	
	}
	
	
	public function upload_audio($name,$file){
		$name1 = str_replace("amr","aac",$name);
		$PersistentOps = "avthumb/mp4/|saveas/".Qiniu_Encode($this->bucket_name.":".$name1);
		$PersistentNotifyUrl = "http://119.254.108.124:10023/manage.php/Common/Notify";
		Qiniu_SetKeys($this->accessKey, $this->secretKey);
		$putPolicy = new Qiniu_RS_PutPolicy($this->bucket_name.":".$name,$PersistentOps,$PersistentNotifyUrl);
		$upToken = $putPolicy->Token(null);
		$putExtra = new Qiniu_PutExtra();
		list($ret, $err) = Qiniu_PutFile($upToken, $name, $file, $putExtra);
		if ($err !== null) {
			return false;
		} else {
			return true;
		}
	}
	
	public function get_token(){
		Qiniu_SetKeys($this->accessKey, $this->secretKey);
		$putPolicy = new Qiniu_RS_PutPolicy($this->bucket_name);
		return $putPolicy->Token(null);
	}
	
	public function set_conf($access,$secret,$name){
		$this->bucket_name = $name;
		$this->accessKey = $access;
		$this->secretKey = $secret;
		return $this;
	}

	public function setConfig($access,$secret,$name)
	{
		return self::set_conf($access,$secret,$name);
	}

//	public static function getToken()
//	{
//		return self::get_token();
//	}

    public function getToken()
    {
        return self::get_token();
    }

}









