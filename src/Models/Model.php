<?php

namespace Tamicktom\Lockbox\Models;

use PDO;
use Tamicktom\Lockbox\Core\Database;

abstract class Model
{
  protected string $table;
  protected string $primaryKey = 'id';

  protected function pdo(): PDO
  {
    return Database::connection();
  }

  public function find(int|string $id): array|null
  {
    $sql = sprintf('SELECT * FROM %s WHERE %s = :id LIMIT 1', $this->table, $this->primaryKey);
    $stmt = $this->pdo()->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row === false ? null : $row;
  }

  /**
   * @param array<string, scalar|null> $attributes
   */
  public function create(array $attributes): int|string
  {
    $columns = array_keys($attributes);
    $placeholders = array_map(fn($c) => ':' . $c, $columns);
    $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->table, implode(', ', $columns), implode(', ', $placeholders));
    $stmt = $this->pdo()->prepare($sql);

    foreach ($attributes as $column => $value) {
      $stmt->bindValue(':' . $column, $value);
    }

    $stmt->execute();
    $lastId = $this->pdo()->lastInsertId();
    return $lastId !== '' ? $lastId : (int) $attributes[$this->primaryKey] ?? 0;
  }

  /**
   * @param array<string, scalar|null> $attributes
   */
  public function update(int|string $id, array $attributes): int
  {
    $set = implode(', ', array_map(fn($c) => $c . ' = :' . $c, array_keys($attributes)));
    $sql = sprintf('UPDATE %s SET %s WHERE %s = :id', $this->table, $set, $this->primaryKey);
    $stmt = $this->pdo()->prepare($sql);

    foreach ($attributes as $column => $value) {
      $stmt->bindValue(':' . $column, $value);
    }
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->rowCount();
  }

  public function delete(int|string $id): int
  {
    $sql = sprintf('DELETE FROM %s WHERE %s = :id', $this->table, $this->primaryKey);
    $stmt = $this->pdo()->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->rowCount();
  }

  /**
   * @return list<array>
   */
  public function all(): array
  {
    $sql = sprintf('SELECT * FROM %s', $this->table);
    $stmt = $this->pdo()->query($sql);
    return $stmt->fetchAll();
  }
}
