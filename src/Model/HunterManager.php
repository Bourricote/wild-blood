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
class HunterManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'hunter';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $hunter
     * @return int
     */
    public function insert(array $hunter): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`name`, `description`, `picture`, `level`, `score`) 
VALUES (:name, :description, :picture, :level, :score)");
        $statement->bindValue('name', $hunter['name'], \PDO::PARAM_STR);
        $statement->bindValue('description', $hunter['description'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $hunter['picture'], \PDO::PARAM_STR);
        $statement->bindValue('level', $hunter['level'], \PDO::PARAM_INT);
        $statement->bindValue('score', $hunter['score'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }


    /**
     * @param array $hunter
     * @return bool
     */
    public function update(array $hunter): bool
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table 
            SET `name` = :name, `description` = :description, `picture` = :picture, `level` = :level, `score` = :score 
            WHERE id=:id");
        $statement->bindValue('id', $hunter['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $hunter['name'], \PDO::PARAM_STR);
        $statement->bindValue('description', $hunter['description'], \PDO::PARAM_STR);
        $statement->bindValue('picture', $hunter['picture'], \PDO::PARAM_STR);
        $statement->bindValue('level', $hunter['level'], \PDO::PARAM_INT);
        $statement->bindValue('score', $hunter['score'], \PDO::PARAM_INT);

        return $statement->execute();
    }

    public function updateScore($hunter)
    {
        $statement = $this->pdo->prepare("UPDATE $this->table 
            SET score = score + " . $hunter['hunter_points'] . " WHERE id = :id");
        $statement->bindValue('id', $hunter['hunter_id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}
