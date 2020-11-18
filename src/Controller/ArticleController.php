<?php


namespace App\Controller;


use App\Model\ArticleManager;
use App\Service\CommentValidator;

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

    public function addCommentUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $articleManager = new ArticleManager();
            $commentValidator = new CommentValidator($_POST);
            $commentValidator->checkFields();
            $errors = $commentValidator->getErrors();
            $commentData = $_POST;
            if (empty($errors)) {
                $articleManager->addComment($_POST['userId'], $_POST['articleId'], $_POST['message']);
                header("Location: /article/getComment/" . $_POST['articleId']);
            }
            return $this->twig->render('article_description.html.twig', [
                'errors' => $errors,
                'commentData' => $commentData,
            ]);
        } else {
            echo 'méthode interdite';
        }
    }

    public function getComment($id)
    {
        $articleAndComment = new ArticleManager();

        $articleData = $articleAndComment->getArticleById($id);
        $commentData = $articleAndComment->getCommentData($id);

        return $this->twig->render('article_description.html.twig', [
            'article_data' => $articleData,
            'comment_data' => $commentData,
        ]);
    }

    public function createArticle()
    {
        return $this->twig->render('techwatch_item/create_article.html.twig');
    }
}
