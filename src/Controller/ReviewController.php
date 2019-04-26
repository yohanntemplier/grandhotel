<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\ItemManager;
use App\Model\ReviewManager;
use App\Services\CleanForm;

/**
 * Class ReviewController
 *
 */
class ReviewController extends AbstractController
{
    const FORMRULES = [
        "nameMaxCharacters" => 25,
        "reviewMaxCharacters" => 500,
        "minimumGrade" => 1,
        "maximumGrade" => 5];


    /**
     * Displays the review which are accepted
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $reviewManager = new ReviewManager();
        $reviews = $reviewManager->selectAllOnLine();

        return $this->twig->render('Review/index.html.twig', ['reviews' => $reviews, 'rules' => self::FORMRULES]);
    }
}
