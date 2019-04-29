<?php

namespace App\Services;

class CleanForm
{
    /**
     * Checks if a bool is returned by $_POST
     * @param array $errors
     * @param int $id
     * @return array
     */
    public function checkIfBool(array $errors, int $id): array
    {
        if (!in_array($_POST['online'], [0, 1])) {
            $errors[$id] = "Le champ n'est pas rempli correctement.";
           }
        return $errors;
    }       
    /**
     * Checks if all the required data is set.
     * @param string $rubric
     * @param array $errors
     * @param string $key
     * @return array
     */
    public function checkIfEmpty(string $rubric, array $errors, string $key): array
    {
        if (empty($rubric)) {
            $errors[$key]['empty'] = "Ce champ doit être rempli.";
        }
        return $errors;
    }

    /**
     * Checks if the text respects the form rule Mac Length
     * @param string $data
     * @param array $errors
     * @param int $maxLength
     * @param string $key
     * @return array
     */
    public function checkMaxLength(string $data, array $errors, int $maxLength, string $key): array
    {
        if (strlen($data) > $maxLength) {
            $errors[$key]['length'] = 'Cette rubrique ne doit pas dépasser ' . $maxLength . ' caractères.';
        }
        return $errors;
    }

    /**
     * Checks if a value is in aarray. If no, returns an error.
     * @param string $dataToCheck
     * @param array $errors
     * @param array $inArray
     * @param string $errorName
     * @return array
     */
    public function checkifInArray(string $dataToCheck, array $errors, array $inArray, string $errorName): array
    {
        if (!in_array($dataToCheck, $inArray)) {
            $errors[$errorName] = 'La valeur saisie ne fait pas partie des valeurs suivantes: ' .
                implode(" ou ", $inArray) . '.';
        }
        return $errors;
    }
}
