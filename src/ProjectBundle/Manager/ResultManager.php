<?php
/**
 * This file defines the Manager for the Entity Result
 *
 * @category ProjectBundle
 * @package Manager
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */

namespace ProjectBundle\Manager;
use AppBundle\Entity\Result;
use AppBundle\Entity\ResultDetail;
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
 * Class ResultManager for Entity Result
 *
 * @category ProjectBundle
 * @package Manager
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */


class ResultManager extends BaseManager
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
        return $this->em->getRepository('AppBundle:Result');
    }


    /**
     * Store the results of the runned script: this will be genereted from the xml file output
     * @param Result $result
     * @return Result
     */
    public function createResult(Result $result)
    {
        $resultDetailsManger= $this->container->get('test_project.resultdetail_manager');
        $cmd= $this->container->get('core_cmd_manager');
        $nameOutput=rand(1, 3000).rand(1, 3000).rand(1, 3000).".xml";
        $path="tests/".$result->getBuild()->getProject()->getIdproject()."/testCompanies/".$result->getTestCompany()->getIdtestCompany().'   --xml "'.$nameOutput.'" ';
        $cmd->runCodeception($result->getBuild()->getProject()->getIdproject(),$path);
        $xml=simplexml_load_file($this->container->getParameter('tests_ouput_dir')."/".$nameOutput);
        $testcaseManager=$this->container->get("test_project.testcase_manager");
        foreach($xml->children() as $testsuite) {
            $result->setAssertion($testsuite['assertions']);
            $result->setError($testsuite['errors']);
            $result->setFailure($testsuite['failures']);
            $result->setTime($testsuite['time']);
            foreach($testsuite->children() as $testcase) {
                $detail= new ResultDetail();
                $detail->setTime($testcase['time']);
                $detail->setFeature($testcase['feature']);
                $detail->setAssertion($testcase['assertions']);
                $detail->setTestCase($testcaseManager-> loadTestCaseByName($testcase['name']."Cept"));
                $detail->setResult($result);
                if(count($testcase->children()->failure)>0 )
                    $detail->setStatus("Not OK");
                else
                    $detail->setStatus("OK");
                $resultDetailsManger->addResultDetail($detail);

            }
            $this->addResult($result);
        }
        return $result;

    }


    /**
     * Persisting a new Result
     * @param Result $result
     */
    public function addResult(Result $result){

        $this->persistAndFlush($result);
    }

    /**
     * Get a Result By Id
     * @param $id
     * @return null|object
     */
    public function loadResultById($id){
        return $this->getRepository()->findOneBy(array('idresultat' => $id));
    }
    /**
     * Get a Result By build and test company
     * @param $build
     * @param $company
     * @return null|object
     */
    public function loadResult($build,$company)
    {
        return $this->getRepository()->findBy(array('build' => $build,'testCompany'=>$company));

    }
}