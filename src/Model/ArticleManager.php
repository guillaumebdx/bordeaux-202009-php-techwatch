<?php


namespace App\Model;


class ArticleManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'article';
    const CAROUSEL_CARD_NUMBER = 20;

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getArticleOfWeek(): array
    {
        $query = "SELECT * FROM article ORDER BY week(created_at) DESC, star DESC LIMIT 1";
        $statement = $this->pdo->query($query)->fetch();
        return $statement;
    }
    public function addLike(int $articleId):void
    {
        $query = "UPDATE " . self::TABLE . " SET star = star + 1 WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $articleId, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function getArticleOrderBy(string $what): array
    {
            $query = "SELECT a.id AS article_id, a.title, 
                        a.image_url, a.article_url, a.description, 
                        a.created_at, a.star
                        FROM article a
                        JOIN user ON user.id = a.user_id
                        ORDER BY " . $what . " LIMIT " . self::CAROUSEL_CARD_NUMBER;
            return $this->pdo->query($query)->fetchAll();
    }

    public function getArticleById(int $id)
    {
        $query =   "SELECT a.id AS article_id, a.title, a.article_url, a.image_url, a.description, 
                    a.created_at, a.star, 
                    u.username
                    FROM article a
                    JOIN user u 
                    ON u.id = a.user_id
                    WHERE a.id =:id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    public function addComment($userId, $articleId, $message)
    {
        $query = "INSERT INTO comment (`user_id`, `article_id`, `message`) 
                    VALUES (:userId, :articleId, :message)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('userId', $userId, \PDO::PARAM_STR);
        $statement->bindValue('articleId', $articleId, \PDO::PARAM_STR);
        $statement->bindValue('message', $message, \PDO::PARAM_STR);
        $statement->execute();
    }

    public function getCommentData(int $id)
    {
        $query = "SELECT u.id AS user_id, u.username, c.id AS comment_id, c.article_id,
                    c.message
                    FROM user u
                    JOIN comment c
                    ON u.id = c.user_id
                    WHERE c.article_id =:id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function searchBar($word): array
    {
        $query = 'SELECT title, article_url
                    FROM article 
                    WHERE title LIKE :word;';

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':word', '%' . $word . '%', \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
}
