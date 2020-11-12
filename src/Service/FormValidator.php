<?php


namespace App\Service;


use App\Model\UserManager;

class FormValidator
{
    protected $fields;
    protected $errors = [];
    protected $userManager;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
        $this->userManager = new UserManager();
    }

    public function checkFields()
    {
        foreach ($this->fields as $fieldType => $value) {
            if (empty($value)) {
                $this->addError($fieldType, 'Ce champ doit être rempli.');
            }
            if (strlen($value) > 50) {
                $this->addError($fieldType, 'Ce champ est trop long');
            }
        }
    }

    public function isUsernameValid(): bool
    {
        $check = $this->userManager->selectOneBy('username', $this->fields['username']);
        $result = false;
        if (!is_bool($check)) {
            $result = true;
        }
        return $result;
    }

    public function addError(string $fieldType, string $message)
    {
        $this->errors[$fieldType] = $message;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     * @return FormValidator
     */
    public function setFields(array $fields): FormValidator
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param mixed $errors
     * @return FormValidator
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }
}
