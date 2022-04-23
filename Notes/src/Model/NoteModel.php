<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\NotFoundException;
use App\Exception\StorageException;
use App\Model\AbstractModel;
use PDO;

use Throwable;

class NoteModel extends AbstractModel implements ModelInterface
{
    public function create(array $data): void
    {
        try {

            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $created = $this->conn->quote(date('Y-m-d H:i:s'));

            $q = "INSERT INTO notes(title, description, created) VALUES($title, $description, $created)";
            $this->conn->exec($q);
        } catch (Throwable $e) {
            throw new StorageException('Error when adding note');
        }
    }

    public function get(int $id): array
    {
        try {
            $q = "SELECT * FROM notes where id = $id";
            $result = $this->conn->query($q);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('The note could not be retrieved from the database');
        }

        if (!$note) {
            throw new NotFoundException("Note on id: $id does not exist");
        }
        return $note;
    }

    public function list(
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $sortOrder
    ): array {
        return $this->findBy(
            null,
            $pageNumber,
            $pageSize,
            $sortBy,
            $sortOrder
        );
    }

    public function search(
        string $search,
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $sortOrder
    ): array {
        return $this->findBy(
            $search,
            $pageNumber,
            $pageSize,
            $sortBy,
            $sortOrder
        );
    }

    public function count(): int
    {
        try {
            $q = "SELECT count(*) AS cn FROM notes";
            $result = $this->conn->query($q);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return (int) $result['cn'];
            }
        } catch (Throwable $e) {
            throw new StorageException('The information on the number of notes in the database could not be retrieved');
        }
    }

    public function searchCount(string $search): int
    {
        try {
            $search = $this->conn->quote('%' . $search . '%', PDO::PARAM_STR);
            $q = "SELECT count(*) AS cn FROM notes WHERE title LIKE ($search)";
            $result = $this->conn->query($q);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return (int) $result['cn'];
            }
        } catch (Throwable $e) {
            throw new StorageException('The information on the number of notes in the database could not be retrieved');
        }
    }

    public function edit(int $id, array $data): void
    {
        try {
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);

            $query = "
        UPDATE notes
        SET title = $title, description = $description
        WHERE id = $id
      ";

            $this->conn->exec($query);
        } catch (Throwable $e) {
            throw new StorageException('The note could not be updated');
        }
    }

    public function delete(int $id): void
    {
        try {
            $q = "DELETE FROM notes WHERE id = $id LIMIT 1";
            $result = $this->conn->exec($q);
        } catch (\Throwable $e) {
            throw new StorageException('The note could not be deleted');
        }
    }

    private function findBy(
        ?string $search,
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $sortOrder
    ): array {
        try {
            $search = $this->conn->quote('%' . $search . '%', PDO::PARAM_STR);
            $limit = $pageSize;
            $offset = ($pageNumber - 1)  * $pageSize;
            if (!in_array($sortBy, ['created', 'title'])) {
                $sortBy = 'created';
            }
            if (!in_array($sortOrder, ['asc', 'desc'])) {
                $sortOrder = 'asc';
            }

            $wherePart = '';
            if ($search) {
                $wherePart = "WHERE title LIKE ($search)";
            }

            $q = "
            SELECT * FROM notes 
            $wherePart 
            ORDER BY $sortBy $sortOrder LIMIT $offset, $limit
            ";

            $result = $this->conn->query($q);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('Failed to retrieve notes from database');
        }
    }
}
