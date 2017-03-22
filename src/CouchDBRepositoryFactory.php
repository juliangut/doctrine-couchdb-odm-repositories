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

use Jgut\Doctrine\ManagerBuilder\CouchDB\DocumentManager;
use Jgut\Doctrine\ManagerBuilder\CouchDB\Repository\RepositoryFactory;

/**
 * Default CouchDB document repository factory.
 */
class CouchDBRepositoryFactory implements RepositoryFactory
{
    /**
     * Default repository class.
     *
     * @var string
     */
    protected $repositoryClassName;

    /**
     * The list of EntityRepository instances.
     *
     * @var \Doctrine\Common\Persistence\ObjectRepository[]
     */
    private $repositoryList = [];

    /**
     * RelationalRepositoryFactory constructor.
     */
    public function __construct()
    {
        $this->repositoryClassName = CouchDBRepository::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository(DocumentManager $documentManager, $documentName)
    {
        $repositoryHash =
            $documentManager->getClassMetadata($documentName)->getName() . spl_object_hash($documentManager);

        if (array_key_exists($repositoryHash, $this->repositoryList)) {
            return $this->repositoryList[$repositoryHash];
        }

        $this->repositoryList[$repositoryHash] = $this->createRepository($documentManager, $documentName);

        return $this->repositoryList[$repositoryHash];
    }

    /**
     * Create a new repository instance for a document class.
     *
     * @param DocumentManager $documentManager
     * @param string          $documentName
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function createRepository(DocumentManager $documentManager, $documentName)
    {
        /* @var $metadata \Doctrine\ODM\CouchDB\Mapping\ClassMetadata */
        $metadata = $documentManager->getClassMetadata($documentName);
        $repositoryClassName = $metadata->customRepositoryClassName ?: $this->repositoryClassName;

        return new $repositoryClassName($documentManager, $metadata);
    }
}
