<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;


use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function ConfigureOption(OptionResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('price', NumberType::class)
            ->add('description', TextType::class)
            /*->add('category', ChoiceType::class, [
                'choices' => [
                    'computer' => 5,
                    'furniture' => 8,
                ],
            ])*/
            ->add('save', SubmitType::class)
        ;
    }

}
