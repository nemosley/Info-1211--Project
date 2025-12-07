<?php
/**
 * Database connection class using singleton pattern.
 */

class Database extends mysqli
{
    private static $db = null;

    private function __construct()
    {
        // Make sure these constants are defined in config.php
        parent::__construct(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($this->connect_errno) {
            die('Database connection failed: ' . $this->connect_error);
        }

        // Optional: set charset
        $this->set_charset("utf8mb4");
    }

    /**
     * Get the singleton database instance.
     */
    public static function getDatabase()
    {
        if (self::$db === null) {
            self::$db = new Database();
        }
        return self::$db;
    }

    // Prevent cloning
    private function __clone() {}

    // ✅ Must be public, even if you want to block it
    public function __wakeup()
    {
        throw new \Exception("Unserializing Database is not allowed.");
    }
}
