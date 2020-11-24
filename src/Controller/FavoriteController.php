<?php


namespace App\Controller;


use App\Model\ArticleManager;
use App\Model\FavoriteManager;

class FavoriteController extends AbstractController
{
    public function add(int $articleId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $favoriteManager = new FavoriteManager();
            if (isset($_SESSION['user'])) {
                if (!$favoriteManager->getFavoriteById($articleId)) {
                    $favoriteManager->addFavorite($articleId);
                }
            }
            header('Location: /');
        } else {
            echo 'méthode interdite';
        }
    }

    public function list()
    {
        $favoriteManager = new FavoriteManager();
        $articleManager = new ArticleManager();
        $favoritesId = $favoriteManager->getAllFavorite();
        $favorites = [];
        foreach ($favoritesId as $favoriteId) {
            $favorites[] = $articleManager->selectOneById($favoriteId['article_id']);
        }
        return $this->twig->render('techwatch_item/favorite.html.twig', [
            'favorites' => $favorites,
        ]);
    }
}
