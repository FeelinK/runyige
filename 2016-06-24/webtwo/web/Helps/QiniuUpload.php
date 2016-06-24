<?php
require_once(dirname(__FILE__) . '/qiniu/autoload.php');

// 引入鉴权类
use Qiniu\Auth;

// 引入上传类
use Qiniu\Storage\UploadManager;

class QiniuUpload{

    private $bucket_name = NULL;
    private $accessKey = NULL;
    private $secretKey = NULL;

    private static $self = NULL;

    public static function instance()
    {
        if (self::$self == NULL) {
            self::$self = new QiniuUpload();
        }

        return self::$self;
    }

    public function setKey()
    {
        $config = Config::get("qiniu");

        $this->bucket_name = $config['bucket_name'];
        $this->accessKey   = $config['accessKey'];
        $this->secretKey   = $config['secretKey'];

    }

    public function generateToken()
    {
        #七牛配置
        $config = Config::get("qiniu");
        $this->bucket_name = $config['bucket_name'];
        $this->accessKey   = $config['accessKey'];
        $this->secretKey   = $config['secretKey'];

        # 构建鉴权对象
        $auth = new Auth($this->accessKey, $this->secretKey);

        #生成上传 Token
        return $auth->uploadToken($this->bucket_name);

    }

    public function upload_files($video_url){
        $this->setKey();
        # 构建鉴权对象
        $auth = new Auth($this->accessKey, $this->secretKey);

        #生成上传 Token
        $upToken = $auth->uploadToken($this->bucket_name);
        //dd($upToken);
        $file = $video_url;
        $clientName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $name = md5(date('ymdhis') . $clientName) . "." . $extension;
        $realPath = $file -> getRealPath();
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($upToken, $name, $realPath);
        if($err)
            throw new Exception('上传失败！', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB);

        return HostEnum::QINIU_HOST.$ret['key'];
//        $res = $uploadMgr->putFile($upToken, $name, $realPath);

        //

//
//
//
//        //return "media.mutouw.com".$name;
////        echo "\n====> putFile result: \n";
//        if ($err !== null) {
//            //var_dump($err);
//            return false;
//        } else {
//            //var_dump($ret);
//            return "http://media.mutouw.com/".$name.$extension;
//        }


//        $putExtra = new Qiniu_PutExtra();
//        list($ret, $err) = Qiniu_PutFile($upToken, $name, $file, $putExtra);
//        if ($err !== null) {
//            return false;
//            //return $err;
//            //var_dump($err);exit;
//        } else {
//            return true;
//            //return $ret;
//            //var_dump($ret);exit;
//        }

    }

    /**
     * desription 压缩图片
     * @param sting $imgsrc 图片路径
     * @param string $imgdst 压缩后保存路径
     */
    function image_png_size_add($imgsrc,$imgdst){
        list($width,$height,$type)=getimagesize($imgsrc);
        $new_width = ($width>600?600:$width)*0.9;
        $new_height =($height>600?600:$height)*0.9;
        switch($type){
            case 1:
                $giftype=check_gifcartoon($imgsrc);
                if($giftype){
                    header('Content-Type:image/gif');
                    $image_wp=imagecreatetruecolor($new_width, $new_height);
                    $image = imagecreatefromgif($imgsrc);
                    imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    imagejpeg($image_wp, $imgdst,75);
                    imagedestroy($image_wp);
                }
                break;
            case 2:
                header('Content-Type:image/jpg');
                $image_wp=imagecreatetruecolor($new_width, $new_height);
                $image = imagecreatefromjpeg($imgsrc);
                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($image_wp, $imgdst,75);
                imagedestroy($image_wp);
                break;
            case 3:
                header('Content-Type:image/png');
                $image_wp=imagecreatetruecolor($new_width, $new_height);
                $image = imagecreatefrompng($imgsrc);
                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($image_wp, $imgdst,75);
                imagedestroy($image_wp);
                break;
        }
    }
    /**
     * desription 判断是否gif动画
     * @param sting $image_file图片路径
     * @return boolean t 是 f 否
     */
    function check_gifcartoon($image_file){
        $fp = fopen($image_file,'rb');
        $image_head = fread($fp,1024);
        fclose($fp);
        return preg_match("/".chr(0x21).chr(0xff).chr(0x0b).'NETSCAPE2.0'."/",$image_head)?false:true;
    }
}

