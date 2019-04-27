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
     * Checks if the ID exists
     * @param int $id
     * @param array $ids
     * @param array $errors
     * @return array
     */
    public function checkId(int $id, array $ids, array $errors): array
    {
        if (!in_array($id, $ids)) {
            $errors[$id] = "Le champ n'est pas rempli correctement.";
        }
        return $errors;
    }
}
