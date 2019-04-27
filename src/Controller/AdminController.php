<?php

namespace App\Controller;

use App\Model\AdminRoomManager;
use App\Services\AddPictures;
use App\Services\CleanForm;

class AdminController extends AbstractController
{

    public function addroom()
    {
        $formRules = ['roomNameMaxLength' => 50,
            'descriptionMaxLength' => 300,
            'acceptedFiles' => ['jpg', 'jpeg', 'gif', 'png'],
            'fileSizeMaxKBytes' => 200];
        $adminRoomManager = new AdminRoomManager();
        $CleanForm = new CleanForm();
        $addPictures = new AddPictures();
        $errors = [];
        $caracteristics = $adminRoomManager->selectAllCaracteristics();
        $rooms = $adminRoomManager->selectAll();
        $roomNewId = $rooms[count($rooms) - 1]['id'] + 1;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postData = $_POST;

            $errors = $CleanForm->checkIfEmpty($postData, 'name', $errors);
            $errors = $CleanForm->checkIfEmpty($postData, 'description', $errors);

            $errors = $CleanForm->checkMaxLength(
                $postData['name'],
                $errors,
                $formRules['roomNameMaxLength'],
                'name'
            );
            $errors = $CleanForm->checkMaxLength(
                $postData['description'],
                $errors,
                $formRules['descriptionMaxLength'],
                'description'
            );
            $errors = $CleanForm->checkPrice($postData, $errors);
            if (isset($postData['caracteristic'])) {
                $errors = $CleanForm->checkCaracteristics($postData['caracteristic'], $caracteristics, $errors);
            }
            if ($_FILES) {
                $errors = $addPictures->checkType($formRules['acceptedFiles'], $errors);
                $errors = $addPictures->checkSize($errors, $formRules['fileSizeMaxKBytes']);
            }
            if (empty($errors)) {
                $photos = $addPictures->changePhotoName();
                $addPictures->transferFiles($photos);
                $adminRoomManager->insert($postData, $roomNewId);
                $adminRoomManager->insertCaracteristics($postData['caracteristic'], $roomNewId);
                $adminRoomManager->addPhotosNamesInDatabase($photos, $roomNewId);
                header('location:../Admin/rooms?success=true');
            }
        }
        return $this->twig->render(
            'Admin/addroom.html.twig',
            ['errors' => $errors,
                'formRules' => $formRules,
                'caracteristics' => $caracteristics]
        );
    }
}
