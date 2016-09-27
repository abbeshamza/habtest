<?php
/**
 * This file defines Project Entity
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
 * Class Project
 *
 * @package Entity
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */
/**
 * Project
 *
 * @ExclusionPolicy("all")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\ProjetRepository")
 * @ORM\Table(name="project")
 * @ORM\Entity
 */
class Project
{
    /**
     * @Expose
     * @var integer Id of the project
     *
     * @ORM\Column(name="idproject", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproject;

    /**
     * @Expose
     * @var string Name of the project
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @Expose
     * @var string Url of the project
     *
     * @ORM\Column(name="url", type="string", length=45, nullable=true)
     */
    private $url;

    /**
     * @Expose
     * @var string Status of the project
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=true)
     */
    private $status;

    /**
     *  @Expose
     * @var string Sttatus of the project
     *
     * @ORM\Column(name="description", type="string", length=45, nullable=true)
     */
    private $description;

    /**
     * @var string Flag to delete a project
     *
     * @ORM\Column(name="is_deleted", type="string", length=45, nullable=true)
     */
    private $isDeleted;

    /**
     * @Expose
     * @var ArrayCollection $allFiles Project's Files
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\File", mappedBy="project", cascade = {"persist", "remove", "merge"})
     * @Exclude
     */
    private $allFiles;

    /**
     * @Expose
     * @var ArrayCollection $allTestBooklet Projects 's TestBooklet
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TestBooklet", mappedBy="project", cascade = {"persist"})
     *
     *
     */
    private $allTestBooklet;


    /**
     * @Expose
     * @var ArrayCollection $allBuilds Project'Builds
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Build", mappedBy="project", cascade = {"persist"})
     * @ORM\OrderBy({"idbuild" = "DESC"})
     * @Exclude
     */
    private $allBuilds;

    /**
     *
     * Set name
     *
     * @param string $name
     *
     * @return Project
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
     * Set url
     *
     * @param string $url
     *
     * @return Project
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Project
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
     * Set description
     *
     * @param string $description
     *
     * @return Project
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
     * @return Project
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
     * Get idproject
     *
     * @return integer
     */
    public function getIdproject()
    {
        return $this->idproject;
    }

    /**
     * set idproject
     *
     * @param $id
     * @return int
     */
    public function setIdproject($id)
    {
         $this->idproject =$id;
        return $this;
    }

    /**
     * Add a file
     * @param File $file
     * @return $this
     */
    public function addFile(File $file)
    {
        $this->allFiles[] = $file;

        return $this;
    }

    /**
     * Delete a file
     * @param File $file
     */
    public function removeFile(File $file)
    {
        $this->allFiles->removeElement($file);
    }

    /**
     * Get files
     * @return ArrayCollection
     */
    public function getAllFiles()
    {
        return new ArrayCollection((array) $this->allFiles->toArray());
      //  return $this->allFiles;
    }

    /**
     * Add s TestBooklet
     *
     * @param \AppBundle\Entity\TestBooklet $testBooklet
     *
     * @return Project
     */
    public function addAllTestBooklet(\AppBundle\Entity\TestBooklet $testBooklet)
    {
        $this->allTestBooklet[] = $testBooklet;

        return $this;
    }

    /**
     * Remove a TestBooklet
     *
     * @param \AppBundle\Entity\TestBooklet $testBooklet
     */
    public function removeAllTestBooklet(\AppBundle\Entity\TestBooklet $testBooklet)
    {
        $this->allTestBooklet->removeElement($testBooklet);
    }

    /**
     * Get all testBooklet
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAllTestBooklet()
    {
        return $this->allTestBooklet;
    }


    /**
     * Add a Build
     *
     * @param \AppBundle\Entity\Build $build
     *
     * @return Project
     */
    public function addAllBuild(\AppBundle\Entity\Build $build)
    {
        $this->allBuilds[] = $build;

        return $this;
    }

    /**
     * Remove a Build
     *
     * @param \AppBundle\Entity\Build $build
     */
    public function removeAllBuilds(\AppBundle\Entity\Build $build)
    {
        $this->allBuilds->removeElement($build);
    }

    /**
     * Get all Builds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAllBuild()
    {
        return $this->allBuilds;
    }
    /**
     * Filter Builds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function filterBuilds()
    {
        $builds= new ArrayCollection();
        $builds= $this->allBuilds;
        $this->allBuilds=new ArrayCollection();
        foreach($builds as $build)

        {
            if($build->getIsDeleted()==0)
            {
               $this->allBuilds->add($build);
            }
        }
    }

    /**
     * Project constructor.
     */
    public function __construct()
    {
        $this->setIsDeleted("0");
        $this->setStatus("open");
        $this->allFiles = new ArrayCollection();
        $this->allTestBooklet = new ArrayCollection();
        $this->allBuilds= new ArrayCollection();

    }

    /**
     * Set attributes before serialization
     *
     * @author Fondative <dev devteam@fondative.com>
     * @PreSerialize
     */
    public function beforeSerialization(){
        $this->name=$this->getName();
        $this->status= $this->getStatus();
        $this->description=$this->getDescription();
        $this->allTestBooklet=$this->getAllTestBooklet();

    }
}
