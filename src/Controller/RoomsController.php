<?php


namespace App\Controller;

use App\Model\RoomsManager;

class RoomsController extends AbstractController
{
    /**
     * returns a triple array with the rooms, the photos, and the caracteristics.
     * destroys some data that we don't need in the array, to make easier the for in the viewpage
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index()
    {

        $roomsManager = new RoomsManager();
        $rooms = $roomsManager->selectAllDoubleJoin('room_id', 'id', 'room_id');
        $roomsPhotosManager = new RoomsManager();
        $photos = $roomsPhotosManager->selectAllFromFirstJoined();


        for ($i = 0; $i < count($photos); $i++) {
            unset($photos[$i]['id']);
            unset($photos[$i]['room_id']);
            unset($photos[$i]['photo1']);
        }


        $roomCaracteristicsManager = new RoomsManager();
        $caracteristics = $roomCaracteristicsManager->selectAllFromSecondJoined();

        for ($i = 0; $i < count($caracteristics); $i++) {
            unset($caracteristics[$i]['id']);
            unset($caracteristics[$i]['room_id']);
        }
        return $this->twig->render('Rooms/index.html.twig', ['rooms' => $rooms, 'photos' => $photos,
            'caracteristics' => $caracteristics]);
    }
}
