<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsTwoFactorSecretAndTwoFactorEnabledToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'two_factor_secret' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'two_factor_enabled' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'default' => 0,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'two_factor_secret');
        $this->forge->dropColumn('users', 'two_factor_enabled');
    }
}
