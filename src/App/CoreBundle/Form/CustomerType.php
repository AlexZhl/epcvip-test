<?php

namespace App\CoreBundle\Form;

use App\CoreBundle\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('email', EmailType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('dateOfBirth', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'invalid_message' => 'This value is not valid. Format: yyyy-mm-dd',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    Customer::STATUS_NEW,
                    Customer::STATUS_PENDING,
                    Customer::STATUS_INREVIEW,
                    Customer::STATUS_APPROVED,
                    Customer::STATUS_INACTIVE,
                    Customer::STATUS_DELETED,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Customer::class,
        ));
    }
}