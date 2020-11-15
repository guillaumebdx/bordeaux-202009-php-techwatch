<?php


namespace App\Controller;


use App\Model\ArticleManager;

class TrendsController extends AbstractController
{
    public function articlesByTrend()
    {
        $articleManagerTrend = new ArticleManager();

        $articleViewByTrend = $articleManagerTrend->getAllArticleOrderBy('star DESC');
        return $this->twig->render('articles_by_trend.html.twig', [
            'article_trend_view' => $articleViewByTrend,
        ]);
    }
}
