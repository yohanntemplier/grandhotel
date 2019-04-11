<?php


namespace App\Model;

class RoomsManager extends AbstractManager
{
    /**
     * Gives the table name
     */
    const TABLE = 'room';

    /**
     * Gives the name to join
     */
    const TABLETOJOIN ='room_photo';

    const SECONDTABLETOJOIN='room_caracteristic';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE, self::TABLETOJOIN, self::SECONDTABLETOJOIN);
    }
}
