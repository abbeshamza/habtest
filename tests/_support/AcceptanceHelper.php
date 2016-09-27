<?php
namespace Codeception\Module;
use Codeception\Module;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

class AcceptanceHelper extends \Codeception\Module
{


    /**
     * @var \Guzzle\Http\Client
     */
    protected $mailcatcher;
    /**
     * @var array
     */
    protected $config = array('url', 'port', 'guzzleRequestOptions');
    /**
     * @var array
     */
    protected $requiredFields = array('url', 'port');
    public function _initialize()
    {
        $url = trim($this->config['url'], '/') . ':' . $this->config['port'];
        $this->mailcatcher = new \Guzzle\Http\Client($url);
        if (isset($this->config['guzzleRequestOptions'])) {
            foreach ($this->config['guzzleRequestOptions'] as $option => $value) {
                $this->mailcatcher->setDefaultOption($option, $value);
            }
        }
    }

    /**
     * show a variable's value
     * @param $var
     */
    public function seeMyVar($var){
        $this->debug($var);
    }

    /**
     * get all my emails
     * @return array|bool|float|int|string
     */
    public function grabAllEmails()
    {
        $response = $this->mailcatcher->get('/messages')->send();
        $messages = $response->json();
        return $messages;
    }

    /**
     * get the last email by subject
     * @param $subject
     * @return null
     */
    public function findLastEmailBySubject($subject)
    {
        $messages= $this->grabAllEmails();
        $nbr = null ;

        foreach($messages as $msg)
            {
                if (strpos($msg['subject'],$subject))
                    $nbr= $msg['id'];

            }
        return $nbr;

    }

    /**
     * get a given's body
     * @param $id
     * @return array|bool|float|int|string
     */
    public function getEmailBody($id)
    {
        $response = $this->mailcatcher->get("/messages/{$id}.json")->send();
        $message = $response->json();
        $message['source'] = quoted_printable_decode($message['source']);
        return $message;

    }

    /**
     * grab a matches from a given email's body
     * @param $email
     * @param $regex
     * @return mixed
     */
    public function grabMatchesFromAnEmail($email, $regex)
    {
        $body = ($email['source']);
        preg_match($regex,$body, $matches);
        return $matches[0];
    }

    /**
     * delete a specific email
     * @param $id
     * @return bool
     */
    public function deleteEmailById($id)
    {
        $response = $this->mailcatcher->delete("/messages/{$id}")->send();
        //$message = $response->json();
        return true;

    }





}
