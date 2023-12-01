<?php
namespace App\Helpers;

class MyHelper {
    public static function mascararEmail($email) {
        $partes = explode('@', $email);
        if (count($partes) === 2) {
            $username = $partes[0]; 
            $domain = $partes[1];
            $maskedUsername = substr($username, 0, 1) . str_repeat('*', strlen($username) - 2) . substr($username, -1);
            $maskedEmail = $maskedUsername . '@' . $domain;

            return $maskedEmail;
        }
    
        return $email; 
    }
}