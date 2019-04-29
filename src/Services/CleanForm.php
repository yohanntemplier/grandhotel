<?php


namespace App\Services;

class CleanForm
{
    public function checkIfEmpty(array $postData, string $label, array $errors): array
    {
        if (empty($postData[$label])) {
            $errors[$label]['empty'] = "Ce champ doit être rempli.";
        }
        return $errors;
    }
    /**
     * trims the item.
     * @param string $itemToTrim
     * @return string
     */
    public function trim(string $itemToTrim):string
    {
        $itemToTrim= trim($itemToTrim);
        return $itemToTrim;
    }
    /**
     * checks if the concerned rubric is filled with less than the number of caracters authorized
     * @param string $postData
     * @param array $errors
     * @param int $maxLength
     * @param string $key
     * @return array
     */
    public function checkMaxLength(string $postData, array $errors, int $maxLength, string $key): array
    {
        if (strlen($postData) > $maxLength) {
            $errors[$key]['length'] = 'Cette rubrique ne doit pas dépasser ' . $maxLength . ' caractères.';
        }
        return $errors;
    }
}
