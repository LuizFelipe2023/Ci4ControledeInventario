<?php

namespace App\Models;

use CodeIgniter\Model;

class Venda extends Model
{
    protected $table            = 'vendas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['cliente_id', 'valor_total', 'data_venda'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Casts and handlers
    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'cliente_id'   => 'required|integer|exists:clientes,id', // O cliente deve ser um ID existente na tabela clientes
        'valor_total'  => 'required|decimal|greater_than[0]', // O valor total deve ser um número decimal maior que zero
        'data_venda'   => 'required|valid_date[Y-m-d H:i:s]', // A data da venda deve ser uma data válida
    ];

    protected $validationMessages = [
        'cliente_id' => [
            'required' => 'O campo Cliente é obrigatório.',
            'integer'  => 'O ID do cliente deve ser um número inteiro.',
            'exists'   => 'O cliente informado não existe.',
        ],
        'valor_total' => [
            'required' => 'O campo Valor Total é obrigatório.',
            'decimal'  => 'O Valor Total deve ser um número decimal.',
            'greater_than' => 'O Valor Total deve ser maior que zero.',
        ],
        'data_venda' => [
            'required' => 'O campo Data da Venda é obrigatório.',
            'valid_date' => 'A Data da Venda deve estar no formato correto (Y-m-d H:i:s).',
        ],
    ];

    protected $skipValidation = false; 
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}