<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class DropColumnCommand extends Command
{
    protected $signature = 'db:drop-column {table} {column}';
    protected $description = 'Generate a migration to drop a column from a table';

    public function handle()
    {
        $table = $this->argument('table');
        $column = $this->argument('column');

        $name = 'drop_' . $column . '_from_' . $table . '_table';

        $this->call('make:migration', [
            'name' => $name,
            '--table' => $table,
        ]);

        $this->info("Migration created. Add the following inside the up() method:");

        $this->line("Schema::table('$table', function (Blueprint \$table) {");
        $this->line("    \$table->dropColumn('$column');");
        $this->line("});");

        return 0;
    }
}
