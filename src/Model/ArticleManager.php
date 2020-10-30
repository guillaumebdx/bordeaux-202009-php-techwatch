<?php


namespace App\Model;


class ArticleManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'article';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getArticleOfWeek(): array
    {
        $query = "SELECT * FROM article WHERE week(created_at)=week(curdate()) ORDER BY star DESC LIMIT 1";
        return $this->pdo->query($query)->fetch();
    }
    public function addLike($articleId):void
    {
        $query = "UPDATE " . self::TABLE . " SET star = star + 1 WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $articleId, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function getArticleRand(): array
    {
        $query = "SELECT * FROM article ORDER BY RAND() LIMIT 15";
        return $this->pdo->query($query)->fetchAll();
    }

    public function getArticleByDate(): array
    {
        $query = "SELECT * FROM article ORDER BY created_at DESC LIMIT 15";
        return $this->pdo->query($query)->fetchAll();
    }

    public function getArticleByStar(): array
    {
        $query = "SELECT * FROM article ORDER BY star DESC LIMIT 15";
        return $this->pdo->query($query)->fetchAll();
    }
}
