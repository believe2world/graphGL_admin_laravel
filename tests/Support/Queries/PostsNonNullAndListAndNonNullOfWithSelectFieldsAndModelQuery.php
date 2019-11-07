<?php

declare(strict_types=1);

namespace Rebing\GraphQL\Tests\Support\Queries;

use Closure;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Tests\Support\Models\Post;

class PostsNonNullAndListAndNonNullOfWithSelectFieldsAndModelQuery extends Query
{
    protected $attributes = [
        'name' => 'postsNonNullAndListAndNonNullOfWithSelectFieldsAndModel',
    ];

    public function type(): Type
    {
        return Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('PostWithModel'))));
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Post
            ::select($getSelectFields()->getSelect())
            ->get();
    }
}
