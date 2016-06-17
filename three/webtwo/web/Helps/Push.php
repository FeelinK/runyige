<?php
/**
*  Create On 2014-11-26
*  Author yiwei
*  QQ:1006629314
**/


require_once(dirname(__FILE__) . '/Push/IGt.Push.php');

class Push
{
	protected $Host;
	protected $AppID;
	protected $AppKey;
	protected $MasterSecret;
	
	//protected $ClientID;
	//protected $DeviceToken;
	private static $self = NULL;
	
	static public function instance()
	{
		if (self::$self == NULL) {
			self::$self = new self();
		}
	
		return self::$self;
	}
	
 	/**
     * 设置属性
     * @param $pushConf
     */
    public function setAttribute($pushConf)
    {
        $this->Host = $pushConf['Host'];
        $this->AppID = $pushConf['AppID'];
        $this->AppKey = $pushConf['AppKey'];
        $this->MasterSecret = $pushConf['MasterSecret'];
    }
	
	public function pushToSingle($aim,$content)
	{
		$rep = "";
		$igt = new IGeTui($this->Host,$this->AppKey,$this->MasterSecret);
		if($aim['type'] == 1)//android
		{
			//个推信息内容
			$template =  new IGtNotificationTemplate();
			$template->set_appId($this->AppID);//应用appid
			$template->set_appkey($this->AppKey);//应用appkey
			$template->set_transmissionType(1);//透传消息类型0消息1透传
			$template->set_transmissionContent($content['info']);//透传内容
			$template->set_title($content['title']);//通知栏标题
			$template->set_text($content['text']);//通知栏内容
			//$template->set_logo($content['logo_url']);//通知栏logo
			$template->set_isRing(true);//是否响铃
			$template->set_isVibrate(true);//是否震动
			$template->set_isClearable(true);//通知栏是否可清除 
			
			//个推信息体
			$message = new IGtSingleMessage();
			
			$message->set_isOffline(true);//是否离线
			$message->set_offlineExpireTime(3600*12*1000);//离线时间
			$message->set_data($template);//设置推送消息类型
			//接收方
			$target = new IGtTarget();
			$target->set_appId($this->AppID);
			$target->set_clientId($aim['ClientID']);
			//$target->set_alias(ALIAS);
			$rep = $igt->pushMessageToSingle($message,$target);
			//var_dump($rep);
		}else if($aim['type'] == 2)//ios
		{
			$result = $igt->getClientIdStatus($this->AppID,$aim['ClientID']);
			if($result['result']=='Online')//ios在线使用个推透传
			{
				$template =  new IGtTransmissionTemplate();
				$template->set_appId($this->AppID);//应用appid
				$template->set_appkey($this->AppKey);//应用appkey
				$template->set_transmissionType(0);//透传消息类型
				$template->set_transmissionContent($content['info']);//透传内容
				//iOS推送需要设置的pushInfo字段
				//$template ->set_pushInfo($actionLocKey,$badge,$message,$sound,$payload,$locKey,$locArgs,$launchImage);
				$template ->set_pushInfo("", +1,$content['text'], "default1.wav",$content['info'], "", "", "");
				$message = new IGtSingleMessage();
				
				$message->set_isOffline(true);//是否离线
				$message->set_offlineExpireTime(3600*12*1000);//离线时间
				$message->set_data($template);//设置推送消息类型
				//$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
				//接收方
				$target = new IGtTarget();
				$target->set_appId($this->AppID);
				$target->set_clientId($aim['ClientID']);
				
				$rep = $igt->pushMessageToSingle($message,$target);
				
				//var_dump($rep);
			}
			/* else if($result['result']=='Offline')//ios离线线使用APNs方式
			{
				$template = new IGtAPNTemplate();
				//$template ->set_pushInfo($actionLocKey,$badge,$message,$sound,$payload,$locKey,$locArgs,$launchImage);
				$template->set_pushInfo("",+1, $content['text'], "default1.wav", $content['info'], "", "", "image1.jpg",1);
				$message = new IGtSingleMessage();
				
				$message->set_data($template);
				$rep = $igt->pushAPNMessageToSingle($this->AppID, $aim['DeviceToken'], $message);
				//var_dump($rep);
			} */
		}
		return $rep;
	}
	
	public function pushToSingleforIos($aim,$content)
	{
		$rep = "";
		$igt = new IGeTui($this->Host,$this->AppKey,$this->MasterSecret);
		if($aim['type'] == 1)//android
		{
			//个推信息内容
			$template =  new IGtNotificationTemplate();
			$template->set_appId($this->AppID);//应用appid
			$template->set_appkey($this->AppKey);//应用appkey
			$template->set_transmissionType(1);//透传消息类型0消息1透传
			$template->set_transmissionContent($content['info']);//透传内容
			$template->set_title($content['title']);//通知栏标题
			$template->set_text($content['text']);//通知栏内容
			//$template->set_logo($content['logo_url']);//通知栏logo
			$template->set_isRing(true);//是否响铃
			$template->set_isVibrate(true);//是否震动
			$template->set_isClearable(true);//通知栏是否可清除
				
			//个推信息体
			$message = new IGtSingleMessage();
				
			$message->set_isOffline(true);//是否离线
			$message->set_offlineExpireTime(3600*12*1000);//离线时间
			$message->set_data($template);//设置推送消息类型
			//$message->set_PushNetWorkType(1);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
			//接收方
			$target = new IGtTarget();
			$target->set_appId($this->AppID);
			$target->set_clientId($aim['ClientID']);
			//$target->set_alias(ALIAS);
			$rep = $igt->pushMessageToSingle($message,$target);
			//var_dump($rep);
		}else if($aim['type'] == 2)//ios
		{
			$result = $igt->getClientIdStatus($this->AppID,$aim['ClientID']);
			if($result['result']=='Online')//ios在线使用个推透传
			{
				$template =  new IGtTransmissionTemplate();
				$template->set_appId($this->AppID);//应用appid
				$template->set_appkey($this->AppKey);//应用appkey
				$template->set_transmissionType(0);//透传消息类型
				$template->set_transmissionContent($content['info']);//透传内容
				//iOS推送需要设置的pushInfo字段
				//$template ->set_pushInfo($actionLocKey,$badge,$message,$sound,$payload,$locKey,$locArgs,$launchImage);
				$template ->set_pushInfo("", +1,$content['text'], "default1.wav",$content['info'], "", "", "");
				$message = new IGtSingleMessage();
	
				$message->set_isOffline(true);//是否离线
				$message->set_offlineExpireTime(3600*12*1000);//离线时间
				$message->set_data($template);//设置推送消息类型
				//$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
				//接收方
				$target = new IGtTarget();
				$target->set_appId($this->AppID);
				$target->set_clientId($aim['ClientID']);
	
				$rep = $igt->pushMessageToSingle($message,$target);
	
				//var_dump($rep);
			}
			/* else if($result['result']=='Offline')//ios离线线使用APNs方式
			{
				$template = new IGtAPNTemplate();
				//$template ->set_pushInfo($actionLocKey,$badge,$message,$sound,$payload,$locKey,$locArgs,$launchImage);
				$template->set_pushInfo("",+1, $content['text'], "default1.wav", $content['info'], "", "", "image1.jpg",1);
				$message = new IGtSingleMessage();
	
				$message->set_data($template);
				$rep = $igt->pushAPNMessageToSingle($this->AppID, $aim['DeviceToken'], $message);
				//var_dump($rep);
			} */
		}
		return $rep;
	}
	
	
	public function pushToList($clientArray,$content,$type)
	{
		$igt = new IGeTui($this->Host,$this->AppKey,$this->MasterSecret);
		if($type == 1){//andorid端
		 	/*
		 	 $template =  new IGtTransmissionTemplate();
		 	$template->set_appId($this->AppID);//应用appid
		 	$template->set_appkey($this->AppKey);//应用appkey
		 	$template->set_transmissionType(0);//透传消息类型
		 	$template->set_transmissionContent($content['info']);//透传内容
		 	//iOS推送需要设置的pushInfo字段
		 	//$template ->set_pushInfo($actionLocKey,$badge,$message,$sound,$payload,$locKey,$locArgs,$launchImage);
		 	//$template ->set_pushInfo("", +1, "howdo tester", "", "", "", "", "");
		 	$message = new IGtSingleMessage();
		 		
		 	$message->set_isOffline(true);//是否离线
		 	$message->set_offlineExpireTime(3600*12*1000);//离线时间
		 	$message->set_data($template);//设置推送消息类型
		 	$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
		 	//接收方
		 	$target = new IGtTarget();
		 	$target->set_appId($this->AppID);
		 	$target->set_clientId($aim['ClientID']);
		 		
		 	$rep = $igt->pushMessageToSingle($message,$target);
		 	var_dump($rep);
		 	*/
		 	//个推信息内容
		 	$template =  new IGtNotificationTemplate();
		 	$template->set_appId($this->AppID);//应用appid
		 	$template->set_appkey($this->AppKey);//应用appkey
		 	$template->set_transmissionType(0);//透传消息类型
		 	$template->set_transmissionContent($content['info']);//透传内容
		 	$template->set_title($content['title']);//通知栏标题
		 	$template->set_text($content['text']);//通知栏内容
		 	$template->set_logo("http://wwww.igetui.com/logo.png");//通知栏logo
		 	$template->set_isRing(true);//是否响铃
		 	$template->set_isVibrate(true);//是否震动
		 	$template->set_isClearable(true);//通知栏是否可清除
		 		
		 	//个推信息体
		 	$message = new IGtSingleMessage();
		 		
		 	$message->set_isOffline(true);//是否离线
		 	$message->set_offlineExpireTime(3600*12*1000);//离线时间
		 	$message->set_data($template);//设置推送消息类型
		 	//$message->set_PushNetWorkType(1);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
		 	
		 	//接收方
		 	$num = count($clientArray);
		 	$targetList = array($num);
		 	for($i=0;$i<$num;$i++){
		 		$targetList[$i] = new IGtTarget();
		 		$targetList[$i]->set_appId($this->AppID);
		 		$targetList[$i]->set_clientId($clientArray[$i]['ClientId']);
		 	}
		 	$contentId = $igt->getContentId($message);
		 	$rep = $igt->pushMessageToList($contentId, $targetList);
		 		
		 	//var_dump($rep);
		 }
	}
	
	public function pushToAll($content,$type){
		if($type == 1){
			
		}elseif ($type ==2){
			
		}
	}
	//透传
	function IGtTransmission($content,$clientid){
		$igt = new IGeTui($this->Host,$this->AppKey,$this->MasterSecret);
		$template =  new IGtTransmissionTemplate();
		$template->set_appId($this->AppID);//应用appid
		$template->set_appkey($this->AppKey);//应用appkey
		$template->set_transmissionType(0);//透传消息类型
		$template->set_transmissionContent($content);//透传内容
		//iOS推送需要设置的pushInfo字段
		//$template ->set_pushInfo($actionLocKey,$badge,$message,$sound,$payload,$locKey,$locArgs,$launchImage);
		//$template ->set_pushInfo("", +1, "howdo tester", "", "", "", "", "");
		$message = new IGtSingleMessage();
			
		$message->set_isOffline(true);//是否离线
		$message->set_offlineExpireTime(3600*12*1000);//离线时间
		$message->set_data($template);//设置推送消息类型
		//$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
		//接收方
		$target = new IGtTarget();
		$target->set_appId($this->AppID);
		$target->set_clientId($clientid);
			
		$rep = $igt->pushMessageToSingle($message,$target);
		//var_dump($rep);
		return $rep;
	 }
}