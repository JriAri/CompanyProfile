<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;
    public string $defaultGroup = 'default';

    public array $default;

    public array $tests = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => '',
        'password'    => '',
        'database'    => ':memory:',
        'DBDriver'    => 'SQLite3',
        'DBPrefix'    => 'db_',
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => '',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
        'dateFormat'  => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    public function __construct()
    {
        parent::__construct();

        // Konfigurasi default database dari .env
        $this->default = [
            'DSN'          => '',
            'hostname'     => env('database.default.hostname', 'localhost'),
            'username'     => env('database.default.username', 'root'),
            'password'     => env('database.default.password', ''),
            'database'     => env('database.default.database', 'CompanyProfile'),
            'DBDriver'     => env('database.default.DBDriver', 'MySQLi'),
            'DBPrefix'     => env('database.default.DBPrefix', ''),
            'pConnect'     => env('database.default.pConnect', false),
            'DBDebug'      => env('database.default.DBDebug', true),
            'charset'      => env('database.default.charset', 'utf8mb4'),
            'DBCollat'     => env('database.default.DBCollat', 'utf8mb4_general_ci'),
            'swapPre'      => '',
            'encrypt'      => env('database.default.encrypt', false),
            'compress'     => env('database.default.compress', false),
            'strictOn'     => env('database.default.strictOn', false),
            'failover'     => [],
            'port'         => (int) env('database.default.port', 3306),
            'numberNative' => false,
            'foundRows'    => false,
            'dateFormat'   => [
                'date'     => 'Y-m-d',
                'datetime' => 'Y-m-d H:i:s',
                'time'     => 'H:i:s',
            ],
        ];

        // Jika sedang testing, pakai database test
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}