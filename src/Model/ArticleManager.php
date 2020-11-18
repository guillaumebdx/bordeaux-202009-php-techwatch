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
    public function addLike(int $articleId)
    {
        $query = "UPDATE " . self::TABLE . " SET star = star + 1 WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $articleId, \PDO::PARAM_INT);
        $statement->execute();
        return $this->selectOneById($articleId);
    }

    public function getArticleOrderBy(string $field): array
    {

        {
            $query = "SELECT a.id AS article_id, a.title, 
                        a.image_url, a.article_url, a.description, 
                        a.created_at, a.star, a.user_id
                        FROM article a
                        JOIN user ON user.id = a.user_id
                        ORDER BY " . $field . " LIMIT " . self::CAROUSEL_CARD_NUMBER;

            return $this->pdo->query($query)->fetchAll();
        }
    }

    public function getAllArticleOrderBy(string $field): array
    {
        {
            $query = "SELECT a.id AS article_id, a.title, 
                        a.image_url, a.article_url, a.description, 
                        a.created_at, a.star, a.user_id
                        FROM article a
                        JOIN user ON user.id = a.user_id
                        ORDER BY " . $field;

            return $this->pdo->query($query)->fetchAll();
        }
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

    public function insertWatch(array $article): array
    {
        $query = "INSERT INTO " . self::TABLE . "(title,̀description,image_url,article_url)
         VALUES (:title, :description, :image_url, :article_url)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('title', $article['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $article['description'], \PDO::PARAM_STR);
        $statement->bindValue('image_url', $article['image_url'], \PDO::PARAM_STR);
        $statement->bindValue('article_url', $article['article_url'], \PDO::PARAM_STR);
        $statement->execute();
        return $this->showWatch();
    }
    public function showWatch() :array
    {
        $query = "SELECT image_url FROM article
                   WHERE id = :id ";
        $statement = $this->pdo->query($query)->fetch();
        return $statement;
    }
}
