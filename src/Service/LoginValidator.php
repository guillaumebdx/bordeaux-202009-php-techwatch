<?php


namespace App\Service;


use App\Model\UserManager;

class LoginValidator extends FormValidator implements ValideableInterface
{
    public function checkFields()
    {
        parent::checkFields();
        if (!isset($this->errors['username'])) {
            if (!$this->isUsernameValid()) {
                $this->addError('username', 'Ce pseudo n\'existe pas.');
            } else {
                if (!isset($this->errors['password'])) {
                    if (!$this->isPasswordValid()) {
                        $this->addError('password', 'mot de passe erroné');
                    }
                }
            }
        }
    }

    public function isPasswordValid(): bool
    {
        $userData = $this->userManager->selectOneBy('username', $this->fields['username']);
        $result = false;
        if (password_verify($this->fields['password'], $userData['password'])) {
            $result = true;
        }
        return $result;
    }
}