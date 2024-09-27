<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVendasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'cliente_id'  => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'valor_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'data_venda'  => [
                'type' => 'DATETIME',
            ],
            'itens_vendidos' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('cliente_id', 'clientes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('vendas');
    }

    public function down()
    {
        $this->forge->dropForeignKey('vendas', 'vendas_cliente_id_foreign');
        $this->forge->dropTable('vendas');
    }
}
