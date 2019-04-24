<?php


namespace App\Controller;

use App\Model\SeminaireManager;

class SeminaireController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('Seminaire/index.html.twig');
    }
}
