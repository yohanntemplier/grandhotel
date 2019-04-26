<?php


namespace App\Model;

class RoomManager extends AbstractManager
{

    /**
     * Gives the table name
     */
    const TABLE = 'room';


    /**
     * @var string
     */
    protected $className;
    /**
     * @var string
     */
    protected $tableToJoin;
    /**
     * @var string
     */
    protected $secondTableToJoin;

    /**
     * RoomManager constructor
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
        $this->tableToJoin = 'room_photo';
        $this->secondTableToJoin = 'room_caracteristic';
    }

    /**
     * get the table rooms joined with the tables photos and caracteristic
     * @param string $foreignKey
     * @param string $primaryKey
     * @param string $secondForeignKey
     * @return array
     *
     */
    public function selectAllTheTables(string $foreignKey, string $primaryKey, string $secondForeignKey): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table . ' JOIN ' . $this->tableToJoin . ' ON ' .
            $this->tableToJoin . '.' . $foreignKey . '=' . $this->table . '.' . $primaryKey . ' JOIN ' .
            $this->secondTableToJoin . ' ON ' .
            $this->secondTableToJoin . '.' . $secondForeignKey . '=' . $this->table . '.' . $primaryKey)->fetchAll();
    }

    /**
     * retourne table photos without ids
     * @return array
     */
    public function selectAllThePicturesWithoutIds(): array
    {

        return $this->pdo->query('SELECT photo1, photo2, photo3, photo4 FROM ' . $this->tableToJoin)->fetchAll();
    }

    /**
     * get the table caracteristics without ids
     * @return array
     */
    public function selectAllTheCaracteristicsWithoutIds(): array
    {

        return $this->pdo->query('SELECT * FROM ' . $this->secondTableToJoin)->fetchAll();
    }
}
