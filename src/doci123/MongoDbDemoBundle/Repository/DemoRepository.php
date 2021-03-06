<?php

namespace doci123\MongoDbDemoBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * DemoRepository
 *
 * This class was generated by the Doctrine ODM. Add your own custom
 * repository methods below.
 */
class DemoRepository extends DocumentRepository
{

    /**
     * @param int $limit
     * @return \Doctrine\ODM\MongoDB\Cursor
     *
     * @TODO Id field wrong format
     */
    public function findAll ( $limit = 20)
    {
        $qb = $this->createQueryBuilder();

        return $qb
            //->eagerCursor(false)
            ->hydrate(false) // getXXX
            ->limit($limit)
            //->skip(40)
            ->sort('name', 'ASC')
            ->getQuery()
            ->execute();
    }

}
