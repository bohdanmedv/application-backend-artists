<?php

namespace App\Controller;

use App\Utils\TokenGenerator;
use App\Entity\Token;

class TokenController
{
    const MAX_ATTEMPTS = 100;

    public static function getNewToken( ) {
        $token = new Token();
        for ($attempt = 0; $attempt < self::MAX_ATTEMPTS; $attempt++) {
            $token->setValue(TokenGenerator::generate(Token::TOKEN_LENGTH));
        }
     }
}
