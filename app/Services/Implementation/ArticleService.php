<?php

namespace App\Services\Implementation;

use App\Models\Article;
use App\Services\IArticleService;
use Exception;

class ArticleService implements IArticleService
{
    private $articlesRepository;

    public function __construct(Article $article)
    {
        $this->articlesRepository = $article;
    }

    public function CreateArticle(array $article)
    {
        return $this->articlesRepository->create($article);
    }

    public function EditArticle(array $article)
    {
        $articleId = $article["id"];
        $articleToUpdate = $this->articlesRepository->find($articleId);
        if (!$articleToUpdate) {
            throw new Exception("There is no article stored with the id: $articleId");
        }

        $articleToUpdate->title = $article["title"];
        $articleToUpdate->content = $article["content"];
        //$articleToUpdate->user_id = $article["user_id"];
        $articleToUpdate->save();

        return $articleToUpdate;
    }

    public function DeleteArticle($articleId)
    {
        $articleToDelete = $this->articlesRepository->find($articleId);
        if (!$articleToDelete) {
            throw new Exception("There is no article stored with the id: $articleId");
        }

        $articleDeleted = $articleToDelete->toArray();
        $articleToDelete->delete();
        return $articleDeleted;
    }
}
