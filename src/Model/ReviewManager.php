<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class ReviewManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'review';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     *Selects all the reviews that administrator agreed that it could be published
     * @return array
     */
    public function selectAllOnLine()
    {
        return $this->pdo->query('SELECT name, comment, grade, date FROM review WHERE online =1;')->fetchAll();
    }
}
