<?php


namespace App\Controller;


use App\Model\ArticleManager;

class ArticleController extends AbstractController
{
    public function index()
    {
        $articleManager = new ArticleManager();
        $articleOfWeek = $articleManager->getArticleOfWeek();

        return $this->twig->render('techwatch_item/index.html.twig', [
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
