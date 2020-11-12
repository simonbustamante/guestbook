<?php

namespace App\Api;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface as Hola;
use App\Entity\Comment;
use Doctrine\ORM\QueryBuilder;

class FilterPublishedCommentQueryExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    public function applyToCollection(
        QueryBuilder $qb,
        Hola $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ) {
        if (Comment::class === $resourceClass) {
            $qb->andWhere(sprintf(
                "%s.state = 'published'",
                $qb->getRootAliases()[0]
            ));
        }
    }
    public function applyToItem(QueryBuilder $qb, Hola $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        if (Comment::class === $resourceClass) {
            $qb->andWhere(sprintf(
                "%s.state = 'published'",
                $qb->getRootAliases()[0]
            ));
        }
    }
}
