<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;
use Filament\Models\Contracts\HasName;
use Illuminate\Notifications\Notifiable;

class Karyawan extends Authenticatable implements HasName
{
    use Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'karyawan';

    protected $fillable = ['nama', 'username', 'password'];
    protected $hidden = ['password'];

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function getFilamentName(): string
    {
        return $this->nama;
    }
}
