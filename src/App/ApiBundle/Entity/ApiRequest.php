<?php

namespace App\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="api_request")
 * @ORM\Entity()
 */
class ApiRequest
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $requestUri;

    /**
     * @ORM\Column(type="text")
     */
    private $requestContent;

    /**
     * @ORM\Column(type="integer")
     */
    private $responseStatusCode;

    /**
     * @ORM\Column(type="text")
     */
    private $responseContent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set requestUri
     *
     * @param string $requestUri
     *
     * @return ApiRequest
     */
    public function setRequestUri($requestUri)
    {
        $this->requestUri = $requestUri;

        return $this;
    }

    /**
     * Get requestUri
     *
     * @return string
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }

    /**
     * Set requestContent
     *
     * @param string $requestContent
     *
     * @return ApiRequest
     */
    public function setRequestContent($requestContent)
    {
        $this->requestContent = $requestContent;

        return $this;
    }

    /**
     * Get requestContent
     *
     * @return string
     */
    public function getRequestContent()
    {
        return $this->requestContent;
    }

    /**
     * Set responseStatusCode
     *
     * @param integer $responseStatusCode
     *
     * @return ApiRequest
     */
    public function setResponseStatusCode($responseStatusCode)
    {
        $this->responseStatusCode = $responseStatusCode;

        return $this;
    }

    /**
     * Get responseStatusCode
     *
     * @return integer
     */
    public function getResponseStatusCode()
    {
        return $this->responseStatusCode;
    }

    /**
     * Set responseContent
     *
     * @param string $responseContent
     *
     * @return ApiRequest
     */
    public function setResponseContent($responseContent)
    {
        $this->responseContent = $responseContent;

        return $this;
    }

    /**
     * Get responseContent
     *
     * @return string
     */
    public function getResponseContent()
    {
        return $this->responseContent;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ApiRequest
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
