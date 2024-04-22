<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class TimeZoneFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', TextType::class, [
                'label' => 'Date (Y-m-d): ',
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^\d{4}-\d{2}-\d{2}$/',
                        'message' => 'Please enter a valid date in the format Y-m-d.',
                    ]),
                ],
            ])
            ->add('timezone', TextType::class, [
                'label' => 'Timezone: ',
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+\/[a-zA-Z]+$/', // ^[a-zA-Z0-9_-]+\/[a-zA-Z0-9_-]+$
                        'message' => 'Please enter a valid date in the format Continent/City.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}