<?php
/**
 * This file defines the Build Manager
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
use AppBundle\Entity\Project;
use AppBundle\Entity\Build;
use ProjectBundle\Form\ProjectType;
use AppBundle\Core\ApiException;
use AppBundle\Core\CmdShell;

/**
 * Class BuildManager
 *
 * @package Manager
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */

class BuildManager extends BaseManager
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
     * BuildManager constructor.
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
        return $this->em->getRepository('AppBundle:Build');
    }

    /**
     * Function to Validate a Build
     * @param Build $build
     * @return bool
     */
    public  function buildValidation(Build $build)
    {
        $validator = $this->container->get('validator');
        $errors = $validator->validate($build);
        if (count($errors) > 0)
        {
            return false ;
        }
        else
            return true ;
    }

    /**
     * Create a new build based on request
     * @param Request $req
     * @return Build
     */
    public function createBuildFromRequest(Request $req)
    {

        $json = $req->getContent();
        $serializer = $this->container->get('serializer');
        $build=$serializer->deserialize(
            $json,
            'AppBundle\Entity\Build',
            'json'
        );
        $project=$build->getProject()->getIdproject();
        $build->setProject($this->container->get('test_project.project_manager')->loadProjectById($project));
        $build->setIsDeleted("0");
        return $build;


    }

    /**
     * Get a Build By Id
     * @param $id
     * @return null|object
     */
    public function loadBuildById($id){
        return $this->getRepository()->findOneBy(array('idbuild' => $id,'isDeleted' => 0));
    }

    /**
     * Load a Build by Name
     * @param $name
     * @return null|object
     */
    public function loadBuildByName($name){
        return $this->getRepository()->findOneBy(array('name' => $name,'isDeleted' => 0));
    }

    /**
     * Get the List Of Builds
     * @return array
     */
    public function loadBuilds(){
        return $this->getRepository()->findBy(array('isDeleted' => 0));
    }


    /**
     * Get the List of builds for a specific project
     * @param Request $req
     * @return mixed
     */
    public function loadBuildsByProject(Request $req){
        $id=$req->get('project');
        $projectManager = $this->container->get('test_project.project_manager');
        $project = $projectManager->loadProjectById($id);
        return $this->getRepository()->findBy(array('project'=>$project,'isDeleted' => 0));
    }

    /**
     * Create a new Build
     * @param Build $build
     */
    public function addBuild(Build $build){
        $this->persistAndFlush($build);

    }


    /**
     * Add test companies to specific build
     * @param $id
     * @param $params
     * @return Build|null|object
     */
    public function addCompanies($id , $params)
    {

        $build = $this->loadBuildById($id);
        if($build === null )
            throw new ApiException(400101);

        $testCompanyManager = $this->container->get('test_project.testcompany_manager');
        for($i=0;$i<count($params);$i++)
        {
            $company =$testCompanyManager->loadCompanyById($params[$i]);
            if ($company === null)
                throw new ApiException(400200);
            if(!$build->getTestCompany()->contains($company))
            $build->addTestCompany($company);

        }
        $this->em->flush();
        return $build;
    }
    /**
     * Deleting a Build
     * @param  $id
     * @return bool
     */
    public function deleteBuild($id)

    {
         $build= $this->loadBuildById($id);

        if($build == null)
            return false ;
        else
        {
            $build->setIsDeleted("1");
            $projectManager = $this->container->get('test_project.project_manager');
            $projectManager->removeBuild( $build->getProject(),$build);
            return true;
        }
    }
    /**
     * Delete a test company from to specific build
     * @param $idBuild Id of the build
     * @param $idCompany Id of the testComapny
     * @return Build|null|object
     */
    public function deleteComapny($idBuild,$idCompany)
    {
        $build = $this->loadBuildById($idBuild);
        if($build === null )
            throw new ApiException(400101);
        $testCompanyManager = $this->container->get('test_project.testcompany_manager');
        $company =$testCompanyManager->loadCompanyById($idCompany);
        $build->removeTest($company);
        $this->em->flush();
        return $build;

    }


}