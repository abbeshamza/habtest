<?php
/**
 * This file defines the Manager for the Entity TestBooklet
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
use AppBundle\Entity\TestBooklet;
use AppBundle\Entity\TypeOfTest;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Project;

/**
 * Class TestBookletManager for Entity TestBooklet
 *
 * @category ProjectBundle
 * @package Manager
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */

class TestBookletManager extends BaseManager
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
        return $this->em->getRepository('AppBundle:TestBooklet');
    }


    /**
     * Get a TestBooklet by ID
     * @param $id
     * @return null|object
     */
    public function loadTestBookletById($id){
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    /**
     * Get a TestBooklet by Name
     * @param $label
     * @return null|object
     * @internal param $name
     */
    public function loadTestBookletByName($label){
        return $this->getRepository()->findOneBy(array('label' => $label));
    }

    /**
     * Getting all TestBooklets
     * @return array
     */
    public function loadTestBooklets(){
        return $this->getRepository()->findAll();
    }

    /**
     * Persisting a new TestBooklet
     * @param TestBooklet $testBooklet
     */
    public function addTestBooklet(TestBooklet $testBooklet){

        $this->persistAndFlush($testBooklet);
    }

    /**
     * Create a TestBooklets from the folder the type will be by default functional
     * @param Project $project
     * @return boolean
     */
    public function addTestBookletFromFolder(Project $project)
    {
        $path =$this->container->getParameter('tests_dir').'/'.$project->getIdproject().'/scripts';
        if( file_exists($path))
        {
            $testcaseManager=$this->container->get("test_project.testcase_manager");
            $files = array_diff(scandir($path), array('..', '.'));
            foreach ($files as $i)
            {
                $object = $this->addTestBookletoDataBase($project,$i,"functional");
                $scripts = array_diff(scandir($path."/".$i), array('..', '.'));

                foreach ($scripts as $j)
                {
                    $tab = explode('.',$j);
                    $testcase=$testcaseManager->addTestCase($object,$tab[0]);
                    $object->addTestCase($testcase);
                    $testcaseManager->changeNamespace($testcase,"scripts","controllers");

                }
            }
            return true;

        }

        return false;
    }





    /**
     * Create a TestBooklets from the folder the type will be by default functional
     * @param Project $project
     * @return boolean
     */
    public function updateTestBookletFromFolder(Project $project)
    {
        $cmd=$this->container->get('core_cmd_manager');
        $path =$this->container->getParameter('projects_upload_dir').'/'.$project->getIdproject().'/scripts';
        if( file_exists($path))
        {
            $testcaseManager=$this->container->get("test_project.testcase_manager");
            $files = array_diff(scandir($path), array('..', '.'));
            foreach ($files as $i)
            {
                $destination=$this->container->getParameter('tests_dir').'/'.$project->getIdproject().'/scripts';
                $object=$this->loadTestBookletByProjectAndName($project,$i);
                if(  $object== null)
                {
                    $object = $this->addTestBookletoDataBase($project,$i,"functional");
                    $cmd->createFolder($destination,$i);
                }
                $scripts = array_diff(scandir($path."/".$i), array('..', '.'));
                foreach ($scripts as $j)
                {
                    $tab = explode('.',$j);
                    $cmd->copy($path.'/'.$i.'/'.$j,$destination.'/'.$i.'/'.$j);
                    $testcase=$testcaseManager->loadTestCaseByNameAndProject($tab[0],$object);
                    if($testcase == null)
                    {
                        $testcase=$testcaseManager->addTestCase($object,$tab[0]);
                        $object->addTestCase($testcase);
                    }
                    $testcaseManager->changeNamespace($testcase,"scripts","controllers");

                }
            }
            return true;

        }

        return false;
    }





    /**
     *  Create a new TestBooklet and add it to the database
     * @param Project $project
     * @param $name
     * @param $typeOfTest
     * @return TestBooklet
     */
    public function addTestBookletoDataBase(Project $project, $name, $typeOfTest)
    {
        $testBooklet = new TestBooklet();
        $testBooklet->setName($name);
        $testBooklet->setProject($project);
        $typeOfTestManager= $this->container->get("test_project.typeoftest_manager");
        $testBooklet->setTypeoftest($typeOfTestManager->loadTypeByLabel($typeOfTest));
        $this->persistAndFlush($testBooklet);
        $project->addAllTestBooklet($testBooklet);
        return $testBooklet ;
    }

    /**
     *  Load testBooklets by name and by project
     * @param Project $project
     * @param $name
     * @return TestBooklet
     */
    public function loadTestBookletByProjectAndName(Project $project, $name)
    {
        return $this->getRepository()->findOneBy(array('name' => $name,'project'=>$project));
    }

    /**
     * Disable a TestBooklet
     * @param $testBooklet
     * @return null|object
     */
    public function disableTestBooklet($testBooklet){
        $testBooklet->setIsDisabled("1");
        $this->flush();
        return $testBooklet;
    }


    /**
     * Enable a TestBooklet
     * @param $testBooklet
     * @return null|object
     */
    public function enableTestBooklet($testBooklet){
        $testBooklet->setIsDisabled("0");
        $this->flush();
        return $testBooklet;
    }


}