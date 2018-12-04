<?php

namespace App\Controller;

use App\Entity\Token;
use App\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;

class ArtistController extends AbstractController
{
    public function show(Request $request)
    {
        $artistRepository = $this->getDoctrine()->getRepository(Artist::class);

        $tokenValue = strip_tags($request->get('token'));

        $artists = [];

        if ($tokenValue) {
            $tokenRepository = $this->getDoctrine()->getRepository(Token::class);
            $token = $tokenRepository->findOneBy(['value' => $tokenValue]);

            if ($token && $artist = $token->getArtist()) {
                $artists = [$artist];
            }
        } else {
            $artists = $artistRepository->findAll();
        }

        $response = [];
        foreach ($artists as $artist) {
            $response[$artist->getId()] = [
                'name' => $artist->getName(),
                'token' => $artist->getToken()->getValue(),
                'albums' => []
            ];

            foreach ($artist->getAlbums() as $album) {
                $response[$artist->getId()]['albums'][$album->getId()] = [
                    'token' => $album->getToken()->getValue(),
                    'title' => $album->getTitle(),
                    'cover' => $album->getCover()
                ];
            }
        }

        return $this->json($response);
    }
}
