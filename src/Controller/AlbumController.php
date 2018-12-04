<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Token;
use App\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;

class AlbumController extends AbstractController
{
    public function show(Request $request)
    {
        $albumRepository = $this->getDoctrine()->getRepository(Album::class);

        $tokenValue = strip_tags($request->get('token'));

        $album = [];
        if ($tokenValue) {
            $tokenRepository = $this->getDoctrine()->getRepository(Token::class);
            $token = $tokenRepository->findOneBy(['value' => $tokenValue]);

            if ($token) {
                $album = $token->getAlbum();
            }
        }

        $response = [];
        if ($album) {
            $response = [
                'token' => $tokenValue,
                'title' => $album->getTitle(),
                'description' => $album->getDescription(),
                'cover' => $album->getCover(),
                'artist' => [
                    'token' => $album->getArtist()->getToken()->getValue(),
                    'name' => $album->getArtist()->getName(),
                ]
            ];

            foreach ($album->getSongs() as $song) {
                $response['songs'][$song->getId()] = [
                    'title' => $song->getTitle(),
                    'length' => $song->getLengthInMinutes(),
                ];
            }
        }

        return $this->json($response);
    }
}
