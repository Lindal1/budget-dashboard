<?php
declare(strict_types=1);

namespace App\WebUI\Form\Category;

use App\Domain\Category\Enum\CategoryType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UpdateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class, ['label' => 'Name'])
            ->add('save', SubmitType::class, ['label' => 'Save'])
            ->getForm();
    }
}
