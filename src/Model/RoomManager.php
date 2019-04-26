<?php


namespace App\Model;

class RoomManager extends AbstractManager
{
    /**
     * Gives the table name
     */
    const TABLE = 'room';


    /**
     * RoomManager constructor
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Selects the caracteristics data for one room
     * @param string $roomId
     * @return array
     */
    public function selectCaracteristics(string $roomId): array
    {
        return $this->pdo->query(
            "SELECT  caracteristic_name FROM room
    JOIN room_caracteristic AS rc ON rc.room_id = room.id
    JOIN caracteristic ON rc.caracteristic_id = caracteristic.id 
    WHERE room.id = '$roomId';"
        )->fetchAll();
    }

    /**
     * Selects the photos for one room
     * @param string $roomId
     * @return array
     */
    public function selectPhotos(string $roomId): array
    {
        return $this->pdo->query(
            "SELECT room_photo.photo_name FROM room_photo JOIN room ON
    room_photo.room_id = room.id 
    WHERE room.id ='$roomId';"
        )->fetchAll();
    }
}
