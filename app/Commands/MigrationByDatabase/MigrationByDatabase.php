<?php

namespace App\Commands\MigrationByDatabase;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\GeneratorTrait;
use Config\App as AppConfig;
use Config\Database;
use Config\Migrations;
use Config\Session as SessionConfig;
use Exception;

class MigrationByDatabase extends BaseCommand
{
    use GeneratorTrait;

    protected $group = 'Generators';
    protected $name = 'make:migration-db';
    protected $description = 'Generates a new migration file by database.';
    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'make:migration-db <name> [options]';
    /**
     * the Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'name' => 'The migration class name.',
    ];

    /**
     * the Command's Options
     *
     * @var array
     */
    protected $options = [
        '--session' => 'Generates the migration file for database sessions.',
        '--table' => 'Table name to use for database sessions. Default: "ci_sessions".',
        '--dbgroup' => 'Database group to use for database sessions. Default: "default".',
        '--namespace' => 'Set root namespace. Default: "APP_NAMESPACE".',
        '--suffix' => 'Append the component title to the class name (e.g. User => UserMigration).',
    ];

    /**
     * @throws Exception
     */
    public function run(array $params): void
    {
        $this->component = 'Migration';
        $this->directory = 'Database\Migrations';
        $this->template = 'migration-db.tpl.php';
        $table = CLI::getOption('table');
        if ($table!=="all") {
            $this->classNameLang = 'CLI.generator.className.migration';
            $this->execute($params);
        } else {
            $this->classNameLang = 'CLI.generator.className.migration';
            $database = db_connect();
            $tables = $database->listTables();
            foreach ($tables as $table) {
                $name = preg_replace_callback('/(?:^|_)([a-z])/',function ($matches) {
                    return  strtoupper($matches[1]);
                },$table);
                CLI::write(CLI::color($name, 'green'));
                $params[0]=$name;
                $params['table']=$table;
                $this->execute($params);
            }
        }

    }

    /**
     * Prepare options and do the necessary replacements.
     * @throws Exception
     */
    protected function prepare(string $class): string
    {

        $data = [];
        $data['session'] = false;
        $database = db_connect();
        if (CLI::getOption('table')) {
            try {
                $tableName = $this->getOption('table');
                if (!$database->tableExists($tableName)) {
                    throw new Exception('Informe uma tabela que exista no banco de dados.');
                }
                $data['table'] = $tableName;
                $data['DBGroup'] = 'default';
                $fieldsDB = $database->getFieldData($tableName);
                $data['fields'] = [];
                $data['primaryKey'] = [];
                foreach ($fieldsDB as $field) {
                    $constraint="";
                    $default="";
                    if($field->primary_key){
                        $data['primaryKey'][] = $field->name;
                    }
                    if($field->max_length){
                        $constraint="'constraint' => {$field->max_length},";
                    }
                    if($field->default){
                        $default="'default' => {$field->default},";
                    }
                    $data['fields'][] = "'{$field->name}' => ['type' => '" . mb_strtoupper($field->type) . "', {$constraint}{$default} 'null' => " . (($field->nullable) ? 'true' : 'false') . "],";
                }
            } catch (\Throwable $e) {
                CLI::write(CLI::color($e->getMessage(), 'red'));
                throw new Exception($e->getMessage());
            }
        }
        return $this->parseTemplate($class, [], [], $data);
    }

    /**
     * Change file basename before saving.
     */
    protected function basename(string $filename): string
    {
        return gmdate(config(Migrations::class)->timestampFormat) . basename($filename);
    }
}
