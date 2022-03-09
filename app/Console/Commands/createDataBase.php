<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class createDataBase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:dbcreate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create datatables needed for project';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function ToString($input)
    {
        return print_r($input, true);
    }

    /**
     * @param $className
     * @return bool
     */
    private function creator($className)
    {
        $creator = new $className;
        $creator->setSqlQuerys();
        $creator->runQuerys();
        $errors = $creator->getErrors();

        if(!empty($errors)) {
            $this->error($this->ToString($errors));
            return false;
        }

        return true;
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $creatorsClassNames = [
            'Database\Custom\DatabaseCreator',
            'Database\Custom\TablesСreator',
            'Database\Custom\ProceduresCreator',
        ];
        foreach ($creatorsClassNames as $class){
            if(!$this->creator($class)){
                break;
            }
        }
    }
}
