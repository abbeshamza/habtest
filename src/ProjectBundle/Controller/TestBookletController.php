<?php
/**
 * This file defines the TestBooklet controller
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
 *
 * Class TestBookletController
 *
 * @package Controller
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 * @RouteResource("testbooklet")
 *
 */
class TestBookletController  extends Controller
{
    /**
     * Get testbooklet
     *
     * @ApiDoc(
     *     section="6. Test booklet Services",
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
     *             "40074"="testbooklet not found",
     *            },
     *        403={
     *             "40311"="Denied access to testbooklet"
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
        $testBookletManager = $this->get('test_project.testbooklet_manager');
        $testBooklet= $testBookletManager->loadTestBookletById($id);
        if($testBooklet == false)
            throw new ApiException(4004);
        return new ApiResponse( $testBooklet, 200);
    }

    /**
     * Partial updating testCase
     *  <br><strong>-Disable a specific test Booklet </strong>
     *  <br> Request format : [{"op": "disable", "path": "/disable"}]
     *
     * @ApiDoc(
     *      section="6. Test booklet Services",
     *     description="patch TestCase",
     *     requirements={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="Id of test case"},
     *     },
     *     statusCodes={
     *        204={
     *            "204"="The resource is updated"
     *            },
     *        400={
     *            "40025"="testBooklet not found",
     *            "40060"="Wrong data format for PATCH method. Data format must be [{op: '', path: '', parameter1: '', ...}, ..]",
     *            "40061"="Wrong patch format",
     *            },
     *        403={
     *            "40310"="Denied access to testBooklet",
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
        $testBookletManager = $this->get('test_project.testbooklet_manager');
        $patchValidator = $this->get('api.patch.data.format.validator');
        $testBooklet= $testBookletManager->loadTestBookletById($id);
        $data = json_decode($request->getContent());
        $patch = $patchValidator->validateDataFormat($data, 'testcase');
        foreach ($patch as $operation) {
            switch ($operation->op) {
                case 'disable':
                    if ($operation->path === '/disable') {
                        $testBookletManager->disableTestBooklet($testBooklet);
                    }
                    break;
                case 'enable':
                    if ($operation->path === '/enable') {
                        $testBookletManager->enableTestBooklet($testBooklet);
                    }
                    break;
            }

        }
        return new ApiResponse(null, 204);
    }

}