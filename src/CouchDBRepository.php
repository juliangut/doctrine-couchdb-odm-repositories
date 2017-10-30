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
use Jgut\Doctrine\Repository\FiltersTrait;
use Jgut\Doctrine\Repository\PaginatorTrait;
use Jgut\Doctrine\Repository\Repository;
use Jgut\Doctrine\Repository\RepositoryTrait;
use Zend\Paginator\Paginator;

/**
 * CouchDB document repository.
 */
class CouchDBRepository extends DocumentRepository implements Repository
{
    use RepositoryTrait {
        refresh as baseRefresh;
    }
    use EventsTrait;
    use FiltersTrait;
    use PaginatorTrait;

    /**
     * Class name.
     *
     * @var string
     */
    protected $className;

    /**
     * {@inheritdoc}
     */
    public function getClassName(): string
    {
        if ($this->className === null) {
            $this->className = ClassUtils::getRealClass($this->getDocumentName());
        }

        return $this->className;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \LogicException
     */
    protected function getFilterCollection()
    {
        throw new \LogicException('Doctrine\'s CouchDB manager does not implement filters');
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
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int        $itemsPerPage
     *
     * @return \Zend\Paginator\Paginator
     */
    public function findPaginatedBy($criteria, array $orderBy = null, int $itemsPerPage = 10): Paginator
    {
        if (!is_array($criteria)) {
            $criteria = [$criteria];
        }

        return $this->paginate($this->findBy($criteria, $orderBy));
    }

    /**
     * Paginate CouchDB results.
     *
     * @param array $results
     * @param int   $itemsPerPage
     *
     * @return Paginator
     */
    protected function paginate(array $results, int $itemsPerPage = 10): Paginator
    {
        return $this->getPaginator(new CouchDBPaginatorAdapter($results), $itemsPerPage);
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

    /**
     * Flush managed object.
     *
     * @param object|object[]|\Traversable $objects
     * @param bool                         $flush
     *
     * @SuppressWarnings(PMD.UnusedFormalParameter)
     */
    protected function flushObjects($objects, bool $flush)
    {
        if ($flush || $this->autoFlush) {
            $this->getManager()->flush();
        }
    }
}
