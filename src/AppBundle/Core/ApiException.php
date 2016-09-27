<?php
/**
 * This file defines the Api Exception for REST API
 *
 * @category AppBundle
 * @package Core
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */
namespace AppBundle\Core;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ApiException for API services
 *
 * @category Exception
 * @package Core
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */
class  ApiException extends HttpException
{


    const STATUS_ERROR = 'error';
    const STATUS_WARNING = 'warning';
    /**
     * @var $status string Status of the ApiException
     */
    public $status;
    /**
     * @var $code string code of the ApiException
     */
    public $code;
    /**
     * @var $message string Message of the ApiException
     */
    public $message;
    /**
     * @var $data string Data of the ApiException
     */
    public $data;


    /**
     * ApiException constructor.
     * @param $code
     * @param null $data
     * @param array $params
     * @param string $status
     */
    public function __construct($code, $data = null, $params = array(), $status = 'error')
    {

        $statusCode = intval(substr($code, 0, 3));
        $errors = parse_ini_file(__DIR__ . '/../../../app/config/errors_code.ini');
        $message = $errors[$code];
        if (count($params)) {
            foreach ($params as $key => $value) {
                $message = str_replace("#$key#", $value, $message);
            }
        }

        parent::__construct($statusCode, $message, null, array(), $code);
        $this->code = $code;
        $this->message = $message;
        $this->status = $status;
        $this->data = $data;
    }

    /**
     * Getter of ErrorCode
     * @return string
     */
    public function getErrorCode()
    {
        return $this->code;
    }

    /**
     * Getter of Data
     * @return null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Getter of status
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
