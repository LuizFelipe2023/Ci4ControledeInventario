<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnImagemToInventariosTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('inventarios', [
            'imagem' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true, 
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('inventarios', 'imagem');

    }
}
