<?
namespace Database\Custom;

use App\Helpers\DatabaseHelper;

class DatabaseCreator extends DatabaseHelper
{
    protected $sql = [];

    public function __construct()
    {
        try {
            @parent::__construct(
                env('DB_HOST', 'localhost'),
                env('DB_USERNAME', 'root'),
                env('DB_PASSWORD', ''),
                '',
                false
            );
        }catch (\Throwable $e) {
            $this->errors[] = $e->getMessage();
        }
    }

    /**
     * @return void
     */
    public function setSqlQuerys()
    {
        $dbName = env('DB_DATABASE', 'laravel_task');
        $this->sql[] = "CREATE DATABASE IF NOT EXISTS {$dbName}".PHP_EOL;
    }
}
