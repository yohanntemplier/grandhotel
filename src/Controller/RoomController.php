<?php


namespace App\Controller;

use App\Model\RoomManager;

class RoomController extends AbstractController
{
    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $photosPerRoom = [];
        $caracteristicsPerRoom = [];

        $roomManager = new RoomManager();
        $rooms = $roomManager->selectTableRoom();
        foreach ($rooms as $key => $room) {
            $caracteristicsPerRoom[] = $roomManager->selectCaracteristics($room['name']);
            $photosPerRoom[] = $roomManager->selectPhotos($room['name']);
        }

        return $this->twig->render('Rooms/index.html.twig', ['rooms' => $rooms, 'photos' => $photosPerRoom,
            'caracteristics' => $caracteristicsPerRoom]);
    }
}
