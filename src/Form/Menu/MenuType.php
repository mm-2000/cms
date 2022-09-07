<?php

namespace App\Form\Menu;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

use App\Entity\Page;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Link to Page' => 'page',
                    'Link by Href' => 'href',
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('href', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('pageId', EntityType::class, [
                'class' => Page::class,
                'choice_label' => function ($page) {
                    return $page->getTitle();
                },
                'attr' => ['class' => 'form-control'],
            ])
            ->add('Save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mt-3'],
            ])
        ;
    }
}