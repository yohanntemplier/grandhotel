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
}
