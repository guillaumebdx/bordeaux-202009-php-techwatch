<?php


namespace App\Controller;


use App\Model\ArticleManager;
use App\Service\CreateArticleValidator;
use DateTime;

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
            $articleManager->addComment($_POST['userId'], $_POST['articleId'], $_POST['message']);
            header("Location: /Article/getComment/" . $_POST['articleId']);
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

    public function articleForm()
    {
        $presentTime = new DateTime();
        $format = date_format($presentTime, "Y-m-d H:i:s");
        return $this->twig->render('techwatch_item/create_article.html.twig', [
        'date_time' => $format,
        ]);
    }

    public function addWatch()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $picture = $_POST['picture'];
            $link = $_POST['link'];
            $description = $_POST['description'];
            $userId = $_POST['userId'];
            $dateTime = $_POST['dateTime'];
            $userData = $_POST;

            $articleManager = new ArticleManager();
            $createArticleValidator = new CreateArticleValidator($_POST);
            $createArticleValidator->checkFields();
            $errors = $createArticleValidator->getErrors();
            if (empty($errors)) {
                $articleManager->addArticle($title, $link, $picture, $description, $dateTime, $userId);
                header("Location: /news/articlesByDate/");
            }
            return $this->twig->render('techwatch_item/create_article.html.twig', [
                'errors' => $errors,
                'userData' => $userData,
            ]);
        } else {
            echo 'méthode interdite';
        }
    }

    public function removeArticle()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $articleManager = new ArticleManager();
            $articleManager->deleteArticle($_POST['articleId']);
            header("Location: /");
        }
    }
}
