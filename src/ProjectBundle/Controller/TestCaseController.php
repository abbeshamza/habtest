<?php
/**
 * This file defines the TestCase controller
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
use AppBundle\Entity\TestCase;
use AppBundle\Entity\TestCompany;
use AppBundle\Entity\Build;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use ProjectBundle\Form\TestCompanyType;
use ProjectBundle\Form\ProjectType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use AppBundle\Core\ApiResponse;
use AppBundle\Core\ApiException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;



/**
 *
 * Class TestCaseController
 *
 * @package Controller
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 * @RouteResource("testcase")
 *
 */
class TestCaseController  extends Controller
{

    /**
     * Get testCases
     *
     * @ApiDoc(
     *     section="5. Test Cases Services",
     *     description="GettestCase",
     *      parameters={
     *
     *       },
     *
     *     statusCodes={
     *        201={
     *            "201"="The request has succeeded"
     *            },
     *        400={
     *             "40074"="testCase not found",
     *            },
     *        403={
     *             "40311"="Denied access to testCase"
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

    public function getAction(Request $req)
    {
        $testCaseManager = $this->get('test_project.testcase_manager');
        $testCases= $testCaseManager->loadTestCases();
        if($testCases == false)
            throw new ApiException(4004);
        return new ApiResponse( $testCases, 200);
    }

    /**
     * Get testCases
     *
     * @ApiDoc(
     *     section="5. Test Cases Services",
     *     description="GettestCase",
     *      parameters={
     *
     *       },
     *
     *     statusCodes={
     *        201={
     *            "201"="The request has succeeded"
     *            },
     *        400={
     *             "40074"="testCase not found",
     *            },
     *        403={
     *             "40311"="Denied access to testCase"
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

    public function cgetAction($id,Request $req)
    {
        $testCaseManager = $this->get('test_project.testcase_manager');
        $testCases= $testCaseManager->loadTestCaseById($id);
        if($testCases == false)
            throw new ApiException(4004);
        return new ApiResponse( $testCases, 200);
    }

    /**
     * Partial updating testCase
     *  <br><strong>-Disable a specific test case </strong>
     *  <br> Request format : [{"op": "disable", "path": "/disable"}]
     *
     * @ApiDoc(
     *      section="5. Test Cases Services",
     *     description="patch TestCase",
     *     requirements={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="Id of test case"},
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
        $testCaseManager = $this->get('test_project.testcase_manager');
        $patchValidator = $this->get('api.patch.data.format.validator');
        $testCase= $testCaseManager->loadTestCaseById($id);
        $data = json_decode($request->getContent());
        $patch = $patchValidator->validateDataFormat($data, 'testcase');
        foreach ($patch as $operation) {
            switch ($operation->op) {
                case 'disable':
                    if ($operation->path === '/disable') {
                        $testCaseManager->disableTestCases($testCase);
                    }
                    break;
                case 'enable':
                    if ($operation->path === '/enable') {
                        $testCaseManager->enableTestCases($testCase);
                    }
                    break;
            }

        }
        return new ApiResponse(null, 204);
    }

    /**
     * Get testCompanies
     *
     * @ApiDoc(
     *      section="5. Test Cases Services",
     *     description="DELETE TestCase",
     *     requirements={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="Id of test case"},
     *     },
     *     statusCodes={
     *        200={
     *            "201"="The request has succeeded"
     *            },
     *        400={
     *             "40074"="testCompany not found",
     *            },
     *        403={
     *             "40311"="Denied access to TestCompany"
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

    public function deleteAction($id ,Request $req)
    {

        $testCaseManager = $this->get('test_project.testcase_manager');
        $testCase= $testCaseManager->loadTestCaseById($id);
        if($testCase === null)
            throw new ApiException(400200);
        else
           $result= $testCaseManager->deleteCompany($id);
        if($result)
        return new ApiResponse( $testCase, 200);
        else
            return new ApiResponse(  $testCase,400,"You cannot delete this testCase , you are using it in other testComapny");
    }



}