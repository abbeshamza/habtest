<?php
/**
 * This file defines the Manager for the Entity ResultDetail
 *
 * @category ProjectBundle
 * @package Manager
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */

namespace ProjectBundle\Manager;
use AppBundle\Manager\BaseManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Project;
use ProjectBundle\Form\ProjectType;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Dumper;

/**
 * Class ResultDetailManager for Entity ResultDetail
 *
 * @category ProjectBundle
 * @package Manager
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */



class ResultDetailManager extends BaseManager
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
        return $this->em->getRepository('AppBundle:ResultDetail');
    }

    /**
     * Get the project Repository
     * @param $result
     * @return \Doctrine\ORM\EntityRepository
     */
    public function addResultDetail($result)
    {
        $this->persistAndFlush($result);
    }
}