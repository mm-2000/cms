<?php

namespace App\Form\Page;

use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('content', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function ($category) {
                    return $category->getName();
                },
                'attr' => ['class' => 'form-control'],
            ])
            ->add('tags', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mt-3'],
            ])
        ;
    }
}