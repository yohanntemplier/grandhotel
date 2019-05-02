<?php

namespace App\Model;

class AdminServicesManager extends AbstractManager
{

    const TABLE = 'caracteristic';

    /**
     * RoomManager constructor
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Needed : those are used with checkboxes
     * @return array
     */
    public function selectAllCaracteristics():array
    {
        return $this->pdo->query("SELECT * FROM $this->table ;")->fetchAll();
    }

    /**
     * Transfers the caracteristic name to the database
     * @param array $data
     * @return string
     */
    public function insert(array $data)
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`caracteristic_name`)
        VALUES ( :caracteristic_name);");
        $statement->bindValue('caracteristic_name', $data['caracteristic_name'], \PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * Deletes the caracteristic
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
