<?php
/**
 * This file defines the File Manager
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
use AppBundle\Entity\File;
use AppBundle\Entity\TypeFile;
use AppBundle\Entity\Project;

/**
 * Class FileManager
 *
 * @package Manager
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */
class FileManager extends BaseManager
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
        return $this->em->getRepository('AppBundle:File');
    }

    /**
     * Add a file to database
     * @param File $file
     */
    public function addFile(File $file)
    {
        $this->persistAndFlush($file);
    }

    /**
     * create a page from request
     * @param $req
     */
    public function createFileFromRequest($req)
    {
       /* $file = new File();
        $file->setName($name);
        $file->setProject($project);
        $file->setType($type);
        $file->setInfo($info);
        return $file;*/
    }

    /**
     * Create a file
     * @param  $name
     * @param Project $project
     * @param TypeFile $type
     * @return File
     */
    public function createFile(string $name , Project $project, TypeFile $type)
    {
        $file = new File();
        $file->setName($name);
        $file->setProject($project);
        $file->setType($type);
        $file->setInfo(null);
        return $file;
    }

    /**
     * Add all pages to database and change their namespace
     * @param Project $project
     * @return boolean
     */
    public function createPagesFromFolder(Project $project)
    {
        $path =$this->container->getParameter('tests_dir').'/'.$project->getIdproject().'/pages';
      if( file_exists($path))
      {
          $files = array_diff(scandir($path), array('..', '.'));

          foreach ($files as $i)
          {
              $object = $this->addFileToDataBase($project,$i,"Page");
              $this->changeNameSpace($object,"pages");
          }
          return true;

      }
        else return false ;

    }




    /**
     * Update pages from the zip file
     * @param Project $project
     * @return boolean
     */
    public function updatePagesFromFolder(Project $project)
    {
        $path =$this->container->getParameter('projects_upload_dir').'/'.$project->getIdproject().'/pages';
        if( file_exists($path))
        {
            $destination =$this->container->getParameter('tests_dir').'/'.$project->getIdproject().'/pages';
            $cmd=$this->container->get('core_cmd_manager');
            $files = array_diff(scandir($path), array('..', '.'));
            foreach ($files as $i)
            {
                $cmd->mouveDirectory($path.'/'.$i,$destination.'/'.$i);
                $tab = explode('.',$i);
                if($this->loadFileByProjectAndName($project,$tab[0]) ==null)
                {
                    $object = $this->addFileToDataBase($project,$i,"Page");
                    $this->changeNameSpace($object,"pages");
                }
                else
                {

                    $item = new File();
                    $item->setProject($project);
                    $item->setName($tab[0]);
                    $this->changeNameSpace($item,"pages");
                }
            }
            return true;
        }
        else return false ;
    }
    /**
     * Add a File to database the name will be generated from the php file
     * @param Project $project
     * @param $name
     * @param $type
     * @return File $file
     */
    public function addFileToDataBase(Project $project,$name,$type)
    {
        $tab = explode('.',$name);
        $file = new File();
        $file->setName($tab[0]);
        $file->setProject($project);
        $file->setType($this->container->get('test_project.typefile_manager')->loadTypeByLabel($type));
        $this->addFile($file);
        $project->addFile($file);
        return $file ;
    }
    /**
     * Change the name space of the uploaded file to project+idProject
     * @param File|null $file
     * @param $folder
     */
    public function changeNameSpace(File $file =null, $folder )
    {
        $contenu = file_get_contents($this->container->getParameter('tests_dir').'/'.$file->getProject()->getIdproject().'/'.$folder.'/'.$file->getName().'.php');
        $nameSpaceOld=" /namespace (.*?);/";
        $nameSpaceNew= "namespace project".$file->getProject()->getIdproject()."\\".$folder." ;";
        $chaine= preg_replace($nameSpaceOld,$nameSpaceNew,$contenu);
        file_put_contents($this->container->getParameter('tests_dir').'/'.$file->getProject()->getIdproject().'/'.$folder.'/'.$file->getName().'.php',$chaine);
    }

    /**
     * Add all controllers to database and change their namespace
     * @param Project $project
     * @return boolean
     */
    public function createControllersFromFolder(Project $project)
    {
        $path =$this->container->getParameter('tests_dir').'/'.$project->getIdproject().'/controllers';
        if( file_exists($path)) {
            $files = array_diff(scandir($path), array('..', '.'));
            foreach ($files as $i) {
                $object = $this->addFileToDataBase($project, $i, "Controller");
                $this->changeNameSpace($object, "controllers");
                $this->changeUsePath($object, "controllers", "pages");
            }
            return true;
        }
        else return false;
    }


    /**
     * Update Controllers from the zip file
     * @param Project $project
     * @return boolean
     */
    public function updateControllersFromFolder(Project $project)
    {
        $path =$this->container->getParameter('projects_upload_dir').'/'.$project->getIdproject().'/controllers';
        if( file_exists($path))
        {
            $destination =$this->container->getParameter('tests_dir').'/'.$project->getIdproject().'/controllers';
            $cmd=$this->container->get('core_cmd_manager');
            $files = array_diff(scandir($path), array('..', '.'));
            foreach ($files as $i)
            {
                $cmd->mouveDirectory($path.'/'.$i,$destination.'/'.$i);
                $tab = explode('.',$i);
                if($this->loadFileByProjectAndName($project,$tab[0]) ==null)
                {
                    $object = $this->addFileToDataBase($project, $i, "Controller");
                    $this->changeNameSpace($object, "controllers");
                    $this->changeUsePath($object, "controllers", "pages");
                }
                else
                {
                    $item = new File();
                    $item->setProject($project);
                    $item->setName($tab[0]);
                    $this->changeNameSpace($item,"controllers");
                    $this->changeUsePath($item, "controllers", "pages");

                }
            }
            return true;

        }
        else return false ;

    }
    /**
     * Change the importation path for php files to the new path
     * @param File $file
     * @param $folder
     * @param $type
     */
    public function changeUsePath(File $file , $folder, $type)
    {
        $contenu = "";
        $document = fopen($this->container->getParameter('tests_dir') . '/' . $file->getProject()->getIdproject() . '/' . $folder . '/' . $file->getName() . '.php', "r+");
        while (!feof($document)) {
            $line = fgets($document);
            if (substr_count($line,"use") >0 && strpos($line,"use")==0) {
                if (strpos($line, "Codeception")!==false) {
                    continue;
                } else {
                    $tab = explode('\\', $line);
                    $line = "use project" . $file->getProject()->getIdproject() . "\\" . $type . "\\" . $tab[count($tab) - 1] . "\n";
                }
            }
            $contenu = $contenu . $line;
        }
        fclose($document);
        file_put_contents($this->container->getParameter('tests_dir') . '/' . $file->getProject()->getIdproject() . '/' . $folder . '/' . $file->getName() . '.php', $contenu);
    }


    /**
     * Load a file by project and name
     *
     * @param Project $project
     * @param $name
     * @return null|object
     */
    public function loadFileByProjectAndName(Project $project , $name)
    {
        return $this->getRepository()->findOneBy(array('name' => $name,'project'=>$project));
    }





}