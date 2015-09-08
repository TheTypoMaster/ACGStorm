<?php
/**
* @PHP SDK for 56 网  v2.0 (include using OAuth2)
* /

/**
 * 设定时区.
 */
define('API_TIMEZONE_OFFSET',8);
if(function_exists('date_default_timezone_set')) {
	@date_default_timezone_set('Etc/GMT'.(API_TIMEZONE_OFFSET > 0 ? '-' : '+').(abs(API_TIMEZONE_OFFSET)));
} else {
	putenv('Etc/GMT'.(API_TIMEZONE_OFFSET > 0 ? '-' : '+').(abs(API_TIMEZONE_OFFSET)));
}

/**
 * 常用配置.1000000009
 */
error_reporting(E_ALL);
define('APPKEY','3000001134');
define('APPSECRET','b56e4a2f0f6e59d7');
/**
 * @在oauth认证中请求的token
 */
define('ACCESS_TOKEN','');
define('CONNECT_TIMEOUT', 5);
define('READ_TIMEOUT', 5);

/**
 * @description 56网的接口类
 * 
 * @package open56Client
 */
class open56Client extends Exception{

	/**
	* 应用appkey
	*/
	public $appkey; 
	/**
	* 应用secret  
	*/
	public $secret;
	/**
	* 接口访问host
	*/
	public $domain = "http://oapi.56.com";
	/**
	* 用户授权access_token
	*/
	public $access_token;
	/**
	* 是否调试HTTP
	*/
	public $isDebugHttp = false;


	public function __construct($appkey,$secret){
		if(empty($appkey) || empty($secret)){
			try {
				throw new Exception("appkey or secret cannot be empty!");
			} catch(Exception $e) {
				echo $e->getMessage();
			}
		}
		$this->appkey=$appkey;
		$this->secret=$secret;
	}

	/**
	* @description 设置access_token,提供需要oauth授权才能访问的接口设置用户access_token，该值参与客户端签名。
	* 
	* @access public
	* @param mixed $token
	* @return void
	*/
	public function _setToken($token){
		if(!empty($token)){
			$this->access_token=$token;
		}	
		return $this;
	}

	/**
	* @description 获取视频信息
	* 
	* @param $flvid 56视频的flvid
	* @link /video/getVideoInfo.json
	* @return json
	*/
	public function  getVideoInfoApp($flvid){
		$url=$this->domain.'/video/getVideoInfo.json';
		$params=array('vid'=>$flvid);
		return self::getHttp($url,$params);
	}
	
	/**
	* @description GET 方法
	* 
	* @access private
	* @param mixed $url
	* @param array $params
	* @return json
	*/
	public function getHttp($url,$params=array()){
		$url = $url.'?'.self::signRequest($params);
		return self::httpCall($url);
	}

	/**
	* @description  POST 方法
	* 
	* @access private
	* @param mixed $url
	* @param mixed $params
	* @return json
	*/
	public function postHttp($url,$params){
		return self::httpCall($url,self::signRequest($params),'post');
	}

	/**
	* @description  curl method,post方法params字符串的位置不同于get
	* 
	* @access public
	* @param mixed $url
	* @param string $params
	* @param string $method
	* @param mixed $connectTimeout
	* @param mixed $readTimeout
	* @return json
	*/
	public function httpCall($url ,$params = '',$method = 'get', $connectTimeout = CONNECT_TIMEOUT, $readTimeout = READ_TIMEOUT) {

		$result = "";
		if (function_exists('curl_init')) {
			$timeout = $connectTimeout + $readTimeout;
			// Use CURL if installed...
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			if(strtolower($method)==='post'){ 
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
			}
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, '56.com API PHP5 Client 1.1 (curl) ' . phpversion());
			$result = curl_exec($ch);
		} else{
			if(isset($params) and $params){
				$url = $url."?".http_build_query($params);
			}
		// Non-CURL based version...
			$ctx = stream_context_create(
				array(  
					'http' => array(  
						'timeout' => 5 /** 设置一个超时时间，单位为秒  */
					)  
				)  
			);  
			$result = file_get_contents($url, 0, $ctx);
		}
		return $result;
	}

	/**
	* @description 签名方法实现，并构造一个参数串
	* 
	* @access private
	* @param mixed $params
	* @return void
	*/
	public function signRequest($params){
		if($this->access_token){
			$params['access_token']=$this->access_token;
		}
		$keys   = open56Client::urlencodeRfc3986(array_keys($params));
		$values = open56Client::urlencodeRfc3986(array_values($params));
		if($keys and $values){
			$params = array_combine($keys,$values);
		}else{
			try {
				throw new Exception("signRequest need params exits!");
			} catch(Exception $e) {
				echo $e->getMessage();
			}
		}
		/**
		* 先去除系统级参数
		*/
		unset($params['appkey']);
		unset($params['ts']); 
		ksort($params);
		/**
		* 第一轮md5字符串
		* */	
		$req   =  md5(http_build_query($params));
		$ts    =  time();/**当次请求的时间戳**/
		/**第二轮md5字符串,得到最后的签名变量,注意里面的顺序不可以改变否则结果错误!**/
		$params['sign'] = md5($req.'#'.$this->appkey.'#'.$this->secret.'#'.$ts);
		$params['appkey']=$this->appkey;
		$params['ts']=$ts;

		return http_build_query($params);
	}

	/**
	* @description 转码异常字符
	* 
	* @access public
	* @param mixed $input
	* @return void
	*/
	public static function urlencodeRfc3986($input){ 
		if (is_array($input)){
			return array_map( array('open56Client', 'urlencodeRfc3986') , $input );
		}else if( is_scalar($input)){
			return str_replace( '+' , ' ' , str_replace( '%7E' , '~' , rawurlencode($input)));
		}else{
			return '';
		}
	}
}