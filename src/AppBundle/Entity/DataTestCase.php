<?php
/**
 * This file defines the DataTestCaseENtity
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

/**
 * Class DataTestCase
 *
 * @package Entity
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */
/**
 * DataTestCase
 *
 * @ORM\Table(name="data_test_case", indexes={@ORM\Index(name="fk_data_test_case_test_case1_idx", columns={"test_case_idtest_case"})})
 * @ORM\Entity
 */
class DataTestCase
{
    /**
     * @var integer ID of the DataTestCase
     *
     * @ORM\Column(name="idtable1", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtable1;

    /**
     * @var string Name of the file of data
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string Description of the file
     *
     * @ORM\Column(name="description", type="string", length=45, nullable=true)
     */
    private $description;

    /**
     * @var string Flag to delete a DataTestCase
     *
     * @ORM\Column(name="is_deleted", type="string", length=45, nullable=true)
     */
    private $isDeleted;

    /**
     * @var \TestCase Data' test cases
     *
     * @ORM\ManyToOne(targetEntity="TestCase")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="test_case_idtest_case", referencedColumnName="idtest_case")
     * })
     */
    private $testCasetestCase;



    /**
     * Set name
     *
     * @param string $name
     *
     * @return DataTestCase
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
     * @return DataTestCase
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
     * @return DataTestCase
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
     * Get idtable1
     *
     * @return integer
     */
    public function getIdtable1()
    {
        return $this->idtable1;
    }

    /**
     * Set testCasetestCase
     *
     * @param \AppBundle\Entity\TestCase $testCasetestCase
     *
     * @return DataTestCase
     */
    public function setTestCasetestCase(\AppBundle\Entity\TestCase $testCasetestCase = null)
    {
        $this->testCasetestCase = $testCasetestCase;

        return $this;
    }

    /**
     * Get testCasetestCase
     *
     * @return \AppBundle\Entity\TestCase
     */
    public function getTestCasetestCase()
    {
        return $this->testCasetestCase;
    }
}
