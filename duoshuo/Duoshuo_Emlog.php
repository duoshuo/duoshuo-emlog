<?php
!defined('EMLOG_ROOT') && exit('access deined!');

class Duoshuo_Emlog{
	
	const VERSION = '0.2';
	
	protected static $_instance = null;
	
	public $shortName;
	
	public $secret;
	
	/**
	 *
	 * @return Duoshuo_Emlog
	 */
	public static function getInstance(){
		if (self::$_instance === null)
			self::$_instance = new self();
		return self::$_instance;
	}
	
	protected function __construct(){
		//	for compatiable
		$configFile = EMLOG_ROOT . '/content/plugins/duoshuo/duoshuo_config.php';
		
		if (file_exists($configFile) && $this->getOption('short_name') === null){
			include_once $configFile;
			
			$upgradeMap = array(
					'DUOSHUO_SHORTNAME'	=>	'short_name',
					'DUOSHUO_SECRET'	=>	'secret',
					'DUOSHUO_SHOW_ORIGINAL_COMMENTS'=>	'show_original_comments',
			);
			
			foreach($upgradeMap as $oldConstant => $newKey){
				if (defined($oldConstant))
					$this->updateOption($newKey, constant($oldConstant));
			}
			
			$CACHE = Cache::getInstance();
			$CACHE->updateCache('options');
			
			@unlink($configFile);
		}
		
		$this->shortName = $this->getOption('short_name');
		$this->secret = $this->getOption('secret');
	}
	
	public function remoteAuth($user_data){
		$message = base64_encode(json_encode($user_data));
		$time = time();
		return $message . ' ' . self::hmacsha1($message . ' ' . $time, $this->secret) . ' ' . $time;
	}
	
	// from: http://www.php.net/manual/en/function.sha1.php#39492
	// Calculate HMAC-SHA1 according to RFC2104
	// http://www.ietf.org/rfc/rfc2104.txt
	static function hmacsha1($data, $key) {
		if (function_exists('hash_hmac'))
			return hash_hmac('sha1', $data, $key);
	
		$blocksize=64;
		$hashfunc='sha1';
		if (strlen($key)>$blocksize)
			$key=pack('H*', $hashfunc($key));
		$key=str_pad($key,$blocksize,chr(0x00));
		$ipad=str_repeat(chr(0x36),$blocksize);
		$opad=str_repeat(chr(0x5c),$blocksize);
		$hmac = pack(
				'H*',$hashfunc(
						($key^$opad).pack(
								'H*',$hashfunc(
										($key^$ipad).$data
								)
						)
				)
		);
		return bin2hex($hmac);
	}
	
	public function getOption($name){
		return Option::get('duoshuo_' . $name);
	}
	
	public function updateOption($name, $value){
		$db = MySql::getInstance();
		
		$option_name = addslashes('duoshuo_' . $name);
		$option_value = addslashes($value);
		
		if (Option::get('duoshuo_' . $name) === null){
			$db->query("INSERT INTO " . DB_PREFIX . "options (option_name, option_value) VALUES ('$option_name','$option_value')");
		}
		else{
			$db->query('UPDATE ' . DB_PREFIX . "options SET option_value='$value' where option_name='$option_name'");
		}
	}
	
	public function userData($userId = null){	// null 代表当前登录用户，0代表游客
		//	只支持当前登录用户
		global $userData;
		
		if (!empty($userData)){
			return array(
					'id'	=> $userData['uid'],
					'name'	=> $userData['nickname'] ? $userData['nickname'] : $userData['username'],
					'email' => $userData['email'],
					//'role'	=> $userData['role'],
			);
		}
		else{
			return array();
		}
	}
	
	public function buildQuery(){
		$query = array(
			'short_name' => $this->shortName,
		);
		if (defined('ISLOGIN') && ISLOGIN)
			$query['remote_auth'] = $this->remoteAuth($this->userData());
		
		return $query;
	}
	

	public function packageOptions(){
		$options = array(
			'name'			=>	Option::get('blogname'),
			'description'	=>	Option::get('bloginfo'),
			'url'			=>	Option::get('blogurl'),
			'siteurl'		=>	Option::get('blogurl'),
			'system_version'=>	Option::EMLOG_VERSION,
			'plugin_version'=>	self::VERSION,
		);
		
		return $options;
	}
	
	public function connectSite(){
		$this->updateOption('short_name', $_GET['short_name']);
		$this->updateOption('secret', $_GET['secret']);
		
		$this->shortName = $_GET['short_name'];
		$this->secret = $_GET['secret'];
		
		$CACHE = Cache::getInstance();
		$CACHE->updateCache('options');
		?>
<script>
	window.parent.location.reload();
</script>
		<?php 
	}
}
