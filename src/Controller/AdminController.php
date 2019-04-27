<?php

namespace App\Controller;

use App\Model\AdminReviewManager;
use App\Services\CleanForm;

class AdminController extends AbstractController
{
    public function review()
    {
        $ids=[];
        $errors = [];
        $adminReviewManager = new AdminReviewManager();
        $reviews = $adminReviewManager->selectAll();
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
