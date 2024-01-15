<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoanSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('fromDate',  DateType::class,[
            'widget' => 'single_text',
            'html5' => false,
            'format' => 'yyyy-MM-dd',
            'label' => 'loanSearch.fromDate',
            'required' => false,
        ])
        ->add('toDate',  DateType::class,[
            'widget' => 'single_text',
            'html5' => false,
            'format' => 'yyyy-MM-dd',
            'label' => 'loanSearch.toDate',
            'required' => false,
        ])
        ->add('fromDateOfLoan',  DateType::class,[
            'widget' => 'single_text',
            'html5' => false,
            'format' => 'yyyy-MM-dd',
            'label' => 'loanSearch.fromDateOfLoan',
            'required' => false,
        ])
        ->add('toDateOfLoan',  DateType::class,[
            'widget' => 'single_text',
            'html5' => false,
            'format' => 'yyyy-MM-dd',
            'label' => 'loanSearch.toDateOfLoan',
            'required' => false,
        ])
        ->add('fromDateOfReturn',  DateType::class,[
            'widget' => 'single_text',
            'html5' => false,
            'format' => 'yyyy-MM-dd',
            'label' => 'loanSearch.fromDateOfReturn',
            'required' => false,
        ])
        ->add('toDateOfReturn',  DateType::class,[
            'widget' => 'single_text',
            'html5' => false,
            'format' => 'yyyy-MM-dd',
            'label' => 'loanSearch.toDateOfReturn',
            'required' => false,
        ])
        ->add('askedBy',  EntityType::class,[
            'class' => User::class,
            'label' => 'loanSearch.askedBy',
            'required' => false,
            'placeholder' => 'placeholder.askedBy',
        ])
        ->add('status',  ChoiceType::class,[
            'choices' => [
                'loanSearch.notReturned' => 'notReturned',
                'loanSearch.asked' => 'asked',
                'loanSearch.loaned' => 'loaned',
                'loanSearch.returned' => 'returned',
            ],
            'placeholder' => 'option.selectStatus',
            'label' => 'loanSearch.status',
            'required' => false,
            'data' => 'notReturned',
        ])
        ->add('signature',null,[
            'label' => 'loanSearch.signature',
            'required' => false,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
