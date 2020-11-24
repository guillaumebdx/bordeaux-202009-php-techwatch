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
    }
}
