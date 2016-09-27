<?php
/**
 * This file defines the BaseManager
 *
 * @category AppBundle
 * @package Manager
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */
namespace AppBundle\Manager;
/**
 * Class BaseManager
 *
 * @package Manager
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */

abstract class BaseManager
{

    /**
     * Persist and flush Data into Database
     * @param $entity
     */
    public function persistAndFlush($entity)
    {
        $this->persist($entity);
        $this->flush();
    }

    /**
     * Delete Data from dataBase
     * @param $entity
     */
    public function removeAndFlush($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * Persist Data
     * @param $entity
     */
    public function persist($entity)
    {
        $this->em->persist($entity);
    }

    /**
     * Flush
     */
    public function flush()
    {
        $this->em->flush();
    }

    /**
     * GetRepository
     * @return mixed
     */
    abstract protected function getRepository();
}

?>
