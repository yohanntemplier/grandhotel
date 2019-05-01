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

    /**
     * Get all rows from database, ordered by id.
     *
     * @return array
     */
    public function selectAllReviews(): array
    {
        return $this->pdo->query("SELECT * FROM $this->table ORDER BY `id` DESC")->fetchAll();
    }

    /**
     * Changes the status (online= 1, offline=0) of the review.
     * @param array $postData
     * @return bool
     */
    public function update(array $postData): bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `online` = :online WHERE id=:id");
        $statement->bindValue('id', $postData['id'], \PDO::PARAM_INT);
        $statement->bindValue('online', $postData['online'], \PDO::PARAM_BOOL);
        return $statement->execute();
    }
}
