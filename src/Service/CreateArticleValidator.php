<?php


namespace App\Service;


class CreateArticleValidator extends FormValidator
{
    public function checkFields()
    {
        parent::checkFields();
        foreach ($this->fields as $fieldType => $value) {
            if (strlen($value) > 255) {
                $this->addError($fieldType, 'Ce champ est trop long');
            }
        }
        if (!isset($this->errors['description'])) {
            if (strlen($this->fields['description']) < 15) {
                $this->addError('description', 'La description doit faire au moins 15 caractère.');
            }
        }
    }
}
