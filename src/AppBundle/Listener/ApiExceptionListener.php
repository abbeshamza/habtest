<?php
/**
 * This file defines the ApiExceptionListener
 *
 * @category AppBundle
 * @package Listener
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */
namespace AppBundle\Listener;

use AppBundle\Core\ApiException;
use AppBundle\Core\ApiResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class ApiExceptionListener
 *
 * @package Listener
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */


class ApiExceptionListener
{
    /**
     * Kernal variable
     * @var
     *
     */
    protected $kernel;

    /**
     * ApiExceptionListener constructor.
     * @param $kernel
     */
    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Listener to throw Exception and make a ApiResponse
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof ApiException) {
            $code = $exception->getErrorCode();
            $message = $exception->getMessage();
            $status = $exception->getStatus();
            $data = $exception->getData();
        } else {
            if ($exception instanceof HttpExceptionInterface && method_exists($exception, "getStatusCode")) {
                $code = $exception->getStatusCode();
            } else {
                $code = 500;
            }
            $status = 'error';
            $message = $this->kernel->getEnvironment() == 'dev' ? $exception->getMessage() : 'An internal error has occurred';
            $data = null;
        }

        $response = new ApiResponse($data, $code, $message, $status);
        $event->setResponse($response);
    }
}

?>
