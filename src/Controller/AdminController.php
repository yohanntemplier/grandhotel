<?php

namespace App\Controller;

use App\Model\AdminRoomManager;
use App\Model\AdminServicesManager;
use App\Services\AddPictures;
use App\Services\CleanForm;
use App\Model\AdminReviewManager;

class AdminController extends AbstractController
{
    /**Initializes the admin index.
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('Admin/index.html.twig');
    }

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
                $photos['pictures'] = $addPictures->changePhotoName();
                $addPictures->transferFiles($photos['pictures']);
                $lastRoomId = $adminRoomManager->insert($postData);
                $postData['roomId'] = $lastRoomId;
                if (isset($postData['caracteristic'])) {
                    $adminRoomManager->insertCaracteristics($postData);
                }
                $photos['roomId'] = $lastRoomId;
                $adminRoomManager->addPhotosNamesInDatabase($photos);
                header('location:../Admin/rooms/?success=true');
            }
        }
        return $this->twig->render(
            'Admin/addroom.html.twig',
            ['errors' => $errors,
                'formRules' => $formRules,
                'caracteristics' => $caracteristics,]
        );
    }

    /**
     * Displays the review page, shows all the reviews, and a form permits to change the review status online/offline
     * Displays the page addroom, checks the form, and sends the items in the database.
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function review()
    {
        $errors = [];
        $adminReviewManager = new AdminReviewManager();
        $reviews = $adminReviewManager->selectAllReviews();
        $postData = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $value) {
                $postData[$key] = $value;
            }
            $cleanForm = new CleanForm();
            $errors = $cleanForm->checkIfBool($errors, $postData['id']);
            if (empty($errors)) {
                $adminReviewManager->update($postData);
                header('location:/Admin/review/?success=true&id=' . $postData['id'] . '#' . $postData['id']);
            }
        }
        return $this->twig->render(
            'Admin/review.html.twig',
            ['reviews' => $reviews,
                'errors' => $errors,
                'get' => $_GET,]
        );
    }

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


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postData = $_POST;
            $addPictures = new AddPictures();
            $photos = $adminRoomManager->selectPhotoToDelete($postData['id']);
            foreach ($photos as $photo) {
                $image = 'assets/images/rooms/' . $photo['photo_name'];
                $addPictures->deleteImage($image);
            }
            $adminRoomManager->delete($postData['id']);
            header('location:/Admin/rooms/?success=true');
        }
        return $this->twig->render('Admin/rooms.html.twig', ['rooms' => $rooms, 'get' => $_GET]);
    }

    public function services()
    {
        $adminServicesManager = new AdminServicesManager();
        $services = $adminServicesManager->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postData = $_POST;
            $adminServicesManager->delete($postData['id']);
            header('location:/Admin/services/?success=true');
        }

        return $this->twig->render('Admin/services.html.twig', ['services' => $services, 'get' => $_GET]);
    }


    public function addService()
    {
        $formRules = ['CaracteristicNameMaxLength' => 40];
        $adminServicesManager = new AdminServicesManager();
        $cleanForm = new CleanForm();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postData = $_POST;
            if (!empty($postData['caracteristic_name'])) {
                $postData['caracteristic_name'] = $cleanForm->trim($postData['caracteristic_name']);
                $errors = $cleanForm->checkMaxLength(
                    $postData['caracteristic_name'],
                    $errors,
                    $formRules['CaracteristicNameMaxLength'],
                    'caracteristic_name'
                );
            } else {
                $errors['caracteristic_name']['empty'] = 'Ce champ ne peut pas rester vide!';
            }
            if (empty($errors)) {
                $adminServicesManager->insert($postData);
                header('location:../Admin/services/?success=true');
            }
        }
        return $this->twig->render(
            'Admin/addservice.html.twig',
            ['errors' => $errors,
                'formRules' => $formRules]
        );
    }
}
