<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 *
 */
class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        /*$fields = parent::configureFields($pageName);
        $fields[] = AssociationField::new('conference');
        return $fields;*/

        return [
            TextField::new('author'),
            TextEditorField::new('text'),
            TextField::new('email'),
            TextField::new('photoFilename'),
            AssociationField::new('conference')
        ];
    }
}
