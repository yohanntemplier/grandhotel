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
}
