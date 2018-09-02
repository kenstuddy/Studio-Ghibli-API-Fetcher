<?php

/**
 * This class is used as a wrapper for HTTP (RESTful) API calls using PHP's curl functions.
 * Class Api
 */
class Api
{
    /**
     * @var
     */
    private $curl;
    /**
     * @var string
     */
    private $method = "";
    /**
     * @var string
     */
    private $url = "";
    /**
     * @var string
     */
    private $response = "";
    /**
     * @var string
     */
    private $result = "";
    /**
     * @var array
     */
    private $resultArray = [];
    /**
     * @var string
     */
    private $post = "";
    /**
     * @var int
     */
    private $httpCode = 0;
    /**
     * @var bool
     */
    private $returnTransfer = true;
    /**
     * @var string
     */
    private $error = "";

    /**
     * Constructor for Api class.
     * @param $method
     * @param $url
     * @param $returnTransfer
     * @param bool $production
     * @param string $post
     */
    public function __construct($method, $url, $returnTransfer, $production = false, $post = "") {
        $this->setMethod($method);
        $this->setPostData($post);
        $this->setUrl($url);
        $this->setReturnTransfer($returnTransfer);
        $this->setCurl($this->getUrl());
        if (!$production) {
            ini_set('display_errors', 1);
        }
    }


    /**
     * @param $method
     */
    public function setMethod($method) {
        $this->method = $method;
    }

    /**
     * @param $url
     */
    public function setCurl($url) {
        $this->curl = curl_init($url);
    }

    /**
     * @param $url
     */
    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     * @param $response
     */
    public function setResponse($response) {
        $this->response = $response;
    }

    /**
     * @param $httpCode
     */
    public function setHttpCode($httpCode) {
        $this->httpCode = $httpCode;
    }

    /**
     * @param $returnTransfer
     */
    public function setReturnTransfer($returnTransfer) {
        $this->returnTransfer = $returnTransfer;
    }

    /**
     * @param $result
     */
    public function setResult($result) {
        $this->result = $result;
    }

    /**
     * @param $result
     */
    public function setResultArray($result) {
        $this->resultArray = json_decode($result, TRUE);
    }

    /**
     * @param $post
     */
    public function setPostData($post) {
        $this->post = json_encode($post);
    }
    /**
     * @param $error
     */
    public function setError($error) {
        $this->error = $error;
    }
    
    /**
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getCurl() {
        return $this->curl;
    }

    /**
     * @return string
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * @return int
     */
    public function getHttpCode() {
        return $this->httpCode;
    }

    /**
     * @return bool
     */
    public function getReturnTransfer() {
        return $this->returnTransfer;
    }

    /**
     * @return string
     */
    public function getResult() {
        return $this->result;
    }

    /**
     * @return array
     */
    public function getResultArray() {
        return $this->resultArray;
    }

    /**
     * @return string
     */
    public function getPostData() {
        return $this->post;
    }
    /**
     * @return string
     */
    public function getError() {
        return $this->error;
    }
    
    /**
     * This function calls the API using the specific HTTP method.
     */
    public function callApi() {
        try {
            switch ($this->getMethod()) {

                case "GET":
                    curl_setopt($this->getCurl(), CURLOPT_HTTPGET, 1);
                break;

                case "POST":
                    curl_setopt($this->getCurl(), CURLOPT_POSTFIELDS, $this->getPostData());
                    curl_setopt($this->getCurl(), CURLOPT_POST, 1);
                break;

                case "PUT":
                    curl_setopt($this->getCurl(), CURLOPT_POSTFIELDS, $this->getPostData());
                    curl_setopt($this->getCurl(), CURLOPT_PUT, 1);
                break;

                case "DELETE":
                    curl_setopt($this->getCurl(), CURLOPT_POSTFIELDS, $this->getPostData());
                    curl_setopt($this->getCurl(), CURLOPT_CUSTOMREQUEST, "DELETE");
                break;

            }

            if ($this->getReturnTransfer()) {
                curl_setopt($this->getCurl(), CURLOPT_RETURNTRANSFER, 1);
            }
            
            $this->setResult(curl_exec($this->getCurl()));

            $this->setResultArray($this->getResult());

            //Set the HTTP response code based on the response of the API call.
            $this->setHttpCode(curl_getinfo($this->getCurl(), CURLINFO_HTTP_CODE));

            //Check for HTTP 200 OK response code. The error variable gets set to this exception in the catch block.
            if ($this->getHttpCode() !== 200) {
                throw new \Exception("An error has occurred, status code: " . $this->getHttpCode());
            }
            curl_close($this->getCurl());
        } catch (Exception $ex) {
            $this->setError($ex);
        }
    }
}
?>
