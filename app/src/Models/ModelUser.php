<?php

declare(strict_types=1);

namespace Arqmedes\Models;

use Arqmedes\Core\Model;

class ModelUser extends Model
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function findByEmail(string $email)
    {
        $user = current($this->where(['email' => $email])) ?? null;
        return $user;
    }
}
