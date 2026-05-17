<?php

// SHARED DATABASE CONNECTION
// BCE Support Role: Database helper
// Purpose: Provides MySQL connection for persistent storage.

class Database
{
    private string $host = 'localhost';
    private string $database = 'echocare_db';
    private string $username = 'root';
    private string $password = '';

    private ?PDO $conn = null;

    public function connect(): PDO
    {
        if ($this->conn === null) {

            try {
                $this->conn = new PDO(
                    "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4",
                    $this->username,
                    $this->password
                );

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }

        return $this->conn;
    }
}