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

    public function getArticleOrderBy(string $field): array
    {
        {
            $query = "SELECT a.id AS article_id, a.title, 
                        a.image_url, a.article_url, a.description, 
                        a.created_at, a.star
                        FROM article a
                        JOIN user ON user.id = a.user_id
                        ORDER BY " . $field . " LIMIT " . self::CAROUSEL_CARD_NUMBER;

            return $this->pdo->query($query)->fetchAll();
        }
    }
}
