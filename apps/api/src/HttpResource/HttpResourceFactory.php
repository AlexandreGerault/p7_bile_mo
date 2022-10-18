<?php

declare(strict_types=1);

namespace App\HttpResource;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class HttpResourceFactory
{
    public function __construct(
        private readonly NormalizerInterface $serializer,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly Security $security
    ) {
    }

    /**
     * @template T
     * @param T $entity
     * @param array{groups: mixed} $options
     * @return HttpResource
     * @throws ExceptionInterface
     */
    public function create(mixed $entity, array $options): HttpResource
    {
        /** @var array<string, string> $data */
        $data = $this->serializer->normalize($entity, 'json', ['groups' => $options['groups']]);

        $links['self'] = $this->urlGenerator->generate('api_customer_users_show', ['id' => $entity->getId()]);

        if ($this->security->isGranted('delete', $entity)) {
            $links['delete'] = $this->urlGenerator->generate('api_customer_users_delete', ['id' => $entity->getId()]);
        }

        return new HttpResource($data, $links);
    }
}
