<?php

namespace App\GraphQL\Queries;

use App\Models\Article;

use Closure;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class ArticleQuery extends Query
{
    protected $attributes = [
        'name' => 'articles',
        'description' => 'A query of articles'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Article'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int()
            ],
            'title' => [
                'name' => 'title',
                'type' => Type::string()
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $where = function ($query) use ($args) {
            if (isset($args['id'])) {
                $query->where('id', $args['id']);
            }

            if (isset($args['title'])) {
                $query->where('title', $args['title']);
            }
        };

        $articles = Article::with(array_keys($fields->getRelations()))
            ->where($where)
            ->select($fields->getSelect())
            ->get();

        return $articles;
    }
}
