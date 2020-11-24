<?php


namespace App\Model;


class FavoriteManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'favorite';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function addFavorite(int $articleId)
    {
        $query = "INSERT INTO " . self::TABLE . "(user_id, article_id) VALUES (:user_id, :article_id)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':user_id', $_SESSION['user']['id'], \PDO::PARAM_INT);
        $statement->bindValue(':article_id', $articleId, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function getFavoriteById(int $articleId)
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE user_id=:user_id AND article_id=:article_id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':user_id', $_SESSION['user']['id'], \PDO::PARAM_INT);
        $statement->bindValue(':article_id', $articleId, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getAllFavorite()
    {
        $query = "SELECT article_id FROM " . self::TABLE . " WHERE user_id=:user_id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':user_id', (int)$_SESSION['user']['id'], \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
