<?php


namespace App\Controller;


use App\Model\ArticleManager;

class NewsController extends AbstractController
{
    public function articlesByDate()
    {
        $articleManagerByDate = new ArticleManager();

        $articleViewByDate = $articleManagerByDate->getAllArticleOrderBy('created_at DESC');
        return $this->twig->render('articles_by_date.html.twig', [
            'article_date_view' => $articleViewByDate,
        ]);
    }
}