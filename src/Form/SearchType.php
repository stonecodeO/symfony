<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Search;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recherche',TextType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]])
            ->add('categories',EntityType::class,[
                'required' => false,
                'label' =>false,
                'placeholder' =>'aucune',
                'class' => Category::class
                ])
            ->add('prixMin',NumberType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prix min'
                ]])
            ->add('prixMax',NumberType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prix max'
                ]])
            ->add('promo',CheckboxType::class,[
                'required' => false,
                'label' => 'En promotion'
                ])
            ->add('Appliquer',SubmitType::class,[
                'attr' => [
                    'class' => 'btn-success',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}
