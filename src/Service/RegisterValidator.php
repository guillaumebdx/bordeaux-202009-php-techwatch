<?php

namespace App\Service;

use App\Model\UserManager;

class RegisterValidator extends FormValidator implements ValideableInterface
{
    public function checkFields()
    {
        parent::checkFields();
        foreach ($this->fields as $fieldType => $value) {
            if (strlen($value) > 50) {
                $this->addError($fieldType, 'Ce champ est trop long');
            }
        }
        if (!isset($this->errors['username'])) {
            if ($this->isUsernameValid()) {
                $this->addError('username', 'Ce pseudo existe déjà.');
            }
        }
        if (!isset($this->errors['password'])) {
            if (!$this->isPasswordValid()) {
                $message = 'Le mot de passe doit contenir au moins une minuscule,
                 une majuscule, un chiffre et un caractère spécial($ @ % * + - _ !).';
                $this->addError('password', $message);
            }
        }
    }

    public function isPasswordValid(): bool
    {
        $result = false;
        if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $this->fields['password'])) {
            $result = true;
        }
        return $result;
    }
}
