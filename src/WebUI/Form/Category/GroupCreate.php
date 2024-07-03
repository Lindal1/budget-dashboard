<?php
declare(strict_types=1);

namespace App\WebUI\Form\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class GroupCreate extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class, ['label' => 'Name'])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Income' => CategoryType::Income,
                    'Expense' => CategoryType::Expense,
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Save'])
            ->getForm();
    }
}
