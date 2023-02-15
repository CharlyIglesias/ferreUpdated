<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CotizacionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Nombre(s) *',
            'required' => true, 
            'attr' => [
                'class' =>'form-control', 
                'id' => 'nameInputContact',
            ]
        ])
        ->add('email', EmailType::class, [
            'label' => '',
            'required' => true, 
            'attr' => [
                'class' =>'form-control', 
                'id' => 'emailInputModal',
            ]
        ])
        ->add('phone', TelType::class, [
            'label' => 'Teléfono',
            'required' => true, 
            'attr' => [
                'class' =>'form-control', 
                'id' => 'phoneInputModal',
            ]
        ])
        ->add('message', TextAreaType::class, [
            'label' => '¿Qué necesitas cotizar?',
            'required' => true, 
            'attr' => [
                'class' =>'form-control', 
                'id' => 'messageInputModal',
                'placeholder' => 'Color, tamaño, medidas, etc...',
                'rows' => 3,
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Obtener Cotización',
            'attr' => [
                'class' => 'btn btn-outline-success'
            ]
        ]);
    }
}
