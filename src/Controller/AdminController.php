<?php

namespace App\Controller;

use App\Model\AdminRoomManager;
use App\Services\AddPictures;
use App\Services\CleanForm;

class AdminController extends AbstractController
{
    /**
     * Displays the page addroom, checks the form, and sends the items in the database.
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function addRoom()
    {
        $formRules = ['roomNameMaxLength' => 50,
            'descriptionMaxLength' => 300,
            'acceptedFiles' => ['jpg', 'jpeg', 'gif', 'png'],
            'fileSizeMaxKBytes' => 200];
        $adminRoomManager = new AdminRoomManager();
        $cleanForm = new CleanForm();
        $addPictures = new AddPictures();
        $errors = [];
        $caracteristics = $adminRoomManager->selectAllCaracteristics();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postData = $_POST;
            $postData['name'] = $cleanForm->trim($postData['name']);
            $postData['description'] = $cleanForm->trim($postData['description']);
            $errors = $cleanForm->checkIfEmpty($postData, 'name', $errors);
            $errors = $cleanForm->checkIfEmpty($postData, 'description', $errors);
            $errors = $cleanForm->checkMaxLength(
                $postData['name'],
                $errors,
                $formRules['roomNameMaxLength'],
                'name'
            );
            $errors = $cleanForm->checkMaxLength(
                $postData['description'],
                $errors,
                $formRules['descriptionMaxLength'],
                'description'
            );
            $errors = $cleanForm->checkPrice($postData, $errors);
            if (isset($postData['caracteristic'])) {
                $errors = $cleanForm->checkCaracteristics($postData['caracteristic'], $caracteristics, $errors);
            }
            if ($_FILES) {
                $errors = $addPictures->checkType($formRules['acceptedFiles'], $errors);
                $errors = $addPictures->checkSize($errors, $formRules['fileSizeMaxKBytes']);
            }
            if (empty($errors)) {
                $photos = $addPictures->changePhotoName();
                $addPictures->transferFiles($photos);
                $lastRoomId = $adminRoomManager->insert($postData);
                $postData['roomId'] = $lastRoomId;
                $adminRoomManager->insertCaracteristics($postData);
                $adminRoomManager->addPhotosNamesInDatabase($photos, $lastRoomId);
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
