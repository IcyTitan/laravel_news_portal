<?php

namespace App\Helpers;

class DatabaseHelper extends \mysqli
{
    protected $errors = [];

    protected $sql = [];

    public function __construct($host = '', $username = '', $pass = '', $database = '', $useConfig = true)
    {
        if ($useConfig) {
            $host = env('DB_HOST', 'localhost');
            $username = env('DB_USERNAME', 'root');
            $pass = env('DB_PASSWORD', '');
            $database = env('DB_DATABASE', 'laravel_task');
        }
        @parent::__construct(
            $host,
            $username,
            $pass,
            $database
        );
        if ($this->connect_error) {
            throw new \Exception (
                $this->connect_error,
                $this->connect_errno
            );
        }
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return void
     */
    public function runQuerys()
    {
        foreach ($this->sql as $query) {
            try {
                $result = $this->query($query);
            } catch (\Throwable $e) {
                $this->errors[] = $e->getMessage();
            } catch (\mysqli_sql_exception $e) {
                $this->errors[] = $e->getMessage();
            }
        }
    }

    public function query($sqlQuery, $resultmode = MYSQLI_STORE_RESULT)
    {
        $result = [];
        $resultQuery = parent::query($sqlQuery);
        if(is_bool($resultQuery)) {
            return $resultQuery;
        }else{
            while ($queryRow = $resultQuery->fetch_object()) {
                $result[] = $queryRow;
            }
        }
        while($this->next_result()) $this->store_result();
        return $result;
    }

    public function prepareQuery($sqlQuery, $types='', $vars=[])
    {
        $result = [];

        foreach ($vars as $key => $var) {
            if (gettype($var) == 'string') {
                $vars[$key] = $this->real_escape_string($var);
            }
        }
        $stmt = $this->prepare($sqlQuery);

        $stmt->bind_param($types, ...$vars);
        $stmt->execute();

        while($this->next_result()) $this->store_result();
        $resultQuery = $stmt->get_result();

        if (is_bool($resultQuery)) {
            return $resultQuery;
        } else {
            while ($queryRow = $resultQuery->fetch_object()) {
                $result[] = $queryRow;
            }
            return $result;
        }
    }
}
