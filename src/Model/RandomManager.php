<?php


namespace App\Model;


class RandomManager
{
    private $viewRandom;

    private $newView;

    private $viewLike;

    /**
     * @return mixed
     */
    public function getNewView()
    {
        return $this->newView;
    }

    /**
     * @param mixed $newView
     */
    public function setNewView($newView): void
    {
        $this->newView = $newView;
    }

    /**
     * @return mixed
     */
    public function getViewRandom()
    {
        return $this->viewRandom;
    }

    /**
     * @param mixed $viewRandom
     */
    public function setViewRandom($viewRandom): void
    {
        $this->viewRandom = $viewRandom;
    }

    /**
     * @return mixed
     */
    public function getViewLike()
    {
        return $this->viewLike;
    }

    /**
     * @param mixed $viewLike
     */
    public function setViewLike($viewLike): void
    {
        $this->viewLike = $viewLike;
    }


    public function random(): array
    {
        return $this->pdo->query('SELECT * FROM article ORDER BY RAND() ' . $this->viewRandom)->fetchAll();
    }



    public function trends(): array
    {
        return $this->pdo->query('SELECT * FROM article ORDER BY created_at DESC ' . $this->newView)->fetchAll();
    }


    public function star(): array
    {
        return $this->pdo->query('SELECT * FROM article ORDER BY star DESC ' . $this->viewLike)->fetchAll();
    }
}

