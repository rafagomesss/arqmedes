<?php

declare(strict_types=1);

namespace Arqmedes\Entities;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class Product
{
    public function __construct(array $data)
    {
        $this->defineObject($data);
    }

    protected function defineObject($data)
    {
        $keys = array_keys($data);

        foreach ($keys as $key) {
            if ($key === 'categories') continue;
            $this->$key = $data[$key];
        }

    }
}
