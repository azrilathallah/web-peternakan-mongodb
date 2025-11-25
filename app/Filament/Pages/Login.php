<?php

namespace App\Filament\Pages\Auth;

use App\Models\Karyawan;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getUsernameFormComponent(),
                $this->getPasswordFormComponent(),
            ]);
    }

    protected function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
            ->label('Username')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        $username = $this->form->getState()['username'] ?? null;
        $user = Karyawan::where('username', $username)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'data.username' => 'Username tidak ditemukan.',
            ]);
        }

        throw ValidationException::withMessages([
            'data.password' => 'Password salah.',
        ]);
    }
}
