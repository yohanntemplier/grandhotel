<?php

namespace App\Services;

class AddPictures
{

    /**
     * check if the size of each picture is less than what is authorized
     * @param array $errors
     * @param int $maxSize
     * @return array
     */
    public function checkSize(array $errors, int $maxSize): array
    {
        if (!empty($_FILES['photo']['tmp_name'][0])) {
            foreach ($_FILES['photo']['tmp_name'] as $file) {
                if ((filesize($file)) > $maxSize * 1000) {
                    $errors['photo']['filesize'] = 'La taille de chaque fichier ne peut excéder ' . $maxSize . ' ko.';
                }
            }
        }
        return $errors;
    }

    /**
     * checks if each file is an authorized type
     * @param array $acceptedFiles
     * @param array $errors
     * @return array
     */
    public function checkType(array $acceptedFiles, array $errors): array
    {
        if (!empty($_FILES['photo']['tmp_name'][0])) {
            foreach ($_FILES['photo']['tmp_name'] as $key => $file) {
                $fileContent = explode('/', mime_content_type($file));
                if ((!in_array($fileContent[1], $acceptedFiles)) || $fileContent[0] != 'image') {
                    $errors['photo']['filetype'] = 'Vos fichiers doivent être une image de type '
                        . implode(' ou ', $acceptedFiles) . ' .';
                }
            }
        }
        return $errors;
    }

    /**
     * gives an unique name for each picture
     * @return array
     */
    public function changePhotoName()
    {
        $photos = [];
        foreach ($_FILES['photo']['name'] as $photo) {
            if (isset($photo)) {
                $photos[] = uniqid() . $photo;
            }
        }
        return $photos;
    }

    /**
     * Transfers the checked files in the folder upload
     * @param array $photoName
     */
    public function transferFiles(array $photoName): void
    {
        foreach ($photoName as $key => $photo) {
            if (isset($photo)) {
                move_uploaded_file($_FILES['photo']['tmp_name'][$key], 'assets/images/rooms/' . $photo);
            }
        }
    }
}
