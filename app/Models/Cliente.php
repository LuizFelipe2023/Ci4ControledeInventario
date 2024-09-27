<?php

namespace App\Models;

use CodeIgniter\Model;

class Cliente extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nome', 'endereco', 'cpf', 'telefone', 'email', 'imagem']; 

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
        'nome'     => 'required|min_length[2]|max_length[255]',
        'endereco' => 'required|min_length[4]|max_length[255]',
        'cpf'      => 'required|is_unique[clientes.cpf]|exact_length[11]',
        'telefone' => 'required|max_length[15]|regex_match[/^\+?[0-9]{1,3}?[ -]?(\(?[0-9]{2,3}?\)?[ -]?)?[0-9]{4,5}[ -]?[0-9]{4}$/]',
        'email'    => 'required|valid_email|max_length[255]',
        'imagem'   => 'permit_empty|max_length[255]', 
    ];
    
    protected $validationMessages = [
        'nome' => [
            'required' => 'O nome é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos {param} caracteres.',
            'max_length' => 'O nome não pode exceder {param} caracteres.'
        ],
        'endereco' => [
            'required' => 'O endereço é obrigatório.',
            'min_length' => 'O endereço deve ter pelo menos {param} caracteres.',
            'max_length' => 'O endereço não pode exceder {param} caracteres.'
        ],
        'cpf' => [
            'required' => 'O CPF é obrigatório.',
            'is_unique' => 'Este CPF já está cadastrado.',
            'exact_length' => 'O CPF deve ter exatamente {param} dígitos.',
        ],
        'telefone' => [
            'required' => 'O telefone é obrigatório.',
            'max_length' => 'O telefone não pode exceder {param} caracteres.',
            'regex_match' => 'O telefone deve estar no formato correto.'
        ],
        'email' => [
            'required' => 'O e-mail é obrigatório.',
            'valid_email' => 'O e-mail fornecido é inválido.',
            'max_length' => 'O e-mail não pode exceder {param} caracteres.'
        ],
        'imagem' => [ 
            'max_length' => 'O nome do arquivo da imagem não pode exceder {param} caracteres.'
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
