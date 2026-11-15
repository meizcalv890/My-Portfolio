<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('portfolio.admin_email');
        $password = config('portfolio.admin_password');

        if (! $email || ! $password || strlen($password) < 12) {
            $this->command->error('ADMIN_EMAIL / ADMIN_PASSWORD belum diisi atau password kurang dari 12 karakter.');
            return;
        }

        $user = User::firstOrNew(['email' => $email]);
        $user->name = $user->name ?: 'Admin';
        $user->password = $password;   // di-hash otomatis oleh cast 'hashed'
        $user->is_admin = true;
        $user->save();

        // Sistem ini satu admin: hapus akun lain (termasuk admin@example.com lama)
        User::where('id', '!=', $user->id)->delete();

        $this->command->info('Akun admin siap: ' . $email);
    }
}
