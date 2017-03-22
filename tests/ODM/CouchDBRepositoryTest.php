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

use Doctrine\ODM\CouchDB\DocumentManager;
use Doctrine\ODM\CouchDB\Mapping\ClassMetadata;
use Jgut\Doctrine\Repository\CouchDB\ODM\CouchDBRepository;
use Jgut\Doctrine\Repository\CouchDB\ODM\Tests\Stubs\DocumentStub;
use Jgut\Doctrine\Repository\CouchDB\ODM\Tests\Stubs\RepositoryStub;
use PHPUnit\Framework\TestCase;
use Zend\Paginator\Paginator;

/**
 * CouchDB repository tests.
 */
class CouchDBRepositoryTest extends TestCase
{
    public function testDocumentName()
    {
        $manager = $this->getMockBuilder(DocumentManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        /* @var DocumentManager $manager */

        $repository = new CouchDBRepository($manager, new ClassMetadata(DocumentStub::class));

        static::assertEquals(DocumentStub::class, $repository->getClassName());
    }

    public function testDocumentManager()
    {
        $manager = $this->getMockBuilder(DocumentManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        /* @var DocumentManager $manager */

        $repository = new RepositoryStub($manager, new ClassMetadata(DocumentManager::class));

        static::assertSame($manager, $repository->getManager());
    }

    public function testFindPaginated()
    {
        $manager = $this->getMockBuilder(DocumentManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        /* @var DocumentManager $manager */

        $repository = $this->getMockBuilder(CouchDBRepository::class)
            ->setConstructorArgs([$manager, new ClassMetadata(DocumentStub::class)])
            ->setMethodsExcept(['findPaginatedBy'])
            ->getMock();
        $repository->expects(static::once())
            ->method('findBy')
            ->will(static::returnValue(['a', 'b']));
        /* @var CouchDBRepository $repository */

        static::assertInstanceOf(Paginator::class, $repository->findPaginatedBy(''));
    }

    public function testCount()
    {
        $manager = $this->getMockBuilder(DocumentManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        /* @var DocumentManager $manager */

        $repository = $this->getMockBuilder(CouchDBRepository::class)
            ->setConstructorArgs([$manager, new ClassMetadata(DocumentStub::class)])
            ->setMethodsExcept(['countBy'])
            ->getMock();
        $repository->expects(static::once())
            ->method('findBy')
            ->will(static::returnValue(['a', 'b']));
        /* @var CouchDBRepository $repository */

        static::assertEquals(2, $repository->countBy([]));
    }
}
