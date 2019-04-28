<?php

namespace App\Services;

class CleanForm
{
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
     * Checks if a grade has been given, and if the grade given is authorized
     * @param array $postData
     * @param array $errors
     * @param int $minGrade
     * @param int $maxGrade
     * @param string $arrayKey
     * @return array
     */
    public function checkGrade(array $postData, array $errors, int $minGrade, int $maxGrade, string $arrayKey): array
    {
        $authorizedGrades = [];
        for ($i = $minGrade; $i <= $maxGrade; $i++) {
            $authorizedGrades[] = $i;
        }
        if (isset($postData[$arrayKey])) {
            if (!in_array($postData[$arrayKey], $authorizedGrades)) {
                $errors[$arrayKey]['interval'] = 'La note doit être choisie parmi les chiffres suivants: ' .
                    implode(" ou ", $authorizedGrades) . '.';
            }
        } else {
            $errors[$arrayKey]['noGrade'] = 'Une note doit être donnée.';
        }
        return $errors;
    }
}
