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

namespace Jgut\Doctrine\Repository\CouchDB\ODM\Tests;

use Doctrine\ODM\CouchDB\Mapping\ClassMetadata;
use Jgut\Doctrine\ManagerBuilder\CouchDB\DocumentManager;
use Jgut\Doctrine\Repository\CouchDB\ODM\CouchDBRepository;
use Jgut\Doctrine\Repository\CouchDB\ODM\CouchDBRepositoryFactory;
use PHPUnit\Framework\TestCase;

/**
 * CouchDB repository factory tests.
 */
class CouchDBRepositoryFactoryTest extends TestCase
{
    public function testCount()
    {
        $classMetadata = new ClassMetadata('RepositoryDocument');

        $manager = $this->getMockBuilder(DocumentManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $manager->expects(static::any())
            ->method('getClassMetadata')
            ->will(static::returnValue($classMetadata));
        /* @var DocumentManager $manager */

        $factory = new CouchDBRepositoryFactory();

        $repository = $factory->getRepository($manager, 'RepositoryEntity');

        static::assertInstanceOf(CouchDBRepository::class, $repository);
        static::assertEquals($repository, $factory->getRepository($manager, 'RepositoryEntity'));
    }
}
