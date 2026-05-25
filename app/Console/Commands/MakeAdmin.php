<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    protected $signature   = 'user:make-admin {email}';
    protected $description = 'Concede privilégios de administrador a um utilizador pelo email';

    public function handle(): int
    {
        $email = $this->argument('email');
        $user  = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Utilizador com email «{$email}» não encontrado.");
            return self::FAILURE;
        }

        $user->update(['is_admin' => true]);
        $this->info("✓ {$user->name} ({$email}) é agora administrador.");
        return self::SUCCESS;
    }
}
