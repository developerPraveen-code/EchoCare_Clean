<?php

// SHARED DATABASE CONNECTION
// BCE Support Role: Database helper
// Purpose: Provides MySQL connection for persistent storage.
// Current prototype may still use PHP session data for demo stability,
// but this file shows how Entity classes can connect to MySQL.

class Database
{
    private string $host = 'localhost';
    private string $database = 'echocare_db';
    private string $username = 'root';
    private string $password = '';

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