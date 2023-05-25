<?php

declare(strict_types=1);

namespace Arqmedes\Entities;

class User
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public ?Role $role;
    public bool $isAdmin;

    public function __construct(array $data)
    {
        $attributes = array_keys(get_class_vars(__CLASS__));

        foreach ($data as $key => $value) {
            if (in_array($key, $attributes)) {
                $this->$key = $value;
            }
        }
    }
}
