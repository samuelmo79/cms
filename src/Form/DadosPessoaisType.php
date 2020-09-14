<?php

namespace App\Form;

use App\Entity\DadosPessoais;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DadosPessoaisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class, [
                'label' => 'Nome *'
            ])
            ->add('sobrenome', TextType::class, [
                'label' => 'Sobrenome *'
            ])
            ->add('sexo', ChoiceType::class, [
                'label' => 'Sexo *',
                'choices' => [
                    'Sexo' => '',
                    'Masculino' => 'Masculino',
                    'Feminino' => 'Feminino',
                    'Outros' => 'Outros',
                ]
            ])
            ->add('dataNascimento', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Data Nascimento *',
                'required' => true
            ])
            ->add('cidade', TextType::class, [
                'label' => 'Cidade *'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DadosPessoais::class,
        ]);
    }
}
