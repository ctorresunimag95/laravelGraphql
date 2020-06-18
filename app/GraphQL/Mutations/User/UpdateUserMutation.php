<?php

namespace App\GraphQL\Mutations\User;

use Closure;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

use App\Services\IUserService;

class UpdateUserMutation extends Mutation
{
    private $userServiceRepository;

    public function __construct(IUserService $UserServiceRepository)
    {
        $this->userServiceRepository = $UserServiceRepository;
    }

    protected $attributes = [
        'name' => 'UpdateUser'
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::int())],
            'name' => ['name' => 'name', 'type' => Type::nonNull(Type::string())],
            'email' => ['name' => 'email', 'type' => Type::nonNull(Type::string())],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'id' => ['required'],
            'name' => ['required'],
            'email' => ['required', 'email'],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->userServiceRepository->EditUser($args);
    }
}
