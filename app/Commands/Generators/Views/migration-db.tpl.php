<@php

namespace {namespace};

use CodeIgniter\Database\Migration;

class {class} extends Migration
{
    protected $DBGroup = '<?= $DBGroup ?>';
    public function up(): void
    {
        $this->forge->addField([
<?php if (!empty($fields)): ?>
<?php foreach($fields as $value): ?>
            <?=$value.PHP_EOL ?>
<?php endforeach; ?>
<?php endif; ?>
        ]);
<?php if (!empty($primarykey)): ?>
    $this->forge->addKey(['<?= implode("','") ?>'], true);
<?php endif; ?>
        $this->forge->createTable('<?= $table ?>', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('<?= $table ?>', true);
    }
}
