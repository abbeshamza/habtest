<?php
/**
 * This file defines the TestCompany controller
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
 *
 * Class ProjectBundle
 *
 * @category ProjectBundle
 * @package
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 * @RouteResource("testcompanies")
 *
 */
class TestCompanyController  extends Controller
{


    /**
     * Post testCompany
     *
     * @ApiDoc(
     *     section="4. Test Companies Services",
     *     description="Post testCompany",
     *      parameters={
     *      {"name"="name", "dataType"="string", "required"=true, "description"="info about the test company"},
     *       },
     *
     *     statusCodes={
     *        201={
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
     * @param Request $req
     * @return ApiException|ApiResponse
     */

    public function postAction(Request $req)
    {

        $testCompany= new TestCompany();
        $form= $this->createForm(new TestCompanyType(),$testCompany);
        $form->submit(json_decode($req->getContent(),true));
        $testCompanyManager = $this->get('test_project.testcompany_manager');
        if ( $form->isValid() )
        {
            $testCompanyManager->addCompany($testCompany);
            return new ApiResponse( $testCompany,201);
        }
        else
            return new ApiException( $testCompany, 400);

    }


    /**
     * Get testCompanies
     *
     * @ApiDoc(
     *     section="4. Test Companies Services",
     *     description="GettestCompanies",
     *      parameters={
     *
     *       },
     *
     *     statusCodes={
     *        201={
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
     * @param Request $req
     * @return ApiResponse
     */

    public function getAction(Request $req)
    {
        $testCompanyManager = $this->get('test_project.testcompany_manager');
        $testCompanies= $testCompanyManager->loadCompanies();
        if($testCompanies == false)
            throw new ApiException(4004);
        return new ApiResponse( $testCompanies, 200);
    }

    /**
     * Get testCompanies
     *
     * @ApiDoc(
     *     section="4. Test Companies Services",
     *     description="GettestCompanies",
     *      parameters={
     *
     *       },
     *
     *     statusCodes={
     *        201={
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

    public function cgetAction($id ,Request $req)
    {

        $testCompanyManager = $this->get('test_project.testcompany_manager');
        $testCompany= $testCompanyManager->loadCompanyById($id);
        if($testCompany === null)
            throw new ApiException(400200);
        return new ApiResponse( $testCompany, 200);
    }

    /**
     * Get testCompanies
     *
     * @ApiDoc(
     *     section="4. Test Companies Services",
     *     description="Delete testCompanies",
     *      parameters={
     *
     *       },
     *
     *     statusCodes={
     *        201={
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

        $testCompanyManager = $this->get('test_project.testcompany_manager');
        $testCompany= $testCompanyManager->loadCompanyById($id);
        if($testCompany === null)
            throw new ApiException(400200);
        else
            $testCompanyManager->deleteCompany($id);
        return new ApiResponse( $testCompany, 200);
    }


}