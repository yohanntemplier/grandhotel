<?php

namespace App\Model;

class AdminRoomManager extends AbstractManager
{

    const TABLE = 'room';

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
    public function selectAllCaracteristics()
    {
        return $this->pdo->query('SELECT * FROM caracteristic ;')->fetchAll();
    }

    /**
     * Transfers the room data to the database
     * @param array $data
     * @return string
     */
    public function insert(array $data)
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO `room` (`name` , `description` , `price`)
        VALUES ( :name, :description, :price );");
        $statement->bindValue('name', $data['name'], \PDO::PARAM_STR);
        $statement->bindValue('description', $data['description'], \PDO::PARAM_STR);
        $statement->bindValue('price', $data['price'], \PDO::PARAM_INT);
        if ($statement->execute()) {
            return $this->pdo->lastInsertId();
        }
    }

    /**
     * transfers the caracteristic data to the database
     * @param array $data
     */
    public function insertCaracteristics(array $data): void
    {
        foreach ($data['caracteristic'] as $caracteristic) {
            $statement = $this->pdo->prepare("INSERT INTO `room_caracteristic`
            (`room_id`,`caracteristic_id`)
            VALUES(:room_id, :caracteristic_id);");
            $statement->bindValue('room_id', $data['roomId'], \PDO::PARAM_STR);
            $statement->bindValue('caracteristic_id', $caracteristic, \PDO::PARAM_INT);
            $statement->execute();
        }
    }

    /**
     * transfers the photos names in the database (only the names, not the files!)
     * @param array $photos
     */
    public function addPhotosNamesInDatabase(array $photos): void
    {
        foreach ($photos['pictures'] as $photo) {
            $statement = $this->pdo->prepare("INSERT INTO `room_photo`
            (`room_id`,`photo_name`)
            VALUES (:room_id, :photo_name);");
            $statement->bindValue('room_id', $photos['roomId'], \PDO::PARAM_INT);
            $statement->bindValue('photo_name', $photo, \PDO::PARAM_STR);
            $statement->execute();
        }
    }

    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * @param string $roomId
     * @return array
     */
    public function selectPhotoToDelete(string $roomId): array
    {
        return $this->pdo->query(
            "SELECT photo_name FROM room_photo AS rp JOIN room ON
    rp.room_id = room.id 
    WHERE room.id ='$roomId';"
        )->fetchAll();
    }
}
