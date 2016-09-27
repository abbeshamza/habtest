<?php
/**
 * This file defines the Project controller
 *
 * @category ProjectBundle
 * @package Controller
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */

namespace ProjectBundle\Controller;

use AppBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use ProjectBundle\Form\ProjectType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use AppBundle\Core\ApiResponse;
use AppBundle\Core\ApiException;


/**
 * Class ProjectController
 *
 * @package Controller
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 * @RouteResource("project")
 */


class ProjectController extends Controller
{


    /**
     * Put project
     *
     * @ApiDoc(
     *     section="2. Project Services",
     *     description="put Project",
     *  parameters={
     *      {"name"="name", "dataType"="string", "required"=true, "description"="Name of project"},
     *     {"name"="url", "dataType"="string", "required"=true, "description"="url of project"},
     *     {"name"="description", "dataType"="string", "required"=true, "description"="description of project"},
     *
     *
     *       },
     *     statusCodes={
     *          200={
     *            "200"="The request has succeeded"
     *            },
     *        400={
     *            "40041"="Project not found",
     *            },
     *        500={
     *            "5001"="An internal error has occurred"
     *            }
     *
     *     }
     * )
     * @param $id
     * @param Request $req
     * @return ApiResponse
     */
    public function postUpdateAction($id,Request $req)
    {
        $projectManager = $this->get('test_project.project_manager');
        $project = $projectManager->loadProjectById($id);
        if ($project != null )
        {
            $message=null;
                if($projectManager->uploadProjectFromZip($req,$project)===false)
                    $message= "Unvalid  Zip file";

                    $result=$projectManager->updateProject($req,$project);
                    $project=$result;
                    if($result==false)
                        $message= "Unvalid  Zip file";


            return  new ApiResponse( $project,201,$message);


        }

        else
            return new ApiResponse( null,4004);


    }


    /**
     * Get project
     *
     * @ApiDoc(
     *     section="2. Project Services",
     *     description="Get Projects",
     *
     *     statusCodes={
     *          200={
     *            "200"="The request has succeeded"
     *            },
     *        400={
     *            "40041"="Project not found",
     *            },
     *        500={
     *            "5001"="An internal error has occurred"
     *            }
     *
     *     }
     * )
     */
    public function cgetAction()
    {
        $projectManager = $this->get('test_project.project_manager');
        $project = $projectManager->loadProjects();
        if ($project != null )
            return new ApiResponse( $project,200);
        else
            return new ApiResponse( null,400);

    }


    /**
     * Get project
     *
     * @ApiDoc(
     *     section="2. Project Services",
     *     description="Get Project",
     *     requirements={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="Id Project"},
     *      },
     *     statusCodes={
     *          200={
     *            "200"="The request has succeeded"
     *            },
     *        400={
     *            "4004"="Project not found",
     *            },
     *        500={
     *            "5001"="An internal error has occurred"
     *            }
     *
     *     }
     * )
     * @param $id
     * @param Request $request
     * @return ApiResponse
     */
    public function getAction($id, Request $request)
    {
        $projectManager = $this->get('test_project.project_manager');
        $project = $projectManager->loadProjectById($id);
        if ($project != null )
            return new ApiResponse( $project,200);
        else
            return new ApiResponse( null,4004);

    }

    /**
     * Post Project
     *
     * @ApiDoc(
     *     section="2. Project Services",
     *     description="Post Project",
     *      parameters={
     *      {"name"="name", "dataType"="string", "required"=true, "description"="Name of project"},
     *     {"name"="url", "dataType"="string", "required"=true, "description"="url of project"},
     *     {"name"="description", "dataType"="string", "required"=true, "description"="description of project"},
     *
     *
     *       },
     *
     *     statusCodes={
     *        201={
     *            "201"="The request has succeeded"
     *            },
     *        400={
     *             "4000"="There is another project with the same name",
     *              "4001"= "Project not valid",
     *              "4002"="There is no ZIP File",
     *              "4003"="Unvalid Zip File"
     *            },
     *        403={
     *             "40311"="Denied access to Project"
     *            },
     *        500={
     *            "5001"="An internal error has occurred"
     *            }
     *
     *     }
     * )
     * @param Request $req
     * @return ApiResponse
     */


    public function postAction(Request $req)
    {
        $projectManager = $this->get('test_project.project_manager');
        $project = $projectManager->createProjectFromRequest($req);
        if($project == null)
            throw new ApiException(4000);
        if ( $projectManager->projectValidation($project) )
        {
            $project= $projectManager->addProject($project);
            $message="project created with success";
            if($projectManager->uploadProjectFromZip($req,$project)==false)
                 $message= "Project created But the zip file is unvalid";
            else
            {
                $result=$projectManager->createProjectTester($project);
                if($result==false)
                    $message= "Project created But the zip file is unvalid";
            }
            return  new ApiResponse( $project,201,$message);
        }
        else
            throw new ApiException(4001);
    }

    /**
     * Delete Project
     *
     * @ApiDoc(
     *     section="2. Project Services",
     *     description="Delete Project",
     *      requirements={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="Id Project"},
     *      },
     *     statusCodes={
     *        200={
     *            "200"="The request has succeeded"
     *            },
     *        400={
     *             "40074"="Project not found",
     *            },
     *        403={
     *             "40311"="Denied access to Project"
     *            },
     *        500={
     *            "5001"="An internal error has occurred"
     *            }
     *
     *     }
     * )
     * @param $id
     * @param Request $req
     * @return ApiResponse
     */

    public function deleteAction($id,Request $req)
    {
        $projectManager = $this->get('test_project.project_manager');
        $result=$projectManager->deleteProject($id);
        if ( $result)
        {
            return new ApiResponse( null,200);
        }

        else
            throw new ApiException(4004);
    }

    /**
     * Get project's Test booklet
     *
     * @ApiDoc(
     *     section="2. Project Services",
     *     description="Get Project",
     *     requirements={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="Id Project"},
     *      },
     *     statusCodes={
     *          200={
     *            "200"="The request has succeeded"
     *            },
     *        400={
     *            "40041"="Project not found",
     *            },
     *        500={
     *            "5001"="An internal error has occurred"
     *            }
     *
     *     }
     * )
     * @param $id
     * @param Request $request
     * @return ApiResponse
     */

    public function getTestbookletAction($id, Request $request)
    {



        $projectManager = $this->get('test_project.project_manager');
        $project = $projectManager->loadProjectById($id);
        if (count($project) == 0 )
            throw new ApiException(4004);
        $testBoooklet =$project->getAllTestBooklet();
        return new ApiResponse($testBoooklet ,200);

    }


    /**
     * Get project's Test booklet
     *
     * @ApiDoc(
     *     section="2. Project Services",
     *     description="Get Project",
     *     requirements={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="Id Project"},
     *      },
     *     statusCodes={
     *          200={
     *            "200"="The request has succeeded"
     *            },
     *        400={
     *            "40041"="Project not found",
     *            },
     *        500={
     *            "5001"="An internal error has occurred"
     *            }
     *
     *     }
     * )
     * @param $id
     * @param Request $request
     * @return ApiResponse
     */

 public function getTestcompaniesAction($id, Request $request)
   {
       $projectManager = $this->get('test_project.project_manager');
       $project = $projectManager->loadProjectById($id);
       if (count($project) == 0 )
           throw new ApiException(4004);
       $testCompanyManager = $this->get('test_project.testcompany_manager');
       $testCompanies= $testCompanyManager->getCompaniesByProject($id);
       return new ApiResponse( $testCompanies,200);

   }


    /**
     * Partial updating project
     *  <br><strong>- Update statut of the project </strong>
     *  <br> Request format : [{"op": "change", "path": "/status"}]
     *  <br><strong>-Rename </strong>
     *  <br> Request format : [{"op": "rename", "path": "/name","params" : [name]}]
     *
     * @ApiDoc(
     *      section="2. Project Services",
     *     description="patch Project",
     *     requirements={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="Id of project"},
     *     },
     *     statusCodes={
     *        204={
     *            "204"="The resource is updated"
     *            },
     *        400={
     *            "40025"="project not found",
     *            "40060"="Wrong data format for PATCH method. Data format must be [{op: '', path: '', parameter1: '', ...}, ..]",
     *            "40061"="Wrong patch format",
     *            },
     *        403={
     *            "40310"="Denied access to project",
     *            },
     *        500={
     *            "5001"="An internal error has occurred"
     *            },
     *
     *     }
     * )
     * @param $id
     * @param Request $request
     * @return ApiResponse
     */
    public function patchAction($id, Request $request)
    {
        $projectManager= $this->get('test_project.project_manager');
        $patchValidator = $this->get('api.patch.data.format.validator');
        $project=$projectManager->loadProjectById($id);
        $data = json_decode($request->getContent());
        $patch = $patchValidator->validateDataFormat($data, 'project');
        foreach ($patch as $operation) {
            switch ($operation->op) {
                case 'rename':
                    if ($operation->path === '/name') {
                        $projectManager->changeName($project,$operation->params[0]);
                    }
                    break;
                case 'change':
                    if ($operation->path === '/status') {
                        $projectManager->changeStatus($project);
                    }
                    break;
            }

        }
        return new ApiResponse(null, 204);
    }




}