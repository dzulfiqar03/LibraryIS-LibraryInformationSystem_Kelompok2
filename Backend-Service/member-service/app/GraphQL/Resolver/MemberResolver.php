<?php

namespace App\GraphQL\Resolver;

use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

class MemberResolver
{
    /**
     * Create a new class instance.
     */
    public function all()
    {
        $user = User::with('user_detail.roles')->get();
        return [
            'user' => $user
        ];
    }

    public function find($_, array $args)
    {
        $user = $user = User::with('user_detail.roles')->findOrFail($args['id']);
        return $user;
    }
}
