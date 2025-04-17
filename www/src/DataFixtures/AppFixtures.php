<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Profile;
use App\Entity\Room;
use App\Entity\Device;
use App\Entity\DeviceType;
use App\Entity\DeviceSetting;
use App\Entity\SettingType;
use App\Entity\Vibe;
use App\Entity\Image;
use App\Entity\Playlist;
use App\Entity\Song;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d'un utilisateur
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($this->encoder->hashPassword($user, 'admin'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        // Création d'images
        $avatar1 = new Image();
        $avatar1->setImagePath('chemin à definir');
        $manager->persist($avatar1);
        // Création d’un profil
        $profile1 = new Profile();
        $profile1->setUsername('toto');
        $profile1->setPassword('1234');
        $profile1->setImage($avatar1);
        $manager->persist($profile1);

        // Création d'images
        $avatar2 = new Image();
        $avatar2->setImagePath('chemin à definir');
        $manager->persist($avatar2);

        $profile2 = new Profile();
        $profile2->setUsername('tata');
        $profile2->setImage($avatar2);
        $profile2->setPassword('1234');
        $manager->persist($profile2);

        // Création d'images
        $avatar3 = new Image();
        $avatar3->setImagePath('chemin à definir');
        $manager->persist($avatar3);

        $profile3 = new Profile();
        $profile3->setUsername('tete');
        $profile3->setPassword('1234');
        $profile3->setImage($avatar3);
        $manager->persist($profile3);

        // Création d'images
        $avatar4 = new Image();
        $avatar4->setImagePath('chemin à definir');
        $manager->persist($avatar4);

        $profile4 = new Profile();
        $profile4->setUsername('titi');
        $profile4->setPassword('1234');
        $profile4->setImage($avatar4);
        $manager->persist($profile4);

        // Création d'images
        $image = new Image();
        $image->setImagePath('à definir');
        $manager->persist($image);

        // Création de pièces
        $room1 = new Room();
        $room1->setLabel('Salle de bain');
        $room1->setImage($image);
        $manager->persist($room1);

        $room2 = new Room();
        $room2->setLabel('Salon');
        $room2->setImage($image);
        $manager->persist($room2);

        // Types d'appareils
        $lightType = new DeviceType();
        $lightType->setLabel('Lumière');
        $manager->persist($lightType);

        $thermoType = new DeviceType();
        $thermoType->setLabel('Thermostat');
        $manager->persist($thermoType);

        // Appareils
        $device1 = new Device();
        $device1->setRoom($room1);
        $device1->setDeviceType($lightType);
        $device1->setLabel('Lampe de chevet');
        $manager->persist($device1);

        $device2 = new Device();
        $device2->setRoom($room2);
        $device2->setDeviceType($thermoType);
        $device2->setLabel('Thermostat salon');
        $manager->persist($device2);

        // Types de réglages
        $brightness = new SettingType();
        $brightness->setLabel('Luminosité');
        $brightness->setDataType('integer');
        $manager->persist($brightness);

        $temperature = new SettingType();
        $temperature->setLabel('Température');
        $temperature->setDataType('integer');
        $manager->persist($temperature);

        // Réglages
        $setting1 = new DeviceSetting();
        $setting1->setDevice($device1);
        $setting1->setSettingType($brightness);
        $setting1->setValue('75');
        $manager->persist($setting1);

        $setting2 = new DeviceSetting();
        $setting2->setDevice($device2);
        $setting2->setSettingType($temperature);
        $setting2->setValue('22');
        $manager->persist($setting2);

        // Playlist et Song
        $playlist = new Playlist();
        $playlist->setLabel('Détente Soirée');
        $manager->persist($playlist);

        $playlist2 = new Playlist();
        $playlist2->setLabel('Concentration Zen');
        $manager->persist($playlist2);

        $song3 = new Song();
        $song3->setLabel('Calm Flow');
        $song3->setArtist('Zen Master');
        $song3->setDuration(new \DateTime('00:05:00'));
        $song3->setFilePath('chemin');
        $manager->persist($song3);

        $song4 = new Song();
        $song4->setLabel('Deep Focus');
        $song4->setArtist('Focus Beats');
        $song4->setDuration(new \DateTime('00:04:45'));
        $song4->setFilePath('chemin');
        $manager->persist($song4);

        $playlist2->addPlaylistSong($song3);
        $playlist2->addPlaylistSong($song4);

        $playlist3 = new Playlist();
        $playlist3->setLabel('Énergie Workout');
        $manager->persist($playlist3);

        $song5 = new Song();
        $song5->setLabel('Power Mode');
        $song5->setArtist('Energy Vibes');
        $song5->setDuration(new \DateTime('00:03:15'));
        $song5->setFilePath('chemin');
        $manager->persist($song5);

        $song6 = new Song();
        $song6->setLabel('Pump It');
        $song6->setArtist('Workout Hero');
        $song6->setDuration(new \DateTime('00:03:50'));
        $song6->setFilePath('chemin');
        $manager->persist($song6);

        $playlist3->addPlaylistSong($song5);
        $playlist3->addPlaylistSong($song6);

        // Création de chansons
        $song1 = new Song();
        $song1->setLabel('Song 1');
        $song1->setArtist('Artist 1');
        $song1->setDuration(new \DateTime('00:03:30'));
        $song1->setFilePath('à definir son');
        $manager->persist($song1);

        $song2 = new Song();
        $song2->setLabel('Song 2');
        $song2->setArtist('Artist 2');
        $song2->setDuration(new \DateTime('00:04:00'));
        $song2->setFilePath('son à definir');
        $manager->persist($song2);

        // Ajouter les chansons à la playlist en utilisant la méthode addPlaylistSong
        $playlist->addPlaylistSong($song1);
        $playlist->addPlaylistSong($song2);

        // Création de plusieurs vibes dynamiquement
        $vibesData = [
            [
                'label' => 'Détente Soir',
                'energy' => 'low',
                'stress' => 'low',
                'motivation' => 'medium',
                'profile' => $profile1,
                'playlist' => $playlist,
                'image' => $image,
            ],
            [
                'label' => 'Morning Boost',
                'energy' => 'high',
                'stress' => 'low',
                'motivation' => 'high',
                'profile' => $profile2,
                'playlist' => $playlist,
                'image' => $image,
            ],
            [
                'label' => 'Relax Total',
                'energy' => 'low',
                'stress' => 'low',
                'motivation' => 'low',
                'profile' => $profile3,
                'playlist' => $playlist,
                'image' => $image,
            ],
            [
                'label' => 'Concentration Max',
                'energy' => 'medium',
                'stress' => 'medium',
                'motivation' => 'high',
                'profile' => $profile4,
                'playlist' => $playlist,
                'image' => $image,
            ],
            [
                'label' => 'Énergie Matinale',
                'energy' => 'high',
                'stress' => 'low',
                'motivation' => 'high',
                'profile' => $profile1,
                'playlist' => $playlist,
                'image' => $image,
            ],
            [
                'label' => 'Focus Intense',
                'energy' => 'medium',
                'stress' => 'low',
                'motivation' => 'high',
                'profile' => $profile2,
                'playlist' => $playlist,
                'image' => $image,
            ],
            [
                'label' => 'Chill Pluie',
                'energy' => 'low',
                'stress' => 'medium',
                'motivation' => 'low',
                'profile' => $profile3,
                'playlist' => $playlist,
                'image' => $image,
            ],
            [
                'label' => 'Ambiance Nocturne',
                'energy' => 'medium',
                'stress' => 'low',
                'motivation' => 'medium',
                'profile' => $profile4,
                'playlist' => $playlist,
                'image' => $image,
            ],
        ];

        foreach ($vibesData as $data) {
            $vibe = new Vibe();
            $vibe->setLabel($data['label']);
            $vibe->setEnergy($data['energy']);
            $vibe->setStress($data['stress']);
            $vibe->setMotivation($data['motivation']);
            $vibe->setProfile($data['profile']);
            $vibe->setPlaylist($data['playlist']);
            $vibe->setImage($data['image']);
            $manager->persist($vibe);

            $event = new Event();
            $event->setLabel('Événement pour ' . $data['label']);
            $event->setDateStart(new \DateTime('+1 day'));
            $event->setDateEnd(new \DateTime('+1 day +2 hours'));
            $event->setVibe($vibe);
            $manager->persist($event);
        }

        // Event
        $event = new Event();
        $event->setLabel('Soirée détente');
        $event->setDateStart(new \DateTime('+1 day'));
        $event->setDateEnd(new \DateTime('+1 day +2 hours'));
        $event->setVibe($vibe);
        $manager->persist($event);

        // Flush les données dans la base de données
        $manager->flush();
    }
}
