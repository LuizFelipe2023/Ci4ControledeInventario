<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-md">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-light">
                <div class="card-header mb-2" style="background-color: #3a5b7d; color: white; text-align: center;">
                    <h2 class="mb-0 text-white">Detalhes da Venda</h2>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title mt-4">Cliente: <?= esc($cliente['nome']) ?></h5>
                    
                    <p class="card-text mt-2"><strong>Telefone:</strong> <?= esc($cliente['telefone']) ?></p>
                    <p class="card-text mt-2"><strong>Email:</strong> <?= esc($cliente['email']) ?></p>
                    <p class="card-text mt-2"><strong>Endereço:</strong> <?= esc($cliente['endereco']) ?></p>
                    <p class="card-text mt-2"><strong>CPF:</strong> <?= esc($cliente['cpf']) ?></p> 
                    
                    <p class="card-text mt-2"><strong>Data da Venda:</strong> <?= esc(date('d/m/Y H:i:s', strtotime($venda['data_venda']))) ?></p>
                    <p class="card-text mt-2"><strong>Total da Venda:</strong> R$ <?= number_format(esc($venda['valor_total']), 2, ',', '.') ?></p>
                    
                    <a href="<?= site_url('vendas') ?>" class="btn btn-outline-secondary mt-4">Voltar para as Vendas</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
