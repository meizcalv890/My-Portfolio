<?php

namespace App\Console\Commands;

use App\Models\Message;
use Illuminate\Console\Command;

class PruneMessages extends Command
{
    protected $signature = 'messages:prune {--days=90 : Hapus pesan lebih lama dari N hari}';

    protected $description = 'Hapus pesan kontak lama (data pribadi pengunjung)';

    public function handle(): int
    {
        $days = max(1, (int) $this->option('days'));
        $count = Message::where('created_at', '<', now()->subDays($days))->delete();

        $this->info("{$count} pesan dihapus.");

        return self::SUCCESS;
    }
}
