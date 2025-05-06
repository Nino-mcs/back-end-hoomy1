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
use App\Entity\Song;
use App\Entity\Image;
use App\Entity\Playlist;
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
        // --- Utilisateur Admin ---
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($this->encoder->hashPassword($user, 'admin'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        // --- Images pour les profils ---
        $avatars = [];
        foreach (['avatar1.jpg', 'avatar2.jpg', 'avatar3.jpg', 'avatar4.jpg'] as $path) {
            $image = new Image();
            $image->setImagePath($path);
            $manager->persist($image);
            $avatars[] = $image;
        }

        // --- Profils utilisateurs ---
        $profiles = [];
        foreach (['toto', 'tata', 'tete', 'titi'] as $index => $username) {
            $profile = new Profile();
            $profile->setUsername($username);
            $profile->setPassword('1234'); // Juste pour l'exemple
            $profile->setImage($avatars[$index]);
            $manager->persist($profile);
            $profiles[] = $profile;
        }

        // --- Images pour les pièces ---
        $roomImages = [];
        foreach (['room1.jpg', 'room2.jpg', 'room3.jpg'] as $path) {
            $image = new Image();
            $image->setImagePath($path);
            $manager->persist($image);
            $roomImages[] = $image;
        }

        // --- Pièces ---
        $rooms = [];
        $roomLabels = ['Salle de bain', 'Salon', 'Chambre'];
        foreach ($roomLabels as $index => $label) {
            $room = new Room();
            $room->setLabel($label);
            $room->setImage($roomImages[$index]);
            $manager->persist($room);
            $rooms[] = $room;
        }

        // --- Types d'appareils ---
        $deviceTypes = [];
        foreach (['Lumière', 'Thermostat', 'Ventilateur'] as $label) {
            $deviceType = new DeviceType();
            $deviceType->setLabel($label);
            $manager->persist($deviceType);
            $deviceTypes[] = $deviceType;
        }

        // --- Appareils ---
        $devices = [];
        $devicesData = [
            ['room' => $rooms[0], 'type' => $deviceTypes[0], 'label' => 'Lampe de chevet', 'status' => 'active', 'ref' => 'REF123'],
            ['room' => $rooms[1], 'type' => $deviceTypes[1], 'label' => 'Thermostat salon', 'status' => 'inactive', 'ref' => 'REF124'],
            ['room' => $rooms[2], 'type' => $deviceTypes[2], 'label' => 'Ventilateur chambre', 'status' => 'active', 'ref' => 'REF125'],
        ];
        foreach ($devicesData as $data) {
            $device = new Device();
            $device->setRoom($data['room']);
            $device->setDeviceType($data['type']);
            $device->setLabel($data['label']);
            $device->setStatus($data['status']);
            $device->setReference($data['ref']);
            $manager->persist($device);
            $devices[] = $device;
        }

        // --- Types de réglages ---
        $settingTypes = [];

        $brightness = new SettingType();
        $brightness->setLabel('Luminosité');
        $brightness->setDataType('integer');
        $manager->persist($brightness);
        $settingTypes[] = $brightness;

        $temperature = new SettingType();
        $temperature->setLabel('Température');
        $temperature->setDataType('integer');
        $manager->persist($temperature);
        $settingTypes[] = $temperature;

        // --- Réglages des appareils ---
        $deviceSettingsData = [
            ['device' => $devices[0], 'setting' => $brightness, 'value' => '75'],
            ['device' => $devices[1], 'setting' => $temperature, 'value' => '22'],
        ];
        foreach ($deviceSettingsData as $data) {
            $deviceSetting = new DeviceSetting();
            $deviceSetting->setDevice($data['device']);
            $deviceSetting->setSettingType($data['setting']);
            $deviceSetting->setValue($data['value']);
            $manager->persist($deviceSetting);
        }

        // --- Playlists ---
        $playlists = [];
        foreach (['Détente Soirée', 'Concentration Zen'] as $label) {
            $playlist = new Playlist();
            $playlist->setLabel($label);
            $manager->persist($playlist);
            $playlists[] = $playlist;
        }

        // --- Vibes ---
        $vibesData = [
            [
                'label' => 'Relax Chill',
                'energy' => 'low',
                'stress' => 'low',
                'motivation' => 'low',
                'profile' => $profiles[0],
                'image' => $avatars[0],
                'playlist' => $playlists[0],
            ],
            [
                'label' => 'Morning Boost',
                'energy' => 'high',
                'stress' => 'low',
                'motivation' => 'high',
                'profile' => $profiles[1],
                'image' => $avatars[1],
                'playlist' => $playlists[1],
            ],
        ];

        foreach ($vibesData as $data) {
            $vibe = new Vibe();
            $vibe->setLabel($data['label']);
            $vibe->setEnergy($data['energy']);
            $vibe->setStress($data['stress']);
            $vibe->setMotivation($data['motivation']);
            $vibe->setProfile($data['profile']);
            $vibe->setImage($data['image']);
            $vibe->setPlaylist($data['playlist']);
            $manager->persist($vibe);
        }

        $manager->flush();
    }
}
