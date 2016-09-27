<?php
/**
 * This file defines the DefaultController
 *
 * @category UserBundle
 * @package Controller
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */
namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/**
 * Class DefaultController
 *
 * @package Controller
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */
class DefaultController extends Controller
{
    /**
     * Index Action
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }
}
