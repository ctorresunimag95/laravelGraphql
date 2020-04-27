<?php

namespace App\GraphQL\Queries;

use App\Models\Wine;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class WinesQuery extends Query
{
    protected $attributes = [
        'name' => 'wines',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Wine'));
    }

    public function args(): array
    {
        return [
            'color' => [
                'name' => 'color',
                'type' => Type::string(),
                'rules' => []
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $where = function ($query) use ($args) {
            if (isset($args['color'])) {
                $query->where('color', $args['color']);
            }
        };

        return Wine::where($where)->get();
    }
}
