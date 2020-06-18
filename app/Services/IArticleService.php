<?php

namespace App\Services;


interface IArticleService
{
    public function CreateArticle(array $article);
    public function EditArticle(array $article);
    public function DeleteArticle($articleId);
}
