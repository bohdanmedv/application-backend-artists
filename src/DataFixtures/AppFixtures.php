<?php

namespace App\DataFixtures;

use App\Controller\TokenController;
use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use App\Entity\Token;
use App\Utils\TokenGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = file_get_contents("https://gist.githubusercontent.com/fightbulc/9b8df4e22c2da963cf8ccf96422437fe/raw/8d61579f7d0b32ba128ffbf1481e03f4f6722e17/artist-albums.json");

        if (empty($data)) {
            echo 'No data for load!';
            return;
        }

        $decodedData = json_decode($data, true);

        foreach ($decodedData as $artist) {
            $this->createArtist($artist);
        }
    }

    private function createArtist(array $artist) {
        echo print_r($artist['name'], true) . "\n";
        $token = new Token();
        $token->setValue(TokenController::getNewToken());

    }


}