<?php

namespace App\Model;

class AdminReviewManager extends AbstractManager
{
    const TABLE = 'review';

    /**
     * RoomManager constructor
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function update(): bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `online` = :online WHERE id=:id");
        $statement->bindValue('id', $_POST['id'], \PDO::PARAM_INT);
        $statement->bindValue('online', $_POST['online'], \PDO::PARAM_BOOL);
        return $statement->execute();
    }
}
