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

    public function articleRand()
    {
        $articleManagerRandom = new ArticleManager();
        $articleRandom = $articleManagerRandom->getTechnologyWatchRand();

        return $this->twig->render('Projet-2-Item/index.html.twig', [
            'articleRandom' => $articleRandom
        ]);
    }

    public function articleDate()
    {
        $articleManagerDate = new ArticleManager();
        $articleDate = $articleManagerDate->getTechnologyWatchByDate();

        return $this->twig->render('Projet-2-Item/index.html.twig', [
            'articleDate' => $articleDate
        ]);
    }

    public function articleTrend()
    {
        $articleManagerTrend = new ArticleManager();
        $articleTrend = $articleManagerTrend->getTechnologyWatchByStar();

        return $this->twig->render('Projet-2-Item/index.html.twig', [
            'articleTrend' => $articleTrend
        ]);
    }
}
