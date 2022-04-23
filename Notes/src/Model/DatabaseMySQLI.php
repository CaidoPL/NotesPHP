<?php

declare(strict_types=1);

namespace App;

class DatabaseMySQL
{
    public function __construct(array $config)
    {
        $connection = mysqli_connect(
            $config['host'],
            $config['user'],
            $config['password'],
            $config['database']
        );
    }
}
