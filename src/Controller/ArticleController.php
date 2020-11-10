<?php


namespace App\Controller;


use App\Model\ArticleManager;

class ArticleController extends AbstractController
{
    public function like(int $articleId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $articleManager = new ArticleManager();
            $articleManager->addLike($articleId);
            header('Location: /');
        }
    }

    public function articlesByDate()
    {
        $articleManagerByDate = new ArticleManager();

        $articleViewByDate = $articleManagerByDate->getArticleOrderBy('created_at DESC');
        return $this->twig->render('articles_by_date.html.twig', [
            'article_date_view' => $articleViewByDate,
        ]);
    }

    public function articlesByTrend()
    {
        $articleManagerTrend = new ArticleManager();

        $articleViewByTrend = $articleManagerTrend->getArticleOrderBy('star DESC');
        return $this->twig->render('articles_by_trend.html.twig', [
            'article_trend_view' => $articleViewByTrend,
        ]);
    }

    public function voirPlus($articleId)
    {
        $plusSection = new ArticleManager();
        $plus = $plusSection->getArticleById($articleId);

            return $this->twig->render('voir_plus.html.twig', [
                'voir_plus' => $plus,
            ]);
    }
}
