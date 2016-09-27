<?php
/**
 * This file defines the TestBookletEntity
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
 * Class TestBooklet
 *
 * @package Entity
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */
/**
 * TestBooklet
 *
 * @ExclusionPolicy("all")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\TestBookletRepository")
 * @ORM\Table(name="test_booklet", indexes={@ORM\Index(name="fk_test_company_typeOfTest1_idx", columns={"typeOfTest_idtypeOfTest"}), @ORM\Index(name="fk_test_booklet_projet1_idx", columns={"projet_idprojet"})})
 * @ORM\Entity
 */
class TestBooklet
{
    /**
     *  @Expose
     * @var integer Id of the testBooklet
     *
     * @ORM\Column(name="idtest_booklet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *  @Expose
     * @var string Name of the testBooklet
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     *  @Expose
     * @var string Description of the testBooklet
     *
     * @ORM\Column(name="description", type="string", length=45, nullable=true)
     */
    private $description;

    /**
     *
     * @var string Flag to delete a testBooklet
     *
     * @ORM\Column(name="is_deleted", type="string", length=45, nullable=true)
     */
    private $isDeleted;
    /**
    @Expose
     * @var string Flag to delete a testBooklet
     *
     * @ORM\Column(name="is_disabled", type="string", length=45, nullable=true)
     */
    private $isDisabled;

    /**
     *  @Expose
     * @var \TypeOfTest Type of Tests
     *
     * @ORM\ManyToOne(targetEntity="TypeOfTest")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typeOfTest_idtypeOfTest", referencedColumnName="idtypeOfTest")
     * })
     */
    private $typeoftest;

    /**
     *
     * @var \Project TestBooklet's Project
     *
     * @ORM\ManyToOne(targetEntity="Project",cascade = {"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="projet_idprojet", referencedColumnName="idproject")
     * })
     */
    private $project;
    /**
     * @Expose
     * @var ArrayCollection $allTestCases TestBooklet's TestCases
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TestCase", mappedBy="testBooklet", cascade = {"persist"})
     * @Exclude
     */
    private $allTestCases;



    /**
     * Set name
     *
     * @param string $name
     *
     * @return TestBooklet
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
     * @return TestBooklet
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
     * @return TestBooklet
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set project
     *
     * @param Project $project
     *
     * @return TestBooklet
     */
    public function setProject(Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get projetprojet
     *
     * @return \AppBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set typeoftest
     *
     * @param \AppBundle\Entity\TypeOfTest $typeoftest
     *
     * @return TestBooklet
     */
    public function setTypeoftest(\AppBundle\Entity\TypeOfTest $typeoftest = null)
    {
        $this->typeoftest = $typeoftest;

        return $this;
    }

    /**
     * Get typeoftest
     *
     * @return \AppBundle\Entity\TypeOfTest
     */
    public function getTypeoftesttypeoftest()
    {
        return $this->typeoftest;
    }

    /**
     * Get typeoftest
     *
     * @return \AppBundle\Entity\TypeOfTest
     */
    public function getTypeoftest()
    {
        return $this->typeoftest;
    }


    /**
     * Add a testCase
     * @param TestCase $testCase
     * @return $this
     */
    public function addTestCase(TestCase $testCase)
    {
        $this->allTestCases[] = $testCase;

        return $this;
    }

    /**
     * Remove a testCase
     * @param TestCase $testCase
     */
    public function removeTestCase(TestCase $testCase)
    {
        $this->allTestCases->removeElement($testCase);
    }

    /**
     * Get all testCases
     * @return ArrayCollection
     */
    public function getAllTestCase()
    {
        return new ArrayCollection((array) $this->allTestCases->toArray());
        //  return $this->allFiles;
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
     * TestBooklet constructor.
     */
    public function __construct()
    {
        $this->setIsDeleted("0");
        $this->setIsDisabled("0");
        $this->allTestCases== new ArrayCollection();
    }
}
