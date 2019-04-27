<?php

namespace App\Controller;

use App\Model\AdminRoomManager;

class AdminController extends AbstractController
{

    /**Gives the existing rooms in database
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function rooms()
    {
        $adminRoomManager = new AdminRoomManager();
        $rooms = $adminRoomManager->selectAll();
        return $this->twig->render('Admin/rooms.html.twig', ['rooms' => $rooms]);
    }
}
