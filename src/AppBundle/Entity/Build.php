<?php
/**
 * This file defines the BuildEntity
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
use JMS\Serializer\Annotation\Type;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\PreSerialize;
use JMS\Serializer\Annotation as Serialiser ;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Build
 *
 * @package Entity
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */

/**
 * Build
 *@ExclusionPolicy("all")
 *  @ORM\Entity(repositoryClass="ProjectBundle\Repository\BuildRepository")
 * @ORM\Table(name="build", indexes={@ORM\Index(name="fk_build_projet_idx", columns={"projet_idprojet"})})
 * @ORM\Entity
 */
class Build
{

    /**
     * Id of the build
     * @var integer
     * @Expose
     * @ORM\Column(name="idbuild", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idbuild;


    /**
     * Name of the Build
     * @Expose
     * @var string
     * @Type("string")
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;



    /**
     * Date of the Build
     *  @Expose
     * @ORM\Column(name="date", type="datetime")
     * @var DateTime
     */
    private $date;


    /**
     * Description of the Build
     *  @Expose
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=45, nullable=true)
     */
    private $description;

    /**
     * Flag to delete a build
     * @var string
     *
     * @ORM\Column(name="is_deleted", type="string", length=45, nullable=true)
     */
    private $isDeleted;

    /**
     * Project of the build
     * @var \Project
     * @Type("AppBundle\Entity\Project")
     * @ORM\ManyToOne(targetEntity="Project",inversedBy="allBuilds", cascade = {"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="projet_idprojet", referencedColumnName="idproject")
     * })
     */
    /**
     * @var String $project Build's project
     */
    private $project;

    /**
     * TestCompanies of the build
     *
     *  @Expose
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TestCompany", inversedBy="build")
     * @ORM\JoinTable(name="build_has_test_company",
     *   joinColumns={
     *     @ORM\JoinColumn(name="build_idbuild", referencedColumnName="idbuild")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="test_company_idtest_company", referencedColumnName="idtest_company")
     *   }
     * )
     */
    private $testCompany;



    /**
     * Set name
     *
     * @param string $name
     *
     * @return Build
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
     * Set date
     *
     * @param string $date
     *
     * @return Build
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
     * Set description
     *
     * @param string $description
     *
     * @return Build
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
     * @return Build
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
     * Get idbuild
     *
     * @return integer
     */
    public function getIdbuild()
    {
        return $this->idbuild;
    }

    /**
     * Set projetprojet
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return Build
     */
    public function setProject(\AppBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \AppBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Add testCompany
     *
     * @param \AppBundle\Entity\TestCompany $testCompanytestCompany
     *
     * @return Build
     */
    public function addTestCompany(\AppBundle\Entity\TestCompany $testCompanytestCompany)
    {
        $this->testCompany[] = $testCompanytestCompany;

        return $this;
    }

    /**
     * Remove Test
     *
     * @param \AppBundle\Entity\TestCompany $testCompanytestCompany
     */
    public function removeTest(\AppBundle\Entity\TestCompany $testCompanytestCompany)
    {
        $this->testCompany->removeElement($testCompanytestCompany);
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


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->testCompany = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setIsDeleted("0");
        $this->date= new \DateTime();
    }


}
