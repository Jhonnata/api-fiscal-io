<?php

namespace App\Commands\Swagger;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Exception;

class Swagger extends BaseCommand
{
    protected $group = 'swagger';
    protected $name = 'swagger:generate';
    protected $description = 'Generate documentation.';
    /**
     * the Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * the Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * @throws Exception
     */
    public function run(array $params): void
    {
        $config = config('swagger');
        if (!is_dir($config->docs)) {
            mkdir($config->docs, 0755, true);
        }
        $swagger = \OpenApi\Generator::scan($config->annotations);
        $filename = $config->docs . DIRECTORY_SEPARATOR . $config->jsonFileName;
        if (file_exists($filename)) {
            unlink($filename);
        }
        header('Content-Type: application/json');
        $swagger->saveAs($filename);
        CLI::write('Swagger: ' . CLI::color("generate", 'green'));
    }
}
