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
        $username = trim($userData['username']);
        $firstname = trim($userData['firstname']);
        $lastname = trim($userData['lastname']);
        $password = trim($userData['password']);
        $query = "INSERT INTO " . self::TABLE .
            "(username, lastname, firstname, password)  
            VALUES (:username, :lastname, :firstname, :password)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':username', $username, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':password', $password, \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function selectOneByUsername(string $username): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE username=:username");
        $statement->bindValue(':username', $username, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public function selectAllUsername(): array
    {
        $query = 'SELECT username FROM ' . self::TABLE;
        $allUsernames = $this->pdo->query($query);
        $usernames = [];
        foreach ($allUsernames as $usernameData) {
            $usernames[] = $usernameData['username'];
        }
        return $usernames;
    }
}
