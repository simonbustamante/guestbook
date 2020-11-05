<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Conference;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Vich\UploaderBundle\Form\Type\VichImageType;


class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $imagefile = ImageField::new('photo')->setFormType(VichImageType::class);
        $image = ImageField::new('photoFilename')->setBasePath('/images/photos');
        $fields = [
            TextField::new('author'),
            TextEditorField::new('text'),
            EmailField::new('email'),
            DateField::new('createdAt'),
            TextField::new('state'),
            AssociationField::new('conference'),//->autocomplet()
            
        ];
        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL){
            $fields[]=$image;
        }else{
            $fields[]=$imagefile;
        }
        return $fields;
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('email')
            ->add('createdAt')
            ->add('conference')
            ->add('author')
            ->add('state')
        ;
    }
    
}
