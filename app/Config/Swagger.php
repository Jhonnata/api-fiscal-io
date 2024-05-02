<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Swagger extends BaseConfig
{
    /*
   |--------------------------------------------------------------------------
   | Title API
   |--------------------------------------------------------------------------
   |
   | Edit to set the API title
   |
   */
    public string $title = 'Platform Pós-Graduação Unip';
    /*
   |--------------------------------------------------------------------------
   | Annotations
   |--------------------------------------------------------------------------
   |
   | Absolute path to directory containing the swagger annotations are stored.
   |
   */
    public array $annotations = [__DIR__ . '/../Controllers', __DIR__ . '/../../api-v1'];

    /*
     |--------------------------------------------------------------------------
     | Annotations
     |--------------------------------------------------------------------------
     |
     | Absolute path to directory containing the swagger annotations are stored.
     |
     */
    public string $docs = __DIR__ . '/../../public/swagger';

    /*
      |--------------------------------------------------------------------------
      | JSON DOC API
      |--------------------------------------------------------------------------
      */
    public string $jsonFileName = 'swagger.json';

    /*
      |--------------------------------------------------------------------------
      | CALLBACK URL
      |--------------------------------------------------------------------------
      */
    public string $oauth2Callback = '/swagger/oauth2-redirect.html';

    /*
      |--------------------------------------------------------------------------
      | OPERATION SORT
      |--------------------------------------------------------------------------
      */
    public string|null $operationsSort = null;


    /*
      |--------------------------------------------------------------------------
      | VALIDATOR URL
      |--------------------------------------------------------------------------
      */
    public string|null $validatorUrl = null;


    /*
      |--------------------------------------------------------------------------
      | ADDITIONAL CONFIG URL
      |--------------------------------------------------------------------------
      */
    public string|null $additionalConfigUrl = null;

    /*
    |--------------------------------------------------------------------------
    | EXCLUDES PATHS
    |--------------------------------------------------------------------------
    */
    public array $excludes = [];
}
