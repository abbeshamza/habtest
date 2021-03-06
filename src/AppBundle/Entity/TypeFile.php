<?php
/**
 * This file defines the TypeFileEntity
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
 * TypeFile
 *
 *
 * @ExclusionPolicy("all")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\TypeFileRepository")
 * @ORM\Table(name="type_file")
 * @ORM\Entity
 */
class TypeFile
{
    /**
     *  @Expose
     * @var integer Id of the TypeFile
     *
     * @ORM\Column(name="idtype", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtype;

    /**
     *  @Expose
     * @var string Label of the TypeFIle
     *
     * @ORM\Column(name="label", type="string", length=45, nullable=true)
     */
    private $label;



    /**
     * Set label
     *
     * @param string $label
     *
     * @return TypeFile
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
     * Get idtype
     *
     * @return integer
     */
    public function getIdtype()
    {
        return $this->idtype;
    }
}
