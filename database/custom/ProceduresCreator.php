<?
namespace Database\Custom;

use App\Helpers\DatabaseHelper;

class ProceduresCreator extends DatabaseHelper
{
    protected $sql = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    public function setSqlQuerys()
    {

        $this->sql[] = "CREATE PROCEDURE `get_news_categories`() SELECT * FROM news_categories";

        $this->sql[] = "CREATE PROCEDURE `delete_news`(IN `id_val` BIGINT) DELETE FROM news WHERE id=id_val";

        $this->sql[] = "CREATE PROCEDURE `select_news`(IN `id_val` BIGINT) SELECT * FROM news WHERE id=id_val";

        $this->sql[] = "CREATE PROCEDURE `update_news`(IN `row_name` VARCHAR(50),
	                                            IN `category_id` BIGINT,
	                                            IN `short_description` TEXT,
	                                            IN `description` TEXT,
	                                            IN `updated_at` TIMESTAMP,
	                                            IN `row_id` BIGINT)
                           UPDATE `news`
                              set `name` = row_name,
                                 `category_id` = category_id,
                                 `short_description` = short_description,
                                 `description` = description,
                                 `updated_at` = updated_at
                              where `id` = row_id";

        $this->sql[] = "CREATE PROCEDURE `insert_news`(IN `name` VARCHAR(50),
	                                            IN `category_id` BIGINT,
	                                            IN `short_description` TEXT,
	                                            IN `description` TEXT,
	                                            IN `updated_at` TIMESTAMP)
                           INSERT INTO news (name, category_id, short_description, description, updated_at)";

        $this->sql[] = "CREATE PROCEDURE `get_pagination_filtered_news`(IN `category` BIGINT,
                                                                        IN `max` INT,
                                                                        IN `page` INT)
                        SELECT * FROM `news`
                        WHERE `category_id`=category
                         LIMIT max OFFSET page";

        $this->sql[] = "CREATE PROCEDURE `get_pagination_news`(IN `max` INT, IN `page` INT)
                            SELECT * FROM `news` LIMIT max OFFSET page";

        $this->sql[] = "CREATE PROCEDURE `count_news_category`(IN `category` BIGINT)
                            SELECT COUNT(*) AS `total` FROM `news` WHERE `category_id` = category";
        $this->sql[] = "CREATE PROCEDURE `count_news`()
                            SELECT COUNT(*) as total FROM `news`;";
    }
}
