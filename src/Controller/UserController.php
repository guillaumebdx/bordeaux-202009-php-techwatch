<?php


namespace App\Controller;



use App\Model\UserManager;

class UserController extends AbstractController
{
    public function register()
    {
        return $this->twig->render('techwatch_item/form_register.html.twig');
    }

    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $allUsers = $userManager->selectAllUsername();
            if (in_array($_POST['username'], $allUsers)) {
                $_SESSION['errors']['usernameExist'] = 'this username already exist';
                header('Location: /user/register');
            } else {
                $userData = [];
                $userData['username'] = $_POST['username'];
                $userData['firstname'] = $_POST['firstname'];
                $userData['lastname'] = $_POST['lastname'];
                $userData['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $userManager->insertUser($userData);
                header('Location: /');
            }
        } else {
            echo 'méthode interdite';
        }
    }

    public function login()
    {
        return $this->twig->render('techwatch_item/form_login.html.twig');
    }

    public function check()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $userData = $userManager->selectOneByUsername($_POST['username']);
            if (password_verify($_POST['password'], $userData['password'])) {
                $_SESSION['user'] = $userData;
                header('Location: /');
            } else {
                header('Location: /user/login');
            }
        } else {
            echo 'méthode interdite';
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /");
    }
}
