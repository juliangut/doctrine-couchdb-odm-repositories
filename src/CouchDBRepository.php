<?php

/*
 * doctrine-couchdb-odm-repositories (https://github.com/juliangut/doctrine-couchdb-odm-repositories).
 * Doctrine2 CouchDB ODM utility entity repositories.
 *
 * @license MIT
 * @link https://github.com/juliangut/doctrine-couchdb-odm-repositories
 * @author Julián Gutiérrez <juliangut@gmail.com>
 */

declare(strict_types=1);

namespace Jgut\Doctrine\Repository\CouchDB\ODM;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\ODM\CouchDB\DocumentManager;
use Doctrine\ODM\CouchDB\DocumentRepository;
use Jgut\Doctrine\Repository\EventsTrait;
use Jgut\Doctrine\Repository\PaginatorTrait;
use Jgut\Doctrine\Repository\Repository;
use Jgut\Doctrine\Repository\RepositoryTrait;
use Zend\Paginator\Paginator;

/**
 * CouchDB document repository.
 */
class CouchDBRepository extends DocumentRepository implements Repository
{
    use RepositoryTrait;
    use EventsTrait;
    use PaginatorTrait;

    /**
     * {@inheritdoc}
     */
    public function getClassName(): string
    {
        return ClassUtils::getRealClass(parent::getClassName());
    }

    /**
     * {@inheritdoc}
     */
    protected function getManager(): DocumentManager
    {
        return $this->getDocumentManager();
    }

    /**
     * {@inheritdoc}
     *
     * @param array $criteria
     * @param array $orderBy
     * @param int   $itemsPerPage
     *
     * @return \Zend\Paginator\Paginator
     */
    public function findPaginatedBy($criteria, array $orderBy = [], int $itemsPerPage = 10): Paginator
    {
        if (!is_array($criteria)) {
            $criteria = [$criteria];
        }

        $adapter = new CouchDBPaginatorAdapter($this->findBy($criteria, $orderBy));

        return $this->getPaginator($adapter, $itemsPerPage);
    }

    /**
     * {@inheritdoc}
     *
     * @param array $criteria
     *
     * @return int
     */
    public function countBy($criteria): int
    {
        return count($this->findBy($criteria));
    }
}
