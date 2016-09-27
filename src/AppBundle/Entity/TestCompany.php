<?php
/**
 * This file defines the TestCompanyEntity
 *
 * @category AppBundle
 * @package Entity
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\PreSerialize;
use JMS\Serializer\Annotation as Serialiser ;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;
/**
 * Class TestCompany
 *
 * @package Entity
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */
/**
 * TestCompany
 *
 *  @ExclusionPolicy("all")
 * @ORM\Table(name="test_company")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\CompanyRepository")
 * @ORM\Entity
 */
class TestCompany
{
    /**
     * @Expose
     * @var integer Id of the TestCompany
     *
     * @ORM\Column(name="idtest_company", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtestCompany;

    /**
     * @Expose
     * @var string Name of the testCompany
     * @Type("string")
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string Flag to Delete a TestCompany
     *
     * @ORM\Column(name="is_deleted", type="string", length=45, nullable=true)
     */
    private $isDeleted;

    /**
     *
     * @var \Doctrine\Common\Collections\Collection TestCompany's Builds
     *
     * @ORM\ManyToMany(targetEntity="Build", mappedBy="testCompany")
     */
    private $build;

    /**
     * @Expose
     * @var \Doctrine\Common\Collections\Collection TestCompany's testCases
     * @Type("AppBundle\Entity\TestCase")
     * @ORM\ManyToMany(targetEntity="TestCase", inversedBy="testCompany")
     * @ORM\JoinTable(name="test_company_has_test_case",
     *   joinColumns={
     *     @ORM\JoinColumn(name="test_company_id", referencedColumnName="idtest_company")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="test_case_id", referencedColumnName="idtest_case")
     *   }
     * )
     */
    private $testCase;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->build = new \Doctrine\Common\Collections\ArrayCollection();
        $this->testCase = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isDeleted="0";
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return TestCompany
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
     * Set isDeleted
     *
     * @param string $isDeleted
     *
     * @return TestCompany
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
     * Get idtestCompany
     *
     * @return integer
     */
    public function getIdtestCompany()
    {
        return $this->idtestCompany;
    }

    /**
     * Add testCase
     *
     * @param \AppBundle\Entity\TestCase $testCase
     *
     * @return TestCompany
     */
    public function addTestCase(\AppBundle\Entity\TestCase $testCase)
    {
        $this->testCase[] = $testCase;

        return $this;
    }

    /**
     * Remove testCase
     *
     * @param \AppBundle\Entity\TestCase $testCase
     */
    public function removeTestCase(\AppBundle\Entity\TestCase $testCase)
    {
        $this->testCase->removeElement($testCase);
    }

    /**
     * Get testCase
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTestCase()
    {
        return $this->testCase;
    }

    /**
     * Add build
     *
     * @param \AppBundle\Entity\Build $buildbuild
     *
     * @return TestCompany
     */
    public function addBuild(\AppBundle\Entity\Build $buildbuild)
    {
        $this->build[] = $buildbuild;

        return $this;
    }

    /**
     * Remove buildbuild
     *
     * @param \AppBundle\Entity\Build $buildbuild
     */
    public function removeBuild(\AppBundle\Entity\Build $buildbuild)
    {
        $this->buildbuild->removeElement($buildbuild);
    }

    /**
     * Get build
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBuild()
    {
        return $this->build;
    }
}
