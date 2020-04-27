<?php

namespace App\GraphQL\Types;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'Detail about user type',
        'model' => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of the wine',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the wine',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of user'
            ],
            'articles' => [
                'type' => Type::listOf(GraphQL::type('Article')),
                'description' => 'Articles from the user',
                'args'          => [
                    'title' => [
                        'type' => Type::string(),
                    ],
                ],
                'resolve' => function ($root, $args) {
                    $where = function ($query) use ($args) {
                        if (isset($args['title'])) {
                            $query->where('title', 'like', '%' . $args['title'] . '%');
                        }
                    };

                    return $root
                        ->articles()
                        ->where($where)
                        ->get();
                }
            ],
        ];
    }
}
