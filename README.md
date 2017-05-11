[![PHP version](https://img.shields.io/badge/PHP-%3E%3D7.0-8892BF.svg?style=flat-square)](http://php.net)
[![Latest Version](https://img.shields.io/packagist/vpre/juliangut/doctrine-couchdb-odm-repositories.svg?style=flat-square)](https://packagist.org/packages/juliangut/doctrine-couchdb-odm-repositories)
[![License](https://img.shields.io/github/license/juliangut/doctrine-couchdb-odm-repositories.svg?style=flat-square)](https://github.com/juliangut/doctrine-couchdb-odm-repositories/blob/master/LICENSE)

[![Build Status](https://img.shields.io/travis/juliangut/doctrine-couchdb-odm-repositories.svg?style=flat-square)](https://travis-ci.org/juliangut/doctrine-couchdb-odm-repositories)
[![Style Check](https://styleci.io/repos/85865731/shield)](https://styleci.io/repos/85865731)
[![Code Quality](https://img.shields.io/scrutinizer/g/juliangut/doctrine-couchdb-odm-repositories.svg?style=flat-square)](https://scrutinizer-ci.com/g/juliangut/doctrine-couchdb-odm-repositories)
[![Code Coverage](https://img.shields.io/coveralls/juliangut/doctrine-couchdb-odm-repositories.svg?style=flat-square)](https://coveralls.io/github/juliangut/doctrine-couchdb-odm-repositories)

[![Total Downloads](https://img.shields.io/packagist/dt/juliangut/doctrine-couchdb-odm-repositories.svg?style=flat-square)](https://packagist.org/packages/juliangut/doctrine-couchdb-odm-repositories)
[![Monthly Downloads](https://img.shields.io/packagist/dm/juliangut/doctrine-couchdb-odm-repositories.svg?style=flat-square)](https://packagist.org/packages/juliangut/doctrine-couchdb-odm-repositories)

# doctrine-couchdb-odm-repositories

Doctrine2 CouchDB ODM utility entity repositories

## Installation

### Composer

```
composer require juliangut/doctrine-couchdb-odm-repositories
```

## Usage

### Use repositoryClass on mapped classes

```php
/**
 * Comment CouchDB document.
 *
 * @ODM\Document(repositoryClass="\Jgut\Doctrine\Repository\CouchDBRepository")
 */
class Comment
{
}
```

### Register factory on managers

When creating object managers you can set a repository factory to create default repositories such as follows

```php
use Jgut\Doctrine\ManagerBuilder\CouchDB\DocumentManager;
use Jgut\Doctrine\Repository\Factory\CouchDBRepositoryFactory;

$documentManager = DocumentManager::create([], new \Doctrine\ODM\CouchDB\Configuration);
$documentManager->setRepositoryFactory(new CouchDBRepositoryFactory);
```

> For an easier way of registering repository factories and managers generation in general have a look at [juliangut/doctrine-manager-builder](https://github.com/juliangut/doctrine-manager-builder)

## Functionalities

Head to [juliangut/doctrine-base-repositories](https://github.com/juliangut/doctrine-base-repositories) for a list of new methods provided by the repository

## Performance

Due to the lack of a Query Builder such as the ones present in Doctrine ORM and Doctrine MongoDB ODM the paginating and counting operations are vastly inefficient as they need the whole set loaded in memory

## Contributing

Found a bug or have a feature request? [Please open a new issue](https://github.com/juliangut/doctrine-couchdb-odm-repositories/issues). Have a look at existing issues before.

See file [CONTRIBUTING.md](https://github.com/juliangut/doctrine-couchdb-odm-repositories/blob/master/CONTRIBUTING.md)

## License

See file [LICENSE](https://github.com/juliangut/doctrine-couchdb-odm-repositories/blob/master/LICENSE) included with the source code for a copy of the license terms.
