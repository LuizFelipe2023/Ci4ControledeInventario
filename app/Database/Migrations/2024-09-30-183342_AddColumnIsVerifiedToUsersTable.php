<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnIsVerifiedToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'isVerified' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'isVerified');
    }
}
