<?php
/**
 * This file defines the Manager for the Entity TypeOfTest
 *
 * @category ProjectBundle
 * @package Manager
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */


namespace ProjectBundle\Manager;
use Doctrine\ORM\EntityManager;
use AppBundle\Manager\BaseManager;
use AppBundle\Entity\TypeOfTest;

/**
 * Class TypeOfTestManager
 *
 * @category ProjectBundle
 * @package Manager
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */

class TypeOfTestManager extends BaseManager
{

    /**
     * @var EntityManager The EntityManager
     */
    protected $em;
    /**
     * @var object The container
     */
    protected $container;
    /**
     * ProjectManager constructor.
     * @param EntityManager $em
     * @param $container
     */
    public function __construct(EntityManager $em, $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    /**
     * Get the project Repository
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('AppBundle:TypeOfTest');
    }


    /**
     * Get a TypeOfTest by ID
     * @param $id
     * @return null|object
     */
    public function loadTypeById($id){
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    /**
     * Get a TypeOfTest by Name
     * @param $label
     * @return null|object
     */
    public function loadTypeByLabel($label){
        return $this->getRepository()->findOneBy(array('label' => $label));
    }

    /**
     * Getting all projects
     * @return array
     */
    public function loadProjects(){
        return $this->getRepository()->findAll();
    }

    /**
     * Persisting a new typeOfTest
     * @param TypeOfTest $typeOfTest
     */
    public function addTypeOfTest(TypeOfTest $typeOfTest){

        $this->persistAndFlush($typeOfTest);
    }


}