<?php

namespace App\GraphQL\Mutations\Article;

use Closure;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

use App\Services\IArticleService;

class DeleteArticleMutation extends Mutation
{
    private $articleServiceRepository;

    public function __construct(IArticleService $ArticleServiceRepository)
    {
        $this->articleServiceRepository = $ArticleServiceRepository;
    }

    protected $attributes = [
        'name' => 'DeleteArticle'
    ];

    public function type(): Type
    {
        return GraphQL::type('Article');
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::int())],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'id' => ['required'],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->articleServiceRepository->DeleteArticle($args['id']);
    }
}
