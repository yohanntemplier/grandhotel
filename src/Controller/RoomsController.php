<?php


namespace App\Controller;


use App\Model\RoomsManager;

class RoomsController extends AbstractController
{
    /**
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index()
    {
        $roomsManager = new RoomsManager();
        $rooms = $roomsManager->selectAll();

        return $this->twig->render('Rooms/index.html.twig', ['rooms' => $rooms]);
    }


}