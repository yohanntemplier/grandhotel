<?php

namespace App\Services;

class CleanForm
{
    /**
     * checks if the concerned rubric is not empty
     * @param array $postData
     * @param string $label
     * @param array $errors
     * @return array
     */
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


    /**
     * checks if the price is numeric and higher than 0.
     * @param array $postData
     * @param array $errors
     * @return array
     */
    public function checkPrice(array $postData, array $errors): array
    {
        if (($postData['price'] < 0) || (!is_numeric($postData['price']))) {
            $errors['price'] = 'Entrez un nombre supérieur à zéro.';
        }
        return $errors;
    }

    /**
     * Checks if the caracteristics choosen exists in the caracteristic list in the database
     * @param array $caracteristics
     * @param array $existingCaracteristics
     * @param array $errors
     * @return array
     */
    public function checkCaracteristics(array $caracteristics, array $existingCaracteristics, array $errors): array
    {
        $caracteristicsIds=[];
        foreach ($existingCaracteristics as $existingCaracteristic) {
            $caracteristicsIds[] = $existingCaracteristic['id'];
        }

        foreach ($caracteristics as $key => $caracteristic) {
            if (!in_array($caracteristic, $caracteristicsIds)) {
                $errors['caracteristic'][$key] = "Cette caractéristique n'existe pas.";
            }
        }
        return $errors;
    }
}
