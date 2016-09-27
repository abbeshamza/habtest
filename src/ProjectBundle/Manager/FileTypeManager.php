<?php
/**
 * This file defines the FileType Manager
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
use Symfony\Component\Form\Tests\Fixtures\Type;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\TypeFile;


/**
 * Class FileTypeManager
 *
 * @package Manager
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */

class FileTypeManager extends BaseManager
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
     * FileManager constructor.
     * @param EntityManager $em
     * @param $container
     */
    public function __construct(EntityManager $em, $container)
{
    $this->em = $em;
    $this->container = $container;
}

    /**
     * Get the repository of File
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
    return $this->em->getRepository('AppBundle:TypeFile');
    }

    /**
     * Get a project by ID
     * @param $type
     * @return null|object
     */
    public function loadTypeByLabel($type){
        return $this->getRepository()->findOneBy(array('label' => $type));
    }

}