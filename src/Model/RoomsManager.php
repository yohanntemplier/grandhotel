<?php


namespace App\Model;


class RoomsManager extends AbstractManager
{
    /**
     * Gives the table name
     */
    const TABLE = 'room';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }





}