<?
namespace Database\Custom;

use App\Helpers\DatabaseHelper;

class TablesСreator extends DatabaseHelper
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
        $this->sql[] = "CREATE TABLE `migrations` (
	                        `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	                        `migration` VARCHAR(255) NOT NULL,
	                        `batch` INT(10) NOT NULL,
	                        PRIMARY KEY (`id`)
                        );";
        $this->sql[] = "CREATE TABLE IF NOT EXISTS `users` (
                            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                            `name` varchar(255) NOT NULL,
                            `email` varchar(255) NOT NULL,
                            `email_verified_at` timestamp NULL DEFAULT NULL,
                            `password` varchar(255) NOT NULL,
                            `remember_token` varchar(100) DEFAULT NULL,
                            `type` int DEFAULT NULL,
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            UNIQUE KEY `users_email_unique` (`email`)
                        );";
        $this->sql[] = "CREATE TABLE IF NOT EXISTS `password_resets` (
                            `email` varchar(255) NOT NULL,
                            `token` varchar(255) NOT NULL,
                            `created_at` timestamp NULL DEFAULT NULL,
                            KEY `password_resets_email_index` (`email`)
                        );";
        $this->sql[] = "CREATE TABLE `failed_jobs` (
	                        `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	                        `uuid` VARCHAR(255) NOT NULL,
	                        `connection` TEXT NOT NULL,
	                        `queue` TEXT NOT NULL,
	                        `payload` LONGTEXT NOT NULL,
	                        `exception` LONGTEXT NOT NULL,
	                        `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	                        PRIMARY KEY (`id`) USING BTREE,
	                        UNIQUE INDEX `failed_jobs_uuid_unique` (`uuid`) USING BTREE
                        )";
        $this->sql[] = "CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
                            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                            `tokenable_type` varchar(255) NOT NULL,
                            `tokenable_id` bigint unsigned NOT NULL,
                            `name` varchar(255) NOT NULL,
                            `token` varchar(64) NOT NULL,
                            `abilities` text,
                            `last_used_at` timestamp NULL DEFAULT NULL,
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
                            KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
                        );";
        $this->sql[] = "CREATE TABLE IF NOT EXISTS `news_categories` (
                            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                            `name` varchar(255) NOT NULL,
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            PRIMARY KEY (`id`)
                        );";
        $this->sql[] = "CREATE TABLE IF NOT EXISTS `news` (
                            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                            `name` varchar(255) NOT NULL,
                            `category_id` bigint unsigned NOT NULL,
                            `short_description` text NOT NULL,
                            `description` text NOT NULL,
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            KEY `news_category_id_foreign` (`category_id`),
                            CONSTRAINT `news_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE CASCADE
                        );";
    }
}
