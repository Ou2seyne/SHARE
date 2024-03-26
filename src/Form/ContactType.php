<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builde, array $options): void
{
    $builde
->add('nom', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=>
'fw-bold' ]])
->add('sujet', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=>
'fw-bold']])
->add('email', EmailType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=>
'fw-bold']])
->add('message', TextareaType::class, ['attr' => ['class'=> 'form-control', 'rows'=>'7', 'cols'
=> '7'], 'label_attr' => ['class'=> 'fw-bold']])
->add('envoyer', SubmitType::class, ['attr' => ['class'=> 'btn bg-primary text-white m-4' ],
'row_attr' => ['class' => 'text-center'],])
;
}

    public function configureOptions(OptionsResolver $resolve): void
    {
        $resolve->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
