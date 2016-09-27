<?php
/**
 * This file defines the TestCompanyType
 *
 * @category ProjectType
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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
/**
 * Class TestCompanyType
 *
 * @package Form
 * @author Fondative <devteam@fondative.com>
 * @copyright 2015-2016 Fondative
 * @version 1.0.0
 * @since Class available since Release 1.0.0
 *
 */
class TestCompanyType extends AbstractType
{
    /**
     * Build the Form
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text')
            ->add('testCase', EntityType::class, array(
                'class' => 'AppBundle:TestCase',
                'choice_label' => 'idtestCase',
                 'multiple' => true,

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
            'data_class' => 'AppBundle\Entity\TestCompany',
            'csrf_protection'   => false,
        ));
    }
    /**
     * Getter of name
     * @return string
     */
    public function getName()
    {
        return 'testCompany';
    }
}
