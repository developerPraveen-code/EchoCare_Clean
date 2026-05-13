<?php

// SHARED DATABASE CONNECTION
// BCE Support Role: Database helper
// Purpose: Provides MySQL connection for persistent storage.
// Current prototype may still use PHP session data for demo stability,
// but this file shows how Entity classes can connect to MySQL.

class Database
{
    private string $host;
    private string $database;
    private string $username;
    private string $password;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'] ?? 'localhost';
        $this->database = $_ENV['DB_NAME'] ?? 'echocare_db';
        $this->username = $_ENV['DB_USER'] ?? 'root';
        $this->password = $_ENV['DB_PASS'] ?? '';
    }

    public function connect(): PDO
    {
        try {
            $pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;

        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
}