<?php
/**
 * This file defines the ResultDetailEntity
 *
 * @category AppBundle
 * @package Entity
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */
namespace AppBundle\Entity;

use AppBundle\Entity\Build;
use AppBundle\Entity\Result;
use AppBundle\Entity\TestCase;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\PreSerialize;
use JMS\Serializer\Annotation as Serialiser ;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Doctrine\Common\Collections\ArrayCollection;




/**
 * Class ResultDetail
 *
 * @package Entity
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */
/**
 * Resultat
 *
 * @ORM\Table(name="result_detail")
 * @ORM\Entity
 */
class ResultDetail
{

    /**
     * @var integer Id of the resultDetail
     *@Expose
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * @var Result ResultDetail's Result
     *
     * @ORM\ManyToOne(targetEntity="Result",inversedBy="allResultDetails", cascade = {"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="result_id", referencedColumnName="idresultat")
     * })
     */
    private $result;

    /**
     *@Expose
     * @var string Number of feature
     *
     * @ORM\Column(name="feature", type="string", length=45, nullable=true)
     */
    private $feature;


    /**
     *
     * Set feature
     *
     * @param string $feature
     *
     * @return ResultDetail
     */
    public function setFeature($feature)
    {
        $this->feature = $feature;

        return $this;
    }

    /**
     * Get feature
     *
     * @return string
     */
    public function getFeature()
    {
        return $this->feature;
    }



    /**
     *
     * @var string Status of the ResultDetail
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=true)
     */
    private $status;


    /**
     *
     * Set status
     *
     * @param string $status
     *
     * @return ResultDetail
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * @var string Time taken by the testCase
     *
     *
     * @ORM\Column(name="time",  type="string", length=45,  nullable=true)
     */
    private $time;

    /**
     * Set time
     *
     * @param string $time
     *
     * @return Result
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @var integer Number of assertion
     *
     *
     * @ORM\Column(name="assertion",  type="integer", nullable=true)
     */
    private $assertion;
    /**
     * Set assertion
     *
     * @param int $assertion
     *
     * @return Result
     */
    public function setAssertion($assertion)
    {
        $this->assertion = $assertion;

        return $this;
    }

    /**
     * Get assertion
     *
     * @return int
     */
    public function getAssertion()
    {
        return $this->assertion;
    }

    /**
     * @var TestCase TestCase of the ResultDetail
     *
     * @ORM\ManyToOne(targetEntity="TestCase")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idtest_case", referencedColumnName="idtest_case")
     * })
     */
    private $testCase;


    /**
     * Set testCase
     *
     * @param TestCase $testCase
     *
     * @return ResultDetail
     */
    public function setTestCase(TestCase $testCase)
    {
        $this->testCase = $testCase;

        return $this;
    }

    /**
     * Get testCase
     *
     * @return TestCase
     */
    public function getTestCase()
    {
        return $this->testCase;
    }

    /**
     * Set result
     *
     * @param Result $result
     *
     * @return ResultDetail
     */
    public function setResult(Result $result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return Result
     */
    public function getResult()
    {
        return $this->result;
    }


    /**
     * ResultDetail constructor.
     */
    public function __construct()
    {

    }
}