<?php
namespace App\Controllers;




use App\Interfaces\SecretKeyInterface;
use Firebase\JWT\JWT;

class GenerateTokenController implements SecretKeyInterface
{
    public static function generateToken($email)
    {
        $now = time();
        $future = strtotime('+1 hour',$now);
        $secretKey = self::JWT_SECRET_KEY;
        $payload = [
         "jti"=>$email,
         "iat"=>$now,
         "exp"=>$future
        ];

        return JWT::encode($payload,$secretKey,"HS256");
    }
}