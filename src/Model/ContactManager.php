<?php


namespace App\Model;


class ContactManager extends AbstractManager
{

    const TABLE = 'contact';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function fillContactForm()
    {
        echo 'HELLO';
    }
}
