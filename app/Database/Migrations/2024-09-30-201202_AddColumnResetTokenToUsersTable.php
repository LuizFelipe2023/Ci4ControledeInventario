<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnResetTokenToUsersTable extends Migration
{
    public function up()
    {
      
        $this->forge->addColumn('users', [
            'resetToken' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true, 
                'default' => null, 
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'resetToken');
    }
}
