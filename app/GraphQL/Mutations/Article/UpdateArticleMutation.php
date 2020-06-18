<?php

namespace App\GraphQL\Mutations\Article;

use Closure;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

use App\Services\IArticleService;

class UpdateArticleMutation extends Mutation
{
    private $articleServiceRepository;

    public function __construct(IArticleService $ArticleServiceRepository)
    {
        $this->articleServiceRepository = $ArticleServiceRepository;
    }

    protected $attributes = [
        'name' => 'UpdateArticle'
    ];

    public function type(): Type
    {
        return GraphQL::type('Article');
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::int())],
            'title' => ['name' => 'title', 'type' => Type::nonNull(Type::string())],
            'content' => ['name' => 'content', 'type' => Type::nonNull(Type::string())],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'id' => ['required'],
            'title' => ['required'],
            'content' => ['required'],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->articleServiceRepository->EditArticle($args);
    }

}