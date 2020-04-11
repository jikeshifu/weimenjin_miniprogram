<?php 

namespace app\api\controller;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;

class Jwt{
	
	
	private static $instance = null;
	
	private $token;
	private $decodeToken;
	private $iss;  //发送数据端
	private $aud;	  //数据接收
	private $uid; //用户UID
	private $secrect;
	private $expTime;
	
	
	public static function getInstance(){
		if(is_null(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	private function __construct(){
		
	}
	
	public function getToken(){
		return (string)$this->token;
	}
	
	public function setToken($token){
		$this->token = $token;
		return $this;
	}
	
	public function setUid($uid){
		$this->uid = $uid;
		return $this;
	}	
	
	public function getUid(){
		return $this->uid;
	}
	
	public function setExpTime($expTime){
		$this->expTime = $expTime;
		return $this;		
	}	
	
	public function setIss($iss){
		$this->iss = $iss;
		return $this;
	}
	
	public function setAud($aud){
		$this->aud = $aud;
		return $this;
	}
	
	public function setSecrect($secrect){
		$this->secrect = $secrect;
		return $this;
	}
	
	public function encode(){
		$time = time();
		$this->token = (new Builder())->setHeader('alg','HS256')
			->setIssuer($this->iss)
			->setAudience($this->aud)
			->setIssuedAt($time)
			->setExpiration($time+$this->expTime)
			->set('uid',$this->uid)
			->sign(new Sha256(),$this->secrect)
			->getToken();
		
		return $this;
	}
	
	
	public function decode(){
		
		try{
			$this->decodeToken = (new Parser())->parse((string) $this->token); // Parses from a string
			$this->uid = $this->decodeToken->getClaim('uid');
			return $this->decodeToken;
		}catch (RuntimeException $e){
			throw new \Exception($e->getMessage());
		}
		
	}
		
	public function validate(){
		$data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
		$data->setIssuer($this->iss);
		$data->setAudience($this->aud);
		$data->setId($this->uid);
		
		return $this->decode()->validate($data);
	}
	
	
	public function verify(){
		return $this->decode()->verify(new Sha256(),$this->secrect);
	}

}

