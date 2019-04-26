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
     * Selects the photos for one room
     * @param int $roomId
     * @return array
     */
    public function selectPhotos(int $roomId): array
    {
        return $this->pdo->query(
            "SELECT photo_name FROM room_photo JOIN room ON room_photo.room_id = room.id 
            WHERE room.id ='$roomId';"
        )->fetchAll();
    }
}
