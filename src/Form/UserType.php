<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AMREU\UserBundle\Form\UserType as BaseUserType;
use App\Entity\Department;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends BaseUserType
{
    public function __construct($class, $allowedRoles)
    {
        parent::__construct($class, $allowedRoles);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('boss', EntityType::class, [
                'class' => User::class,
                'label' => 'user.boss',
                'placeholder' => 'placeholder.choose',
            ])
            ->add('department', EntityType::class, [
                'class' => Department::class,
                'label' => 'user.department',
                'placeholder' => 'placeholder.choose',
                'constraints' => [
                    new NotBlank()
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'password_change' => false,
            'readonly' => false,
        ]);
    }
}
