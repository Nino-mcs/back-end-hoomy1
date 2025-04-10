<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField; // Ajout de ChoiceField pour le type
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageCrudController extends AbstractCrudController
{
    public const ALBUM_BASE_PATH = 'images';
    public const ALBUM_UPLOAD_DIR = 'public/images';

    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des images')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter une image')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier une image');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ImageField::new('image_path', 'Image')
                ->setBasePath(self::ALBUM_BASE_PATH)
                ->setUploadDir($this->getUploadDirByType(new Image())) // Appel direct à la méthode pour déterminer le dossier
                ->setUploadedFileNamePattern(
                    fn(UploadedFile $file): string => sprintf(
                        'upload_%d_%s.%s',
                        mt_rand(1, 999),
                        $file->getFilename(),
                        $file->guessExtension()
                    )
                ),
            ChoiceField::new('type', 'Type de l\'image')
                ->setChoices([
                    'Avatar' => 'avatar',
                    'Playlist' => 'playlist',
                    'Room' => 'room',
                    'Vibe' => 'vibe',
                ])
                ->setHelp('Sélectionner le type d\'image (ex : avatar, playlist, etc.)')
                ->setRequired(true)
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(
                Crud::PAGE_INDEX,
                Action::NEW,
                fn(Action $action) => $action
                    ->setIcon('fa fa-plus')
                    ->setLabel('Ajouter')
                    ->setCssClass('btn btn-success')
            )
            ->update(
                Crud::PAGE_INDEX,
                Action::EDIT,
                fn(Action $action) => $action
                    ->setIcon('fa fa-pen')
                    ->setLabel('Modifier')
            )
            ->update(
                Crud::PAGE_INDEX,
                Action::DELETE,
                fn(Action $action) => $action
                    ->setIcon('fa fa-trash')
                    ->setLabel('Supprimer')
            )
            ->update(
                Crud::PAGE_EDIT,
                Action::SAVE_AND_RETURN,
                fn(Action $action) => $action
                    ->setLabel('Enregistrer et quitter')
            )
            ->update(
                Crud::PAGE_EDIT,
                Action::SAVE_AND_CONTINUE,
                fn(Action $action) => $action
                    ->setLabel('Enregistrer et continuer')
            )
            ->update(
                Crud::PAGE_NEW,
                Action::SAVE_AND_RETURN,
                fn(Action $action) => $action
                    ->setLabel('Enregistrer et quitter')
            )
            ->update(
                Crud::PAGE_NEW,
                Action::SAVE_AND_ADD_ANOTHER,
                fn(Action $action) => $action
                    ->setLabel('Enregistrer et ajouter un nouveau')
            );
    }

    // Cette fonction va retourner le dossier d'upload en fonction du type d'image
    private function getUploadDirByType(Image $image): string
    {
        // Exemple de logique pour déterminer le dossier d'upload
        if ($image->getType() === 'avatar') {
            return 'public/images/avatars'; // dossier des avatars
        }

        if ($image->getType() === 'playlist') {
            return 'public/images/playlists'; // dossier des playlists
        }

        if ($image->getType() === 'room') {
            return 'public/images/rooms'; // dossier des playlists
        }

        if ($image->getType() === 'vibe') {
            return 'public/images/vibes'; // dossier des playlists
        }

        // Default upload directory if no type matches
        return self::ALBUM_UPLOAD_DIR;
    }
}
