<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\ReviewManager;
use App\Services\CleanForm;

/**
 * Class ReviewController
 *
 */
class ReviewController extends AbstractController
{
    const FORM_RULES = [
        "nameMaxCharacters" => 25,
        "reviewMaxCharacters" => 100,
        "minimumGrade" => 1,
        "maximumGrade" => 5];

    /**
     * displays the add review page, checks and send the form to the database.
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function addReview()
    {
        $errors = [];
        $postData = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cleanForm = new CleanForm();
            foreach ($_POST as $key => $rubric) {
                $postData[$key] = trim($rubric);
                $errors = $cleanForm->checkIfEmpty($rubric, $errors, $key);
            }
            $errors =
                $cleanForm->checkMaxLength(
                    $postData['name'],
                    $errors,
                    self::FORM_RULES['nameMaxCharacters'],
                    'name'
                );
            $errors = $cleanForm->checkMaxLength(
                $postData['review'],
                $errors,
                self::FORM_RULES['reviewMaxCharacters'],
                'review'
            );
            $errors = $cleanForm->checkGrade(
                $postData,
                $errors,
                self::FORM_RULES['minimumGrade'],
                self::FORM_RULES['maximumGrade'],
                'grade'
            );

            if ((empty($errors) && (!empty($postData)))) {
                $ReviewManager = new ReviewManager();
                $ReviewManager->insert($postData);
                header('location:index/?success=true&');
            }
        }
        return $this->twig->render(
            'Review/addreview.html.twig',
            ['postdata' => $postData, 'errors' => $errors, 'rules' => self::FORM_RULES]
        );
    }
}
