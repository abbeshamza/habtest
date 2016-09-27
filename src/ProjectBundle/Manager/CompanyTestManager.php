<?php
/**
 * This file defines the Manager for the CompanyTestManager
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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Build;
use AppBundle\Entity\TestCompany;
use AppBundle\Core\CmdShell;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Class CompanyTestManager for Entity CompanyTest
 *
 * @category ProjectBundle
 * @package Manager
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */

class CompanyTestManager extends BaseManager
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
        return $this->em->getRepository('AppBundle:TestCompany');
    }
    /**
     * Create a new Test Company : add testCOmpany to DB then create testCompanies in the project folder with symbolic link for testCases
     * @param TestCompany $company
     */
    public function addCompany(TestCompany $company){
        $this->persistAndFlush($company);
        $testCases=$company->getTestCase();
        $array=$testCases->toArray();
        $project=$array[0]->getTestBooklet()->getProject()->getIdproject();
        $cmdManager=$this->container->get("core_cmd_manager");
        $cmdManager->createFolder($company->getIdtestCompany(),$this->container->getParameter("tests_dir")."/".$project."/testCompanies");
        $path=$this->container->getParameter("tests_dir")."/".$project."/testCompanies/".$company->getIdtestCompany()."/";
        //create sumbolic link for test cases
        for ($i=0;$i<count($array);$i++)
        {
            $target = $this->container->getParameter("tests_dir")."/".$project."/scripts/".$array[$i]->getTestBooklet()->getName()."/".$array[$i]->getName().".php";
            $destination=$path.$array[$i]->getName().".php";
            symlink($target,$destination);
        }
    }
    /**
     * Get a TestCompany By Id
     * @param $id
     * @return null|object
     */
    public function getCompany($id)
    {
        return $this->getRepository()->findOneBy(array('idtestCompany' => $id));
    }
    /**
     * Get a TestCompany By project , it will scan the project Directory to get TestCompanies ID then load them from Database, if the project Id don't much to any project it will return false
     * @param $idproject Id of the project
     * @return boolean TestCompanies of the selected project
     */

    public function getCompaniesByProject($idproject)
    {
        $projectManager= $this->container->get('test_project.project_manager');
        $project = $projectManager->loadProjectById($idproject);
        if(count($project)>0)
        {
            $directories=scandir($this->container->getParameter("tests_dir")."/".$idproject."/testCompanies");
            $result= new ArrayCollection();
            for ($i=2;$i<count($directories);$i++)
            {
                $result->add($this->getCompany($directories[$i]));
            }
            return $result;
        }
        else
            return false ;
    }
    /**
     * Get a test company By Id
     * @param $id Id of the testCompany
     * @return null|object A testCompany if exists
     */
    public function loadCompanyById($id){
        return $this->getRepository()->findOneByIdtestCompany($id);//(array('idtestCompany' => $id));
    }
    /**
     * Get the List Of test companies
     * @return array  List of the testCompanies
     */
    public function loadCompanies(){
        return $this->getRepository()->findBy(array('isDeleted' => 0));
    }
    /**
     * Delete a specific test company
     * @param $id Id of the testCompany
     * @return boolean The result of the operation
     */
    public function deleteCompany($id){
        $company=$this->getRepository()->findOneByIdtestCompany($id);
        $company->setIsDeleted("1");
        $this->flush();
        return true;
    }
}