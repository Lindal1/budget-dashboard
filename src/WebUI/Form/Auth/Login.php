<?php
declare(strict_types=1);

namespace App\WebUI\Form\Auth;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class Login extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'email',
            EmailType::class,
            [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(['message' => 'Please enter your email address.']),
                    new Email(['message' => 'Please enter a valid email address.']),
                ],
            ],
        )
            ->add(
                'password',
                PasswordType::class,
                [
                    'label' => 'Password',
                    'constraints' => [
                        new NotBlank(['message' => 'Please enter your password.']),
                    ],
                ]
            )
            ->add('login', SubmitType::class, ['label' => 'Login'])
            ->getForm();

        
    }
}
