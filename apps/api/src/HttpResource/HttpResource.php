<?php

declare(strict_types=1);

namespace App\HttpResource;

class HttpResource
{
    /**
     * @param array<string, string> $data
     * @param array<string, string> $links
     * @param array<string, mixed> $embedded
     */
    public function __construct(
        public readonly array $data,
        public readonly array $links = [],
        public readonly array $embedded = []
    ) {
    }
}
