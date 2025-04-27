<?php
namespace app\api\controller;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\ValidAt;
use Lcobucci\Clock\SystemClock;

class Jwt
{
    private static $instance = null;

    private $token;
    private $decodeToken;
    private $iss;  // 发送数据端
    private $aud;  // 数据接收
    private $uid;  // 用户UID
    private $secret;
    private $expTime;
    private $config;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        // 默认初始化配置，未设置密钥前使用默认密钥
        $this->config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($this->secret ?? 'default_secret')
        );
    }

    public function getToken()
    {
        // 使用 toString() 获取 token 字符串
        return $this->token->toString();
    }

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
        return $this;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setExpTime($expTime)
    {
        $this->expTime = $expTime;
        return $this;
    }

    public function setIss($iss)
    {
        $this->iss = $iss;
        return $this;
    }

    public function setAud($aud)
    {
        $this->aud = $aud;
        return $this;
    }

    public function setSecret($secret)
    {
        if (empty($secret)) {
            throw new \InvalidArgumentException('Secret key cannot be null or empty.');
        }

        $this->secret = $secret;

        // 配置 SymmetricSigner，确保 secret 非空
        $this->config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($this->secret)
        );

        return $this;
    }

    public function encode()
    {
        if (empty($this->secret)) {
            throw new \Exception('Secret key is not set');
        }

        $now = new \DateTimeImmutable();  // 当前时间

        // 调试输出 expTime
        if (!is_int($this->expTime) || $this->expTime <= 0) {
            throw new \Exception('Invalid expiration time: ' . var_export($this->expTime, true));
        }

        $expiration = $now->modify("+{$this->expTime} seconds");  // 计算过期时间，确保 expTime 是有效的时间长度

        $this->token = $this->config->builder()
            ->issuedBy($this->iss)   // 发行者
            ->permittedFor($this->aud)  // 接收者
            ->issuedAt($now)  // 发布时间
            ->expiresAt($expiration)  // 设置过期时间
            ->withClaim('uid', $this->uid)  // 自定义数据
            ->getToken($this->config->signer(), $this->config->signingKey());  // 获取生成的token

        return $this;
    }




    public function decode()
    {
        try {
            // 直接传递 token 对象给 parser
            $this->decodeToken = $this->config->parser()->parse($this->token);
            $this->uid = $this->decodeToken->claims()->get('uid');
            return $this->decodeToken;
        } catch (\RuntimeException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function validate()
    {
        $now = new \DateTimeImmutable();

        // 使用时间约束验证 Token 是否有效
        $constraints = [
            new ValidAt(SystemClock::fromUTC()),
        ];

        return $this->config->validator()->validate($this->decodeToken, ...$constraints);
    }

    public function verify()
    {
        // 检查签名
        return $this->config->validator()->validate($this->decodeToken, ...[
            new \Lcobucci\JWT\Validation\Constraint\SignedWith(
                $this->config->signer(),
                $this->config->signingKey()
            )
        ]);
    }
}
