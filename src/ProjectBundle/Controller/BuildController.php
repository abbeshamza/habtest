<?php
/**
 * This file defines the Build controller in the Bundle ProjectBundle for REST API
 *
 * @category ProjectBundle
 * @package Controller
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */


namespace ProjectBundle\Controller;
use AppBundle\Entity\Project;
use AppBundle\Entity\Build;
use AppBundle\Entity\Result;
use ProjectBundle\Form\BuildType;
use ProjectBundle\Form\BuildCompanyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use AppBundle\Core\ApiResponse;
use AppBundle\Core\ApiException;


/**
 *
 * Class BuildController
 *
 * @package Form
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *  @RouteResource("build")
 *
 */
class BuildController extends Controller
{


    /**
     * Get project
     *
     * @ApiDoc(
     *      section="3. Build Services",
     *     description="Get builds",
     *      parameters={
     *
     *     {"name"="project", "dataType"="integer", "required"=true, "description"="id of project"},
     *
     *       },
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
     * @param Request $req
     * @return ApiResponse
     */
    public function cgetAction(Request $req)
    {
        $projectManager = $this->get('test_project.build_manager');
        $build = $projectManager->loadBuildsByProject($req);
        if ($build != null )
            return new ApiResponse( $build,200);
        else
            return new ApiResponse( null,400);

    }


    /**
     * Get project
     *
     * @ApiDoc(
     *     section="3. Build Services",
     *     description="Get build",
     *     requirements={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="Id Project"},
     *      },
     *     statusCodes={
     *          200={
     *            "200"="The request has succeeded"
     *            },
     *        400={
     *            "40041"="Build not found",
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
        $buildManager = $this->get('test_project.build_manager');
        $build = $buildManager->loadBuildById($id);
        if ($build != null )
            return new ApiResponse( $build,200);
        else
            return new ApiResponse( null,400);

    }


    /**
     * Post Build
     *
     * @ApiDoc(
     *     section="3. Build Services",
     *     description="Post Build",
     *      parameters={
     *      {"name"="name", "dataType"="string", "required"=true, "description"="Name of project"},
     *     {"name"="project", "dataType"="intiger", "required"=true, "description"="id of project"},
     *
     *       },
     *
     *     statusCodes={
     *        201={
     *            "201"="The request has succeeded"
     *            },
     *        400={
     *             "40074"="Build not found",
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
        $build= new Build();
        $form= $this->createForm(new BuildType(),$build);
        $form->submit(json_decode($req->getContent(),true));
        $buildManager = $this->get('test_project.build_manager');
        if ( $buildManager->buildValidation($build) )
        {
            $buildManager->addBuild($build);
            return new ApiResponse( $build,201);
        }
        else
            return new ApiResponse( $build, 400100);

    }

    /**
     * Post Build
     *
     * @ApiDoc(
     *     section="3. Build Services",
     *     description="Post test companies for a specific Build",
     *      parameters={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="id of the build"},
     *
     *
     *       },
     *
     *     statusCodes={
     *        201={
     *            "201"="The request has succeeded"
     *            },
     *        400={
     *             "40074"="Build not found",
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
   public function postTestcompaniesAction($id ,Request $req)
    {
        $content = $req->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }
        else
            throw new ApiException(400102);
        $buildManager = $this->get('test_project.build_manager');
        $build=$buildManager->addCompanies($id,$params['testCompany']);
        return new ApiResponse( $build,201);
    }

    /**
     * Post Results
     *
     * @ApiDoc(
     *     section="3. Build Services",
     *     description="Post test companies for a specific Build",
     *      parameters={
     *      {"name"="idBuild", "dataType"="integer", "required"=true, "description"="id of the build"},
     *     {"name"="idTestCompany", "dataType"="integer", "required"=true, "description"="id of the TestCompany"},
     *
     *
     *       },
     *
     *     statusCodes={
     *        201={
     *            "201"="The request has succeeded"
     *            },
     *        400={
     *             "40074"="Build not found",
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
     * @param $idBuild
     * @param $idTestCompany
     * @param Request $req
     * @return ApiResponse
     */
   public function postTestcompaniesResultsAction($idBuild,$idTestCompany ,Request $req)
    {
        $buildManager=$this->get('test_project.build_manager');
        $build = $buildManager->loadBuildById($idBuild);
        if($build === null)
            throw new ApiException(400101);
        $companyManager= $this->get('test_project.testcompany_manager');
        $company= $companyManager->loadCompanyById($idTestCompany);
        if($company === null)
            throw new ApiException(400200);
        $result = new Result();
        $result->setBuild($build);
        $result->setTestCompany($company);
        $resultManager=$this->get('test_project.result_manager');
        $resultDetailed=$resultManager->createResult($result);
        return new ApiResponse( $resultDetailed,201);

    }

    /**
     * Get Results
     *
     * @ApiDoc(
     *     section="3. Build Services",
     *     description="Post test companies for a specific Build",
     *      parameters={
     *      {"name"="idBuild", "dataType"="integer", "required"=true, "description"="id of the build"},
     *     {"name"="idTestCompany", "dataType"="integer", "required"=true, "description"="id of the TestCompany"},
     *     {"name"="idResult", "dataType"="integer", "required"=true, "description"="id of result"},
     *
     *
     *       },
     *
     *     statusCodes={
     *        201={
     *            "201"="The request has succeeded"
     *            },
     *        400={
     *             "40074"="Build not found",
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
     * @param $idBuild
     * @param $idTestCompany
     * @param $idResult
     * @param Request $req
     * @return ApiResponse
     */
    public function getTestcompaniesResultsAction($idBuild,$idTestCompany ,$idResult,Request $req)
    {
        $buildManager=$this->get('test_project.build_manager');
        $build = $buildManager->loadBuildById($idBuild);
        if($build === null)
            throw new ApiException(400101);
        $companyManager= $this->get('test_project.testcompany_manager');
        $company= $companyManager->loadCompanyById($idTestCompany);
        if($company === null)
            throw new ApiException(400200);
        $resultManager=$this->get('test_project.result_manager');
        $result = $resultManager->loadResultById($idResult);
        if ($result === null)
            throw new ApiException(400300);
        return new ApiResponse( $result,201);

    }


    /**
     * Get Results
     *
     * @ApiDoc(
     *     section="3. Build Services",
     *     description="Post test companies for a specific Build",
     *      parameters={
     *      {"name"="idBuild", "dataType"="integer", "required"=true, "description"="id of the build"},
     *     {"name"="idTestCompany", "dataType"="integer", "required"=true, "description"="id of the TestCompany"},
     *     {"name"="idResult", "dataType"="integer", "required"=true, "description"="id of result"},
     *
     *
     *       },
     *
     *     statusCodes={
     *        201={
     *            "201"="The request has succeeded"
     *            },
     *        400={
     *             "40074"="Build not found",
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
     * @param $idBuild
     * @param $idTestCompany
     * @param Request $req
     * @return ApiResponse
     */
    public function cgetTestcompaniesResultsAction($idBuild,$idTestCompany ,Request $req)
    {
        $buildManager=$this->get('test_project.build_manager');
        $build = $buildManager->loadBuildById($idBuild);
        if($build === null)
            throw new ApiException(400101);
        $companyManager= $this->get('test_project.testcompany_manager');
        $company= $companyManager->loadCompanyById($idTestCompany);
        if($company === null)
            throw new ApiException(400200);
        $resultManager=$this->get('test_project.result_manager');
        $results = $resultManager->loadResult($build,$company);
        return new ApiResponse( $results,201);

    }

    /**
     * Delete Build
     *
     * @ApiDoc(
     *     section="3. Build Services",
     *     description="Delete Build",
     *      requirements={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="Id Build"},
     *      },
     *     statusCodes={
     *        200={
     *            "200"="The request has succeeded"
     *            },
     *        400={
     *             "40074"="Build not found",
     *            },
     *        403={
     *             "40311"="Denied access to Build"
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
        $buildManager=$this->get('test_project.build_manager');
        $result=$buildManager->deleteBuild($id);
        if ( $result)
        {
            return new ApiResponse( null,200);
        }

        else
            throw new ApiException(400101);
    }

    /**
     * Delete A specific TestCompany from a build
     *
     * @ApiDoc(
     *     section="3. Build Services",
     *     description="Delete a testComany from a Build",
     *      requirements={
     *      {"name"="idBuild", "dataType"="integer", "required"=true, "description"="Id Build"},
     *      {"name"="idTestComapny", "dataType"="integer", "required"=true, "description"="id of the Test Comapny"},
     *      },
     *     statusCodes={
     *        200={
     *            "200"="The request has succeeded"
     *            },
     *        400={
     *             "40074"="Build not found",
     *            },
     *        403={
     *             "40311"="Denied access to Build"
     *            },
     *        500={
     *            "5001"="An internal error has occurred"
     *            }
     *
     *     }
     * )
     * @param $idBuild
     * @param $idTestComapny
     * @param Request $req
     * @return ApiResponse
     */

    public function deleteTestcompaniesAction($idBuild,$idTestComapny,Request $req)
    {
        $buildManager=$this->get('test_project.build_manager');
        $result=$buildManager->deleteComapny($idBuild,$idTestComapny);
        if ( $result)
        {
            return new ApiResponse( null,200);
        }

        else
            throw new ApiException(400101);
    }


}