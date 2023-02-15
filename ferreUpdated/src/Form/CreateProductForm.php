<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Repository\FamilyRepository;
use App\Repository\BrandRepository;

use App\Entity\Family;
use App\Entity\Brand;
use App\Entity\Product;

class CreateProductForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class, [
                'required'   => true,
                'mapped' => false
            ])
            ->add('familiaId', HiddenType::class, [
                'label' => "familiaId",
                'required'   => true,
                'mapped' => false
            ])
            ->add('familiaName', HiddenType::class, [
                'label' => "familiaName",
                'required'   => true,
                'mapped' => false
            ])
            ->add('marcaId', HiddenType::class, [
                'label' => "marcaId",
                'required'   => true,
                'mapped' => false
            ])
            ->add('marcaName', HiddenType::class, [
                'label' => "marcaName",
                'required'   => true,
                'mapped' => false
            ])
            ->add('name', HiddenType::class, [
                'label' => "nombre",
                'required'   => true,
                'mapped' => true
            ])
            ->add('description', HiddenType::class, [
                'label' => "Description",
                'required'   => true,
                'mapped' => true
            ])
            ->add('imageLink', HiddenType::class, [
                'label' => "Image Url",
                'required'   => true,
                'mapped' => true
            ])
            ->add('inStock', HiddenType::class, [
                'label' => "En Stock",
                'required'   => true,
                'mapped' => true
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Guardar",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
