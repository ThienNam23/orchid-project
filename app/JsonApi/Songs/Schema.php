<?php

namespace App\JsonApi\Songs;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'songs';

    /**
     * @param \App\Song $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Song $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name' => $resource->name,
            'song_url' => $resource->song_url,
            'img_url' => $resource->img_url,
            'album_id' => $resource->album_id,
            'frequency' => $resource->frequency,
            'createdAt' => $resource->created_at,
            'updatedAt' => $resource->updated_at,
        ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'album' => [
                // self::SHOW_SELF => true,
                // self::SHOW_RELATED => true,
                self::DATA => function () use ($resource) {
                    return $resource->album;
                },
            ],
            'artists' => [
                // self::SHOW_SELF => true,
                // self::SHOW_RELATED => true,
                self::DATA => function () use ($resource) {
                    return $resource->artists;
                },
            ],
            'categories' => [
                // self::SHOW_SELF => true,
                // self::SHOW_RELATED => true,
                self::DATA => function () use ($resource) {
                    return $resource->categories;
                },
            ],
        ];
    }
}
