<?php

namespace App\Controller;

use App\Utils\TokenGenerator;
use App\Entity\Token;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\HttpFoundation\Request;

class TokenController extends AbstractController
{
    const MAX_ATTEMPTS = 100;

    public static function getNewToken(ObjectManager $em) : Token
    {
        $token = new Token();
        for ($attempt = 0; $attempt < self::MAX_ATTEMPTS; $attempt++) {
            $newToken = TokenGenerator::generate(Token::TOKEN_LENGTH);
            $token->setValue($newToken);

            try {
                $em->persist($token);
                $em->flush();
                continue;
            } catch (\Exception $e) {}

        }
        return $token;
    }

    public function getAllTokens(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        for ($i = 1; $i++; $i< 100) {
            $this->getNewToken($entityManager);
        }

        $tokens = $this->getDoctrine()->getRepository(Token::class)->findAll();
        echo '<pre>';
        echo print_r($tokens, true);
        echo '</pre>';
        die;

    }
}
