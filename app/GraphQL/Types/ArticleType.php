<?php

namespace App\GraphQL\Types;

use App\Models\Article;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ArticleType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Article',
        'description' => 'Detail about article type',
        'model' => Article::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of the wine',
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of the user',
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title of article'
            ],
            'content' => [
                'type' => Type::string(),
                'description' => 'The content of article'
            ],
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'User own of article'
            ],
        ];
    }
}
