<?php
/**
 * This file defines the TypeOfTestEntity
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
/**
 * Class TypeOfTest
 *
 *
 * @package Entity
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */

/**
 * TypeOfTest
 *
 * @ExclusionPolicy("all")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\TypeOfTestRepository")
 * @ORM\Table(name="type_of_test")
 * @ORM\Entity
 */
class TypeOfTest
{
    /**
     * @var string Label of the test
     *
     * @ORM\Column(name="label", type="string", length=45, nullable=true)
     */
    private $label;

    /**
     * @var integer Id of the typeOfTest
     *
     * @ORM\Column(name="idtypeOfTest", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtypeoftest;



    /**
     * Set label
     *
     * @param string $label
     *
     * @return TypeOfTest
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get idtypeoftest
     *
     * @return integer
     */
    public function getIdtypeoftest()
    {
        return $this->idtypeoftest;
    }
}
