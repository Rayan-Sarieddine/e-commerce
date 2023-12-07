<?php
// jwt_functions.php

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;

function authenticateJWT()
{
    $headers = getallheaders();
    if (!isset($headers['Authorization']) || empty($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["error" => "unauthorized"]);
        exit();
    }

    $authorizationHeader = $headers['Authorization'];
    $token = null;

    $token = trim(str_replace("Bearer", '', $authorizationHeader));
    if (!$token) {
        http_response_code(401);
        echo json_encode(["error" => "unauthorized"]);
        exit();
    }

    try {
        $key = "rayan1234";
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        return $decoded;
    } catch (ExpiredException $e) {
        http_response_code(401);
        echo json_encode(["error" => "expired"]);
        exit();
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["error" => "Invalid token"]);
        exit();
    }
}
?>