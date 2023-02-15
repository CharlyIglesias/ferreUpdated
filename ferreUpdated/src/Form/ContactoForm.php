<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactoForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', EmailType::class, [
            'label' => false,
            'required' => true, 
            'attr' => [
                'class' =>'form-control', 
                'id' => 'emailInputContact',
                'placeholder' => 'Email *',
            ]
        ])
        ->add('name', TextType::class, [
            'label' => false,
            'required' => true, 
            'attr' => [
                'class' =>'form-control', 
                'id' => 'nameInputContact',
                'placeholder' => 'Nombre(s) *',
            ]
        ])
        ->add('asunto', TextType::class, [
            'label' => false,
            'required' => true, 
            'attr' => [
                'class' =>'form-control', 
                'id' => 'asuntoInputContact',
                'placeholder' => 'Asunto *',
            ]
        ])
        ->add('message', TextAreaType::class, [
            'label' => false,
            'required' => false, 
            'attr' => [
                'class' =>'form-control', 
                'id' => 'messageInputContact',
                'placeholder' => 'Mensaje...',
                'rows' => 3
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Enviar',
            'attr' => [
                'class' => 'btn btn-outline-success'
            ]
        ]);
    }
}
