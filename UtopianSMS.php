<?php

namespace therealsmat;

class UtopianSMS {

    /**
     * Stores the sms client key
     *
     * @var
     */
    private $apiKey;

    /**
     * Stores the account email address
     *
     * @var
     */
    private $email;

    /**
     * Stores the sender name
     *
     * @var
     */
    protected $senderName;

    /**
     * Stores the message to be sent
     *
     * @var
     */
    private $message;

    /**
     * SMS Recipients
     *
     * @var array
     */
    private $receipents = [];


    /**
     * Mutator for ApiKey
     *
     * @param $key
     * @return mixed
     */
    public function setApiKey($key)
    {
        return $this->apiKey = $key;
    }

    /**
     * Mutator for account email
     *
     * @param $email
     * @return mixed
     */
    public function setEmail($email)
    {
        return $this->email = $email;
    }

    /**
     * Mutator for sender name
     *
     * @param $name
     * @return mixed
     */
    public function setSender($name)
    {
        return $this->senderName = trim($name);
    }

    /**
     * Set the message to be sent
     *
     * @param $message
     * @return UtopianSMS
     */
    public function message($message)
    {
        $this->message = trim($message);
        return $this;
    }

    /**
     * Add recipients
     *
     * @param $recipients
     * @return $this
     */
    public function to($recipients)
    {
        if (is_array($recipients)) {
            $this->receipents = $recipients;
        } else {
            $this->receipents = explode(',', $recipients);
        }

        return $this;
    }

    public function send()
    {
        #. Add your protocol for sending the sms
        #.. Most likely, perform an http request...
    }
}

class Controller {

    public function index()
    {
        $utopian = new UtopianSMS();

        $apiKey = 'dhjfhj';
        $senderName = 'therealsmat';
        $email = 'hello@example.com';

        $utopian->setApiKey($apiKey)
                ->setSender($senderName)
                ->setEmail($email);

        $recipients = ['09098765431'];

        $utopian->message('Hello there, thanks for signing up!')
                ->to($recipients)
                ->send();
    }
}