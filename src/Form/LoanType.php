<?php

namespace App\Form;

use App\Entity\Loan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $roles = $options['roles'];
        $readonly = $options['readonly'];
        $builder
            ->add('description', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 255,
                    ])
                ],
                'disabled' => $readonly,
                'label' => 'loan.description',
            ])->add('note',TextareaType::class,[
                'disabled' => $readonly,
                'label' => 'loan.note',
                'constraints' => [
                    new Length([
                        'max' => 1024,
                    ])
                ],
            ]);
            if ( in_array('ROLE_ARCHIVER', $roles) || in_array('ROLE_ADMIN', $roles) ) {
                $builder
                    ->add('signature',null,[
                            'disabled' => $readonly,  
                            'label' => 'loan.signature',
                        ])
                    ->add('askedBy',null,[
                        'disabled' => $readonly,
                        'label' => 'loan.askedBy',
                    ])
                    ->add('date',  DateType::class,[
                        'widget' => 'single_text',
                        'html5' => false,
                        'format' => 'yyyy-MM-dd',
                        'disabled' => $readonly,
                        'label' => 'loan.date',
                    ])
                    ->add('dateOfLoan',  DateType::class,[
                        'widget' => 'single_text',
                        'html5' => false,
                        'format' => 'yyyy-MM-dd',
                        'disabled' => $readonly,
                        'label' => 'loan.dateOfLoan',
                    ])
                    ->add('dateOfReturn',  DateType::class,[
                        'widget' => 'single_text',
                        'html5' => false,
                        'format' => 'yyyy-MM-dd',
                        'disabled' => $readonly,
                        'label' => 'loan.dateOfReturn',
                    ]);
            }
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Loan::class,
            'readonly' => false,
            'roles' => [],
        ]);
    }
}
