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
        $ids=[];
        $errors = [];
        $adminReviewManager = new AdminReviewManager();
        $reviews = $adminReviewManager->selectAllReviews();
        foreach ($reviews as $review) {
            $ids[] = $review['id'];
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cleanForm = new CleanForm();
            $errors = $cleanForm->checkId($_POST['id'], $ids, $errors);
            $errors = $cleanForm->checkIfBool($errors, $_POST['id']);
            if (empty($errors)) {
                $adminReviewManager->update();
                header('location:/Admin/review/?success=true&id=' . $_POST['id'] . '#' . $_POST['id']);
            }
        }
        return $this->twig->render(
            'Admin/review.html.twig',
            ['reviews' => $reviews,
                'errors' => $errors,
                'get' => $_GET]
        );
    }
}
