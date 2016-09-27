<?php
/**
 * This file defines the TestCaseEntity
 *
 * @category AppBundle
 * @package Entity
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */
namespace AppBundle\Entity;

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
 * Class TestCase
 *
 * @package Entity
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */
/**
 * TestCase
 *
 * @ExclusionPolicy("all")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\TestCaseRepository")
 * @ORM\Table(name="test_case", indexes={@ORM\Index(name="fk_test_case_test_booklet1_idx", columns={"test_booklet_idtest_case"})})
 * @ORM\Entity
 */
class TestCase
{
    /**
     * @Expose
     * @var integer Id of the testCase
     *
     * @ORM\Column(name="idtest_case", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtestCase;

    /**
     *  @Expose
     * @var string Name of the testCase
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     *  @Expose
     * @var string Description of the testCase
     *
     * @ORM\Column(name="description", type="string", length=45, nullable=true)
     */
    private $description;

    /**
     * @var string Flag to Delete a TestCase
     *
     * @ORM\Column(name="is_deleted", type="string", length=45, nullable=true)
     */
    private $isDeleted;

    /**
     * @Expose
     * @var string Flag to disable a testCase
     *
     * @ORM\Column(name="is_disabled", type="string", length=45, nullable=true)
     */
    private $isDisabled;

    /**
     * @var \TestBooklet TestCase's TestBooklets
     *
     * @ORM\ManyToOne(targetEntity="TestBooklet", cascade = {"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="test_booklet_idtest_case", referencedColumnName="idtest_booklet")
     * })
     */
    private $testBooklet;

    /**
     * @var \Doctrine\Common\Collections\Collection TestCase 's TestCompanies
     *
     * @ORM\ManyToMany(targetEntity="TestCompany", mappedBy="testCase")
     */
    private $testCompany;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->testCompany = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setIsDeleted("0");
        $this->setIsDisabled("0");
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return TestCase
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return TestCase
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set isDeleted
     *
     * @param string $isDeleted
     *
     * @return TestCase
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return string
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set isDeleted
     *
     * @param string $isDisabled
     *
     * @return TestCase
     */
    public function setIsDisabled($isDisabled)
    {
        $this->isDisabled = $isDisabled;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return string
     */
    public function getIsDisabled()
    {
        return $this->isDisabled;
    }

    /**
     * Get idtestCase
     *
     * @return integer
     */
    public function getIdtestCase()
    {
        return $this->idtestCase;
    }

    /**
     * Set testBooklet
     *
     * @param \AppBundle\Entity\TestBooklet $testBooklet
     *
     * @return TestCase
     */
    public function setTestBooklet(\AppBundle\Entity\TestBooklet $testBooklet = null)
    {
        $this->testBooklet = $testBooklet;

        return $this;
    }

    /**
     * Get testBooklet
     *
     * @return \AppBundle\Entity\TestBooklet
     */
    public function getTestBooklet()
    {
        return $this->testBooklet;
    }

    /**
     * Add testCompany
     *
     * @param \AppBundle\Entity\TestCompany $testCompany
     *
     * @return TestCase
     */
    public function addTestCompany(\AppBundle\Entity\TestCompany $testCompany)
    {
        $this->testCompany[] = $testCompany;

        return $this;
    }

    /**
     * Remove testCompany
     *
     * @param \AppBundle\Entity\TestCompany $testCompany
     */
    public function removeTestCompany(\AppBundle\Entity\TestCompany $testCompany)
    {
        $this->testCompany->removeElement($testCompany);
    }

    /**
     * Get testCompany
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTestCompany()
    {
        return $this->testCompany;
    }

}
