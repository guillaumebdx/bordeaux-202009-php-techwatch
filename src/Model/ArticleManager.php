<?php


namespace App\Model;


class ArticleManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'article';
    const CARD_NUMBER = 30;

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getArticleOfWeek(): array
    {
        $bestArticleQuery = "SELECT week(created_at) FROM article ORDER BY star DESC LIMIT 1";
        $lastBestArticle = $this->pdo->query($bestArticleQuery)->fetch();
        $curdate = $this->pdo->query("SELECT week(curdate())")->fetch();
        if ($lastBestArticle === $curdate) {
            $query = "SELECT * FROM article WHERE week(created_at)=week(curdate()) ORDER BY star DESC LIMIT 1";
            $statement = $this->pdo->query($query)->fetch();
        } else {
            $query = "SELECT * FROM article WHERE week(created_at)=week(curdate())-1 ORDER BY star DESC LIMIT 1";
            $statement = $this->pdo->query($query)->fetch();
        }
        return $statement;
    }
    public function addLike($articleId):void
    {
        $query = "UPDATE " . self::TABLE . " SET star = star + 1 WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $articleId, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function getArticleOrderBy(string $what): array
    {
            $query =   "SELECT a.id AS article_id, a.title, 
                        a.image_url, a.article_url, a.description, 
                        a.created_at, a.star
                        FROM article a
                        JOIN user ON user.id = a.user_id 
                        ORDER BY " . $what . " LIMIT " . self::CARD_NUMBER;
            return $this->pdo->query($query)->fetchAll();
    }

    public function getArticleById($articleId)
    {
        $query =   "SELECT a.id AS article_id, a.title, a.article_url, a.image_url, a.description, a.created_at, a.star, 
                    u.username, 
                    c.message, c.user_id
                    FROM article a
                    JOIN user u 
                    ON u.id = a.user_id
                    JOIN comment c
                    ON a.id = c.article_id
                    WHERE a.id =:id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $articleId, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }
}
