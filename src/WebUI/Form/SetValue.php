<?php
declare(strict_types=1);

namespace App\WebUI\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UuidType;
use Symfony\Component\Form\FormBuilderInterface;

class SetValue extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('month', ChoiceType::class, [
                'label' => 'Month',
                'required' => true,
                'choices' => [
                    'January' => '1',
                    'February' => '2',
                    'March' => '3',
                    'April' => '4',
                    'May' => '5',
                    'June' => '6',
                    'July' => '7',
                    'August' => '8',
                    'September' => '9',
                    'October' => '10',
                    'November' => '11',
                    'December' => '12',
                ],
            ])
            ->add('year', TextType::class, [
                'label' => 'Year',
                'required' => true,
            ])
            ->add('value', TextType::class, [
                'label' => 'Value',
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Set',
            ]);
    }
}
