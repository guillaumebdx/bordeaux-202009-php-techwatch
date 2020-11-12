<?php


namespace App\Controller;


use App\Model\ArticleManager;

class StarController
{
    public function add()
    {
        $json = file_get_contents('php://input');
        $jsonData = json_decode($json, true);
        $articleId = $jsonData['cheatsheet'];
        $userId = $jsonData['userid'];
        $articleManager = new ArticleManager();
        $articleManager->addLike($articleId);
        $response = [
            'status' => 'success',
            'user' => $userId,
            'cheat' => $articleId,
        ];
        return json_encode($response);
    }
}