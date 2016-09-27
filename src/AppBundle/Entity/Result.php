<?php
/**
 * This file defines the Result Entity
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
use AppBundle\Entity\ResultDetail;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\PreSerialize;
use JMS\Serializer\Annotation as Serialiser ;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Class Resultat
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
 * @ExclusionPolicy("all")
 *@ORM\Entity(repositoryClass="ProjectBundle\Repository\ResultRepository")
 * @ORM\Table(name="result", indexes={@ORM\Index(name="fk_result_test_company1_idx", columns={"test_company_id", "build_id"}), @ORM\Index(name="IDX_E7DB5DE2ECA8ACEF", columns={"test_company_id"})})
 * @ORM\Entity
 */
class Result
{
    /**
     * @Expose
     * @var integer ID of the result
     *
     * @ORM\Column(name="idresultat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idresultat;



    /**
     * @Expose
     *
     * @var \Build Result's build
     *
     *  @ORM\ManyToOne(targetEntity="Build")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="build_id", referencedColumnName="idbuild")
     * })
     */
    private $build;

    /**
     * @Expose
     *
     * @var \TestCompany Result's TestCompany
     *
     * @ORM\ManyToOne(targetEntity="TestCompany")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="test_company_id", referencedColumnName="idtest_company")
     * })
     */
    private $testCompany;



    /**
     *
     * Set date
     *
     * @param string $date
     *
     * @return Resultat
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set buildId
     *
     * @param Build $buildId
     *
     * @return Resultat
     */
    public function setBuild(Build $buildId)
    {
        $this->build= $buildId;

        return $this;
    }

    /**
     * Get buildId
     *
     * @return integer
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * Get idresultat
     *
     * @return integer
     */
    public function getIdresultat()
    {
        return $this->idresultat;
    }

    /**
     * Set testCompany
     *
     * @param \AppBundle\Entity\TestCompany $testCompany
     *
     * @return Resultat
     */
    public function setTestCompany(\AppBundle\Entity\TestCompany $testCompany = null)
    {
        $this->testCompany = $testCompany;

        return $this;
    }

    /**
     * Get testCompany
     *
     * @return \AppBundle\Entity\TestCompany
     */
    public function getTestCompany()
    {
        return $this->testCompany;
    }



    /**
     * @var integer Number of assertion
     *
     *@Expose
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
     * @Expose
     * @var integer Number of failure
     *
     *
     * @ORM\Column(name="failure",  type="integer", nullable=true)
     */
    private $failure;


    /**
     * Set failure
     *
     * @param int $failure
     *
     * @return Result
     */
    public function setFailure($failure)
    {
        $this->failure = $failure;

        return $this;
    }

    /**
     * Get failure
     *
     * @return int
     */
    public function getFailure()
    {
        return $this->failure;
    }




    /**
     * @Expose
     * @var integer Number of errors
     *
     *
     * @ORM\Column(name="error",  type="integer", nullable=true)
     */
    private $error;


    /**
     * Set error
     *
     * @param int $error
     *
     * @return Result
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return int
     */
    public function getError()
    {
        return $this->error;
    }


    /**
     * @Expose
     * @ORM\Column(name="date", type="datetime")
     * @var DateTime Date of the Result
     */
    private $date;

    /**
     * @Expose
     *
     * @var ArrayCollection $allResultDetail Result'results Detailed
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ResultDetail", mappedBy="result",cascade = {"persist", "remove", "merge"})
     *
     */
    private $allResultDetail;






    /**
     * Add resultDetail
     *
     * @param \AppBundle\Entity\ResultDetail $resultDetail
     *
     * @return Result
     */
    public function addResultDetails(\AppBundle\Entity\ResultDetail $resultDetail)
    {
        $this->allResultDetails[] = $resultDetail;

        return $this;
    }

    /**
     * Remove resultDetail
     *
     * @param \AppBundle\Entity\ResultDetail $resultDetail
     */
    public function removeResultDetails(\AppBundle\Entity\ResultDetail $resultDetail)
    {
        $this->allResultDetails->removeElement($resultDetail);
    }

    /**
     * Get resultDetail
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAllResultDetail()
    {
        return $this->allResultDetails;
    }
    /**
     * @Expose
     *
     * @var string result's time
     *
     * @ORM\Column(name="time", type="string", length=45, nullable=true)
     */
    private $time;


    /**
     * Set time
     *
     * @param string $time
     *
     * @return Resultat
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
     * Result constructor.
     */
    public function __construct()
    {
        $this->allResultDetail = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date= new \DateTime();
    }
}
