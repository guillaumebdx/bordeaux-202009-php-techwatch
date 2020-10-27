<?php


namespace App\Model;


class Random
{
    private $viewRandom;

    private $newView;

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


    public function random(): array
    {
        return $this->pdo->query('SELECT * FROM article ORDER BY RAND() ' . $this->viewRandom)->fetchAll();
    }



    public function new(): array
    {
        return $this->pdo->query('SELECT * FROM article ORDER BY created_at ASC' . $this->newView)->fetchAll();
    }

}