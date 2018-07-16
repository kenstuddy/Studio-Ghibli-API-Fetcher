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
    private $resultArray = array();
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
     * Constructor for Api class.
     * @param $method
     * @param $url
     * @param $returnTransfer
     * @param bool $production
     * @param string $post
     */
    function __construct($method, $url, $returnTransfer, $production = false, $post = "") {
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
    function setMethod($method) {
        $this->method = $method;
    }

    /**
     * @param $url
     */
    function setCurl($url) {
        $this->curl = curl_init($url);
    }

    /**
     * @param $url
     */
    function setUrl($url) {
        $this->url = $url;
    }

    /**
     * @param $response
     */
    function setResponse($response) {
        $this->response = $response;
    }

    /**
     * @param $httpCode
     */
    function setHttpCode($httpCode) {
        $this->httpCode = $httpCode;
    }

    /**
     * @param $returnTransfer
     */
    function setReturnTransfer($returnTransfer) {
        $this->returnTransfer = $returnTransfer;
    }

    /**
     * @param $result
     */
    function setResult($result) {
        $this->result = $result;
    }

    /**
     * @param $result
     */
    function setResultArray($result) {
        $this->resultArray = json_decode($result, TRUE);
    }

    /**
     * @param $post
     */
    function setPostData($post) {
        $this->post = $post;
    }

    /**
     * @return string
     */
    function getMethod() {
        return $this->method;
    }

    /**
     * @return string
     */
    function getUrl() {
        return $this->url;
    }

    /**
     * @return mixed
     */
    function getCurl() {
        return $this->curl;
    }

    /**
     * @return string
     */
    function getResponse() {
        return $this->response;
    }

    /**
     * @return int
     */
    function getHttpCode() {
        return $this->httpCode;
    }

    /**
     * @return bool
     */
    function getReturnTransfer() {
        return $this->returnTransfer;
    }

    /**
     * @return string
     */
    function getResult() {
        return $this->result;
    }

    /**
     * @return array
     */
    function getResultArray() {
        return $this->resultArray;
    }

    /**
     * @return string
     */
    function getPostData() {
        return $this->post;
    }

    /**
     * This function calls the API using the specific HTTP method.
     */
    function callApi() {
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

            $this->setHttpCode(curl_getinfo($this->getCurl(), CURLINFO_HTTP_CODE));

            //Check for HTTP 200 OK response code
            if ($this->getHttpCode() != 200) {
                throw new \Exception("An error has occurred, status code: $this->getHttpCode() ");
            }
            curl_close($this->getCurl());
        } catch (Exception $ex) {
            echo "An error has occurred: $ex";
        }
    }
}
?>