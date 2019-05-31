<?php

declare(strict_types=1);

namespace Rebing\GraphQL\Tests\Support\Queries;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Tests\Support\Models\Post;

class PostsNonNullAndListAndNonNullOfWithSelectFieldsAndModelQuery extends Query
{
    protected $attributes = [
        'name' => 'postsNonNullAndListAndNonNullOfWithSelectFieldsAndModel',
    ];

    public function type()
    {
        return Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('PostWithModel'))));
    }

    public function resolve($root, $args, SelectFields $selectFields)
    {
        return Post
            ::select($selectFields->getSelect())
            ->get();
    }
}
