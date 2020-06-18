<?php

namespace App\GraphQL\Mutations\User;

use Closure;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

use App\Services\IUserService;

class DeleteUserMutation extends Mutation
{
    private $userServiceRepository;

    public function __construct(IUserService $userServiceRepository)
    {
        $this->userServiceRepository = $userServiceRepository;
    }

    protected $attributes = [
        'name' => 'DeleteUser'
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
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
        return $this->userServiceRepository->DeleteUser($args['id']);
    }
}
