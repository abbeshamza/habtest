<?php
/**
 * This file defines the Manager for the Entity TestCase
 *
 * @category ProjectBundle
 * @package Manager
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */


namespace ProjectBundle\Manager;
use AppBundle\Entity\TestBooklet;
use AppBundle\Entity\TestCase;
use Doctrine\ORM\EntityManager;
use AppBundle\Manager\BaseManager;


/**
 * Class TestCaseManager
 *
 * @category ProjectBundle
 * @package Manager
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */

class TestCaseManager extends BaseManager
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
        return $this->em->getRepository('AppBundle:TestCase');
    }


    /**
     *  Persisting a new test case
     * @param TestBooklet $testBooklet
     * @param $name
     * @return TestCase
     */
    public function addTestCase(TestBooklet $testBooklet , $name){

        $testcase = new TestCase();
        $testcase->setTestBooklet($testBooklet);
        $testcase->setName($name);
        $this->persistAndFlush($testcase);
        return $testcase ;
    }
    /**
     *  Persisting a new test case
     * @param TestBooklet $testBooklet
     * @param $name
     * @return TestCase
     */
    public function updateTestCase(TestBooklet $testBooklet , $name){

        $testcase = new TestCase();
        $testcase->setTestBooklet($testBooklet);
        $testcase->setName($name);
        $this->persistAndFlush($testcase);
        return $testcase ;
    }


    /**
     * Change the importation path of the php files
     * @param TestCase $file
     * @param $folder
     * @param @type
     */
    public function changeNamespace(TestCase $file,$folder,$type)
    {
       $contenu = "";
        $document = fopen($this->container->getParameter('tests_dir').'/'.$file->getTestBooklet()->getProject()->getIdproject().'/'.$folder.'/'.$file->getTestBooklet()->getName().'/'.$file->getName().'.php', "r+");
        while (!feof($document)) {
            $line = fgets($document);
            if (substr_count($line,"use") >0 && strpos($line,"use")==0) {
                if (strpos($line, "Codeception") !== false) {
                } else {
                    $tab = explode('\\', $line);
                    $line = "use project" . $file->getTestBooklet()->getProject()->getIdproject() . "\\" . $type . "\\" . $tab[count($tab) - 1] . "\n";
                }
            }
            $contenu = $contenu . $line;
        }
        fclose($document);
        file_put_contents($this->container->getParameter('tests_dir').'/'.$file->getTestBooklet()->getProject()->getIdproject().'/'.$folder.'/'.$file->getTestBooklet()->getName().'/'.$file->getName().'.php', $contenu);


    }


    /**
     * Get a TestCase By Id
     * @param $id
     * @return null|object
     */
    public function loadTestCaseById($id){
        return $this->getRepository()->findOneBy(array('idtestCase' => $id));
    }



    /**
     * Get a TestCase By Name
     * @param $name
     * @return null|object
     */
    public function loadTestCaseByName($name){
        return $this->getRepository()->findOneBy(array('name' => $name));
    }

    /**
     * Get a TestCase By Name and Project
     * @param $name
     * @param $testBooklet
     * @return null|object
     * @aram $testBooklet
     */
    public function loadTestCaseByNameAndProject($name,$testBooklet){
        return $this->getRepository()->findOneBy(array('name' => $name,'testBooklet'=>$testBooklet));
    }

    /**
     * Get TestCases
     * @return null|object
     */
    public function loadTestCases(){
        return $this->getRepository()->findAll();
    }

    /**
     * Disable a TestCases
     * @param $testCase
     * @return null|object
     */
    public function disableTestCases($testCase){
        $testCase->setIsDisabled("1");
        $this->flush();
        return $testCase;
    }


    /**
     * Enable a TestCases
     * @param $testCase
     * @return null|object
     */
    public function enableTestCases($testCase){

        $testCase->setIsDisabled("0");
        $this->flush();
        return $testCase;
    }

    /**
     * Enable a TestCases
     * @param $testCase
     * @return null|object
     */
    public function deleteTestCases($testCase){
        if ( $testCase->getTestCompany() !== null)
        {
            $testCase->setIsDeleted("1");
            $this->flush();
            return true;
        }
        return false;
    }


}