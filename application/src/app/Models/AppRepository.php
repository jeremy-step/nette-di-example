<?php

namespace App\Models;

class AppRepository
{
    private \PDO $db;

    function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function createTable(): void
    {
        $s = $this->db->prepare(
            <<<'SQL'
                CREATE TABLE IF NOT EXISTS example (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                record VARCHAR(50)
                )
            SQL
        );

        $s->execute();
    }

    public function createRecord(): void
    {
        $s = $this->db->prepare('INSERT INTO example (record) VALUES (?)');
        $s->execute([(string) rand(100000, 999999)]);
    }

    public function getLatestRecord(): int
    {
        $s = $this->db->prepare('SELECT record AS record FROM example ORDER BY id DESC LIMIT 1');
        $s->execute();

        return (int) $s->fetch()['record'];
    }
}
