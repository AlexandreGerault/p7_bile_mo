<?php

declare(strict_types=1);

namespace App\HttpResource;

class CustomerUserResource
{
    /**
     * @param array<string, string> $data
     * @param array<string, array{url: string}> $links
     * @param array<string, string> $embedded
     */
    public function __construct(
        public readonly array $data,
        public readonly array $links = [],
        public readonly array $embedded = []
    ) {
    }
}
