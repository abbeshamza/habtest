<?php
/**
 * This file defines the Manager for the Entity Project
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
use AppBundle\Core\ApiException;

/**
 * Class ProjectManager for Entity Project
 *
 * @category ProjectBundle
 * @package Manager
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */

class ProjectManager extends BaseManager
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
        return $this->em->getRepository('AppBundle:Project');
    }

    /**
     * Create a project from a request
     * @param Request $req
     * @return Project
     */
    public function createProjectFromRequest(Request $req)
    {
        $entity = new Project();
        $entity->setName($req->get('name'));
        $entity->setDescription($req->get('description'));
        $entity->setUrl($req->get('url'));
        if($this->loadProjetByName($entity->getName()) != null)
            throw new ApiException(4000);
        return $entity;
    }

    /**
     * Upload the zip file from the request then extract files , after that it will remove the zip file.
     * @param Request $req
     * @param Project $project
     * @return object|boolean
     */
    public function uploadProjectFromZip(Request $req , Project $project)
    {
        $file = $req->files->get('file');
        if($file !== null)
        {
            //change the uploaded zip file name to the id of the project id
            $fileName = $project->getIdproject().'.'.$file->guessExtension();
            $projectsDir = $this->container->getParameter('projects_upload_dir');
            // move the file from the tmp to the upload directory
            $file->move($projectsDir, $fileName);
            $cmd=$this->container->get('core_cmd_manager');
            $cmd->unzipCmd($projectsDir.'/'.$fileName,$projectsDir.'/'.$project->getIdproject());
            $cmd->delete($projectsDir.'/'.$fileName);
            // delete files and directory that not much with the default directory
            $path =$projectsDir.'/'.$project->getIdproject();
            $files = array_diff(scandir($path), array('..', '.','scripts','controllers','pages','_bootstrap.php'));
            foreach ($files as $i)
            {
                if(is_dir($path.'/'.$i))
                    $cmd->delete($path.'/'.$i.'/', '-rf ');
                else
                    $cmd->delete($path.'/'.$i);
            }
            return true;
        }
        else
            return false;
    }

    /**
     * This function create the yml file and the folder of project and it will add the project's namespace.
     * this funciton will also generate pages , controllers , testBooklet and scripts from the folder
     * @param Project $project
     * @return object|boolean
     */
    public function createProjectTester(Project $project)
    {
            //configuration fu fichier yml
            $cmd=$this->container->get('core_cmd_manager');
            $cmd->copy($this->container->getParameter('tests_dir').'/'.$this->container->getParameter('tester_config_file') ,$this->container->getParameter('tests_dir').'/'.$project->getIdproject().'.suite.yml' );
            $yaml = new Parser();
            $value = $yaml->parse(file_get_contents($this->container->getParameter('tests_dir').'/'.$project->getIdproject().'.suite.yml' ));
            $value['modules']['config']['WebDriver']['url']= $project->getUrl();
            $dumper = new Dumper();
            $yaml = $dumper->dump($value);
            file_put_contents($this->container->getParameter('tests_dir').'/'.$project->getIdproject().'.suite.yml', $yaml);
            //mouve the directory to the tests directory
            $cmd->mouveDirectory($this->container->getParameter('projects_upload_dir').'/'.$project->getIdproject(),$this->container->getParameter('tests_dir'));
            //create a folder for test companies
            $projectsDir = $this->container->getParameter('projects_upload_dir');
            $cmd->createFolder("testCompanies",$projectsDir.'/'.$project->getIdproject());
            $this->addToBootstrap($project);
            $fileManager=$this->container->get('test_project.file_manager');
            $testBookletManager=$this->container->get('test_project.testbooklet_manager');
            if(( $fileManager->createPagesFromFolder($project))&&( $fileManager->createControllersFromFolder($project))&&($testBookletManager->addTestBookletFromFolder($project)))
            {
                $project= $this->loadProjectById($project->getIdproject());
                return $project;
            }
            else
                return false ;
    }


    /**
     * This function will update a project by checking if a file exists if it exists then it will replace the old one else il will add the new one
     * @param Request $req
     * @param Project $project
     * @return bool|object
     */


    public function updateProject(Request $req,Project $project){
        $project->setName($req->get('name'));
        $project->setDescription($req->get('description'));
        $project->setUrl($req->get('url'));
        $this->em->flush();
        $cmd=$this->container->get('core_cmd_manager');
        $yaml = new Parser();
        $value = $yaml->parse(file_get_contents($this->container->getParameter('tests_dir').'/'.$project->getIdproject().'.suite.yml' ));
        $value['modules']['config']['WebDriver']['url']= $project->getUrl();
        $dumper = new Dumper();
        $yaml = $dumper->dump($value);
        file_put_contents($this->container->getParameter('tests_dir').'/'.$project->getIdproject().'.suite.yml', $yaml);

        //create testCompanies folder if not exist
        $path=$this->container->getParameter('tests_dir').'/'.$project->getIdproject().'/"testCompanies"';
        if(! file_exists($path))
        {
            $projectsDir = $this->container->getParameter('tests_dir');
            $cmd->createFolder("testCompanies",$projectsDir.'/'.$project->getIdproject());
        }
        $fileManager=$this->container->get('test_project.file_manager');
        $testBookletManager=$this->container->get('test_project.testbooklet_manager');

        if(( $fileManager->updatePagesFromFolder($project))&&( $fileManager->updateControllersFromFolder($project))&&($testBookletManager->updateTestBookletFromFolder($project)))
        {
            $project= $this->loadProjectById($project->getIdproject());
            return $project;
        }
        else
            return false ;




    }

    /**
     * This function will validate a project
     * @param Project $project
     * @return bool
     */
    public  function projectValidation(Project $project)
    {
        $validator = $this->container->get('validator');
        $errors = $validator->validate($project);
        if (count($errors) > 0)
        {
            return false ;
        }
        else
           return true ;
    }

    /**
     * Get a project by ID
     * @param $id
     * @return null|object
     */
    public function loadProjectById($id){
        $project =$this->getRepository()->findOneBy(array('idproject' => $id,'isDeleted' => 0));
        if($project !== null)
            $project->filterBuilds();
        return $project;
    }

    /**
     * Get a project by Name
     * @param $name
     * @return null|object
     */
    public function loadProjetByName($name){

        $projects= $this->getRepository()->findOneBy(array('name' => $name,'isDeleted' => 0));
        if($projects !== null)
        {
            foreach($projects as $project)
                $project->filterBuilds();
        }
        return $projects;
    }

    /**
     * Getting all projects
     * @return array
     */
    public function loadProjects(){
        $projects= $this->getRepository()->findBy(array('isDeleted' => 0), array('idproject' => 'desc'));
        if($projects !== null)
        {
            foreach($projects as $project)
                $project->filterBuilds();
        }
        return $projects;
    }

    /**
     * Persisting a new project
     * @param Project $project
     * @return null|object
     */
    public function addProject(Project $project){

        $this->persistAndFlush($project);
        return $project ;
    }

    /**
     * Deleting a project
     * @param  $id
     * @return bool
     */
    public function deleteProject($id)

    {
        $project= $this->loadProjectById($id);
        if($project == null)
         return false ;
        else
        {
            $project->setIsDeleted("1");
            $this->flush();
            return true;
        }
    }

    /**
     * Add the namespace of the project to the main bootstrap file in codeception.
     * The namespace will be "project + projectId"
     * @param Project $project
     */
    public function addToBootstrap(Project $project)
    {
        $bootstrapFile =  fopen($this->container->getParameter('tests_dir').'/_bootstrap.php', 'a+');
        $lineToInsertOfpages = "\n \\Codeception\\Util\\Autoload::addNamespace('project".$project->getIdproject()."\\pages',  __DIR__.'/".$project->getIdproject()."/pages');";
        $lineToInsertOfControllers = "\n \\Codeception\\Util\\Autoload::addNamespace('project".$project->getIdproject()."\\controllers',  __DIR__.'/".$project->getIdproject()."/controllers');";
        fputs($bootstrapFile,$lineToInsertOfpages);
        fputs($bootstrapFile,$lineToInsertOfControllers);
        fclose($bootstrapFile);
    }


    /**
     * Change the name of the project
     *
     * @param Project $project
     * @param $name
     */
    public function changeName(Project $project,$name)
    {
        $project->setName($name);
        $this->em->flush();

    }


    /**
     * Change the status of the project
     *
     * @param Project $project
     */
    public function changeStatus(Project $project)
    {
        $project->getStatus() == "open" ? $project->setStatus("close") : $project->setStatus("open");
        $this->em->flush();

    }

    /**
     * Remove a build from project
     *
     * @param Project $project
     * @param Build $build
     */
    public function removeBuild(Project $project,$build)
    {
        $project->removeAllBuilds($build);
        $this->em->flush();

    }





}