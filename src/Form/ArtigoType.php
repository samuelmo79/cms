<?php

namespace App\Form;

use App\Entity\Artigo;
use App\Entity\Categoria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArtigoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('conteudo')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Publicado' => 'P',
                    'Inativo' => 'I',
                    'Excluido' => 'E',
                    'Arquivado' => 'A'
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Imagem do Artigo',
                'required' => false,
                'allow_delete' => false,
                'download_label' => '',
                'image_uri' => false,
            ])
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'nome'
            ])
            ->add('destaque')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artigo::class,
        ]);
    }
}
