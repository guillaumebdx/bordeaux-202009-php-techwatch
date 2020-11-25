<?php


namespace App\Controller;



use App\Model\FavoriteManager;
use App\Model\UserManager;
use App\Service\DeleteUserValidator;
use App\Service\LoginValidator;
use App\Service\RegisterValidator;

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
            $registerValidator = new RegisterValidator($_POST);
            $registerValidator->checkFields();
            $errors = $registerValidator->getErrors();
            $userData = $_POST;
            if (empty($errors)) {
                $userData['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $userId = $userManager->insertUser($userData);
                $_SESSION['user'] = $userData;
                $_SESSION['user']['id'] = $userId;
                header('Location: /');
            }
            return $this->twig->render('techwatch_item/form_register.html.twig', [
                'errors' => $errors,
                'userData' => $userData,
            ]);
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
            $loginValidator = new LoginValidator($_POST);
            $loginValidator->checkFields();
            $errors = $loginValidator->getErrors();
            $userId = $loginValidator->getUserId();
            $userData = $_POST;
            if (empty($errors)) {
                $userData = $userManager->getUserById($userId);
                $_SESSION['user'] = $userData;
                $_SESSION['user']['id'] = $userId;
                $favorites = [];
                $favoriteManager = new FavoriteManager();
                $favoritesId = $favoriteManager->getAllFavorite();
                foreach ($favoritesId as $favoriteId) {
                    $favorites[$favoriteId['article_id']] = (int)$favoriteId['article_id'];
                }
                $_SESSION["favorites"] = $favorites;
                header('Location: /');
            }
            return $this->twig->render('techwatch_item/form_login.html.twig', [
                'errors' => $errors,
                'userData' => $userData,
            ]);
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

    public function getUser()
    {
        $userManager = new UserManager();
        $userData = $userManager->getUserById($_SESSION['user']['id']);
        return $this->twig->render('techwatch_item/profile_page.html.twig', [
            'user_data' => $userData,
        ]);
    }

    public function delete()
    {
        return $this->twig->render('techwatch_item/form_delete_user.html.twig');
    }

    public function removeUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $deleteUserValidator = new DeleteUserValidator($_POST);
            $deleteUserValidator->checkFields();
            $errors = $deleteUserValidator->getErrors();
            $username = $_POST['username'];
            if (empty($errors)) {
                $userId = $deleteUserValidator->getUserId();
                $userManager->deleteUser($userId);
                return $this->twig->render('techwatch_item/form_delete_user.html.twig', [
                    'success' => 'Cet utilisateur a bien été supprimé.',
                ]);
            }
            return $this->twig->render('techwatch_item/form_delete_user.html.twig', [
                'errors' => $errors,
                'username' => $username,
            ]);
        } else {
            echo 'méthode interdite';
        }
    }
}
