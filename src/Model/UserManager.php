<?php


namespace App\Model;


class UserManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'user';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insertUser($userData): int
    {
        $query = "INSERT INTO " . self::TABLE .
            "(username, lastname, firstname, password)  
            VALUES (:username, :lastname, :firstname, :password)";
        $statement = $this->pdo->prepare($query);
        foreach ($userData as $userType => $value) {
            $statement->bindValue(':' . $userType, $userData[$userType], \PDO::PARAM_STR);
        }
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
