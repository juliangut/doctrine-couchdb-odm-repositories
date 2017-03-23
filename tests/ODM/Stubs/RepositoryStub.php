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

namespace Jgut\Doctrine\Repository\CouchDB\ODM\Tests\Stubs;

use Doctrine\ODM\CouchDB\DocumentManager;
use Jgut\Doctrine\Repository\CouchDB\ODM\CouchDBRepository;

/**
 * Repository stub.
 */
class RepositoryStub extends CouchDBRepository
{
    public function getManager(): DocumentManager
    {
        return parent::getManager();
    }
}
