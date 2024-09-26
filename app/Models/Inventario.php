<?php

namespace App\Models;

use CodeIgniter\Model;

class Inventario extends Model
{
    protected $table            = 'inventarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'quantity', 'price', 'category', 'imagem'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

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
        'name' => 'required|min_length[3]|max_length[255]',
        'quantity' => 'required|integer|min_length[1]',
        'price' => 'required|decimal',
        'category' => 'required|min_length[3]|max_length[100]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'O nome do inventário é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 3 caracteres.',
            'max_length' => 'O nome não pode ter mais de 255 caracteres.'
        ],
        'quantity' => [
            'required' => 'A quantidade é obrigatória.',
            'integer' => 'A quantidade deve ser um número inteiro.',
            'min_length' => 'A quantidade deve ser pelo menos 1.'
        ],
        'price' => [
            'required' => 'O preço é obrigatório.',
            'decimal' => 'O preço deve ser um número decimal válido.'
        ],
        'category' => [
            'required' => 'A categoria é obrigatória.',
            'min_length' => 'A categoria deve ter pelo menos 3 caracteres.',
            'max_length' => 'A categoria não pode ter mais de 100 caracteres.'
        ]
    ];

    protected $skipValidation       = false;
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
