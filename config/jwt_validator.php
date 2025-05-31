<?php
class JWTValidator {
    private static $auth_api_url = "https://donation-api-auth.vercel.app/auth/verify-token";

    public static function validateAdminToken($token) {
        $token = str_replace('Bearer ', '', $token);
        $headers = ['Authorization: Bearer ' . $token];
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => implode("\r\n", $headers),
                'timeout' => 15
            ]
        ];

        $response = @file_get_contents(self::$auth_api_url, false, stream_context_create($options));
        if ($response === FALSE) {
            throw new Exception("API Auth tidak responsif");
        }

        $data = json_decode($response, true);
        // var_dump($data); die();
        if (
            empty($data['success']) ||
            !isset($data['data']) ||
            !in_array($data['data']['role'], ['admin', 'volunteer'])
        ) {
            throw new Exception("Akses ditolak: Hanya admin atau volunteer yang diizinkan");
        }
    }
}
?>
