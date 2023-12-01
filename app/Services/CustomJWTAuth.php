<?php

namespace App\Services;

use Tymon\JWTAuth\Facades\JWTAuth as BaseJWTAuth;

class CustomJWTAuth extends BaseJWTAuth
{
    public function attemptUsingStoredProcedure(array $credentials)
    {

        $result = DB::select('CALL login_user(?, ?, @success, @usuario_id)', [$credentials['user'], $credentials['password']]);
        $authResult = DB::select('SELECT @success AS success, @usuario_id AS user_id');
        
        if ($authResult && $authResult[0]->success) {
            return $this->fromUser($authResult[0]->user_id);
        }
        
        return false;
    }
}
