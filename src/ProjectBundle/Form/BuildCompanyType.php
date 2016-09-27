<?php
/**
 * This file defines the BuildCompanyType
 *
 * @category ProjectBundle
 * @package Form
 * @author Fondative <dev devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since File available since Release 1.0.0
 */
namespace ProjectBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
/**
 * Class BuildCompanyType
 *
 * @package Form
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */

class BuildCompanyType extends AbstractType
{

    /**
     * Build the Form
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('testCompany', EntityType::class, array(
                'class' => 'AppBundle:TestCompany',
                'choice_label' => 'idtestCompany',
            ))


        ;
    }

    /**
     * Configuration of the Form
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Build',
            'csrf_protection'   => false,
        ));
    }

    /**
     * Getter of name
     * @return string
     */
    public function getName()
    {
        return 'build';
    }
}
