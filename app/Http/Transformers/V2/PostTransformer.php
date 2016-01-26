<?php

namespace App\Http\Transformers\V2;

use App\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'user'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @param Post $post
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'id'    => (int) $post->id,
            'name'  => $post->name,
            'slug'  => $post->slug,
            'body'  => $post->body,
            'links'   => [
                [
                    'rel' => 'self',
                    'uri' => '/posts/'.$post->id,
                ]
            ],
        ];
    }

    /**
     * Include Posts
     *
     * @param Post $post
     * @return League\Fractal\ItemResource
     */
    public function includeUser(Post $post)
    {
        $user = $post->user;

        return $this->item($user, new UserTransformer);
    }
}