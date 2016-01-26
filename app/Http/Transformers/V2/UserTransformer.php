<?php

namespace App\Http\Transformers\V2;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'posts'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'    => (int) $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'links'   => [
                [
                    'rel' => 'self',
                    'uri' => '/users/'.$user->id,
                ]
            ],
        ];
    }

    /**
     * Include Posts
     *
     * @param User $user
     * @return League\Fractal\ItemResource
     */
    public function includePosts(User $user)
    {
        $posts = $user->posts;

        return $this->collection($posts, new PostTransformer);
    }
}