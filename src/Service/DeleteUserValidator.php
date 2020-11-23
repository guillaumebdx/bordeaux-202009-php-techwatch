<?php


namespace App\Service;


class DeleteUserValidator extends FormValidator
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
            if (!$this->isUsernameValid()) {
                $this->addError('username', 'Ce pseudo n\'existe pas.');
            }
        }
    }
}
