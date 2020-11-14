<?php


namespace App\Controller;


use App\Model\ArticleManager;

class StarController
{
    public function add()
    {
        $json = file_get_contents('php://input');
        $jsonData = json_decode($json, true);
        $articleId = $jsonData['articleid'];
        $userId = $jsonData['userid'];
        $starCount = $jsonData['starcount'];
        $articleManager = new ArticleManager();
        $articleManager->addLike($articleId);
        $articleManager->selectOneById($articleId);
        $response = [
            'status' => 'success',
            'user' => $userId,
            'article' => $articleId,
            'starcount' => $starCount + 1,
        ];
        return json_encode($response);
    }
}
