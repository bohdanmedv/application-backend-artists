<?php

namespace App\DataFixtures;

use App\Controller\TokenController;
use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    protected $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
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

    private function createArtist(array $artist)
    {
        $artistRecord = new Artist();
        $artistRecord
            ->setName($artist['name'])
            ->setToken(TokenController::getNewToken($this->manager));
        $this->manager->persist($artistRecord);
        $this->manager->flush();

        foreach ($artist['albums'] as $album) {
            $this->createAlbum($album, $artistRecord);
        }

    }

    private function createAlbum(array $album, Artist $artist)
    {
        $albumRecord = new Album();
        $albumRecord
            ->setTitle($album['title'])
            ->setCover($album['cover'])
            ->setDescription($album['description'])
            ->setArtist($artist)
            ->setToken(TokenController::getNewToken($this->manager));

        $this->manager->persist($albumRecord);
        $this->manager->flush();

        foreach ($album['songs'] as $song) {
            $this->createSong($song, $albumRecord);
        }
    }

    private function createSong(array $song, Album $album)
    {
        $songRecord = new Song();
        $songRecord
            ->setTitle($song['title'])
            ->setAlbum($album)
            ->setLength($this->convertLength($song['length']));
        $this->manager->persist($songRecord);
        $this->manager->flush();
    }

    private function convertLength($length)
    {
        $newLength = explode(':', $length);

        return $newLength[0] * 60 + $newLength[1];
    }

}