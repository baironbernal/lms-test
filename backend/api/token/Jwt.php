<?php
define('SECRET_KEY', '89');

class Jwt
{
    public static function encode($user_id)
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode(['user_id' => $user_id, 'iat' => time(), 'exp' => time() + 3600]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", SECRET_KEY, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";
    }

    public static function decode($jwt)
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return null;
        }

        list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = $parts;
        $header = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlHeader)), true);
        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlPayload)), true);

        if (time() > $payload['exp']) {
            return null; // Token expired
        }

        $signature = base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlSignature));
        $validSignature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", SECRET_KEY, true);

        if ($signature !== $validSignature) {
            return null;
        }

        return $payload;
    }
}
