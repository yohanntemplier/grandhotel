<?php

namespace App\Controller;

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
}
