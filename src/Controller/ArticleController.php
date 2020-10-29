<?php


namespace App\Controller;


use App\Model\ArticleManager;

class ArticleController extends AbstractController
{
    public function index()
    {
        $articleManager = new ArticleManager();
        $articleOfWeek = $articleManager->getTechnologyWatchOfWeek();

        return $this->twig->render('Projet-2-Item/index.html.twig', [
            'articleOfWeek' => $articleOfWeek
        ]);
    }

    public function like($articleId)
    {
        $articleManager = new ArticleManager();
        $articleManager->addLike($articleId);
        header('Location: /');
    }
}
