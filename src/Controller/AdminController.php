<?php

namespace App\Controller;

use App\Model\AdminReviewManager;
use App\Services\CleanForm;

class AdminController extends AbstractController
{
    /**
     * Displays the review page, shows all the reviews, and a form permits to change the review status online/offline
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
        $postData=[];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $value) {
                $postData[$key]=$value;
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
}
