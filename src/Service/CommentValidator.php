<?php


namespace App\Service;


class CommentValidator extends FormValidator
{
    public function checkFields()
    {
        parent::checkFields();
        if (isset($this->errors['message'])) {
            if (!isset($_SESSION['user'])) {
                $this->addError('message', 'Vous devez être conecté pour pouvoir commenter un article.');
            }
        }
    }
}
