<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnTokenToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'token');
    }
}
