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
    const TABLETOJOIN = 'room_photo';
    /**
     * give the name of the second table joined
     */
    const SECONDTABLETOJOIN = 'room_caracteristic';


    /**
     * @var string
     */
    protected $className;
    /**
     * @var string
     */
    protected $tableToJoin;

    protected $secondTableToJoin;


    public function __construct()
    {
        parent::__construct(self::TABLE);
        $this->tableToJoin = self::TABLETOJOIN;
        $this->secondTableToJoin = self::SECONDTABLETOJOIN;
    }

    /**
     * get one table joined with two other tables
     * @param string $foreignKey
     * @param string $primaryKey
     * @param string $secondForeignKey
     * @return array
     */
    public function selectAllDoubleJoin(string $foreignKey, string $primaryKey, string $secondForeignKey): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table . ' JOIN ' . $this->tableToJoin . ' ON ' .
            $this->tableToJoin . '.' . $foreignKey . '=' . $this->table . '.' . $primaryKey . ' JOIN ' .
            $this->secondTableToJoin . ' ON ' .
            $this->secondTableToJoin . '.' . $secondForeignKey . '=' . $this->table . '.' . $primaryKey)->fetchAll();
    }

    /**
     * get one of the two tables joined without ids
     * @return array
     */
    public function selectQuiteAllFromFirstJoined(): array
    {

        return $this->pdo->query('SELECT photo1, photo2, photo3, photo4 FROM ' . $this->tableToJoin)->fetchAll();
    }

    /**
     * get the second of the two tables joined without ids
     * @return array
     */
    public function selectQuiteAllFromSecondJoined(): array
    {

        return $this->pdo->query('SELECT * FROM ' . $this->secondTableToJoin)->fetchAll();
    }
}
