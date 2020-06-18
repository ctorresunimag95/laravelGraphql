<?php

namespace App\GraphQL\Mutations\User;

use Closure;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

use App\Services\IUserService;

class CreateUserMutation extends Mutation
{
    private $userServiceRepository;

    public function __construct(IUserService $userServiceRepository)
    {
        $this->userServiceRepository = $userServiceRepository;
    }

    protected $attributes = [
        'name' => 'CreateUser'
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'name' => ['name' => 'name', 'type' => Type::nonNull(Type::string())],
            'email' => ['name' => 'email', 'type' => Type::nonNull(Type::string())],
            'password' => ['name' => 'password', 'type' => Type::nonNull(Type::string())]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required']
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->userServiceRepository->CreateUser($args);
    }
}
