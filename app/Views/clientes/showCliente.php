<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-md">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-light">
                <div class="card-header mb-2" style="background-color: #3a5b7d; color: white; text-align: center;">
                    <h2 class="mb-0 text-white">Detalhes do Cliente</h2>
                </div>
                <div class="card-body text-center"> 
                    <?php if (!empty($cliente['imagem'])): ?>
                        <div class="mb-3">
                            <img src="<?= base_url($cliente['imagem']) ?>" alt="Imagem do Cliente" class="img-fluid mb-3" style="max-width: 100%; height: auto;">
                        </div>
                    <?php else: ?>
                        <div class="mb-3">
                            <p>Nenhuma imagem disponível.</p>
                        </div>
                    <?php endif; ?>

                    <h5 class="card-title mt-4">Nome do Cliente: <?= esc($cliente['nome']) ?></h5>
                    <p class="card-text mt-2"><strong>Endereço:</strong> <?= esc($cliente['endereco']) ?></p>
                    <p class="card-text mt-2"><strong>CPF:</strong> <?= esc($cliente['cpf']) ?></p>
                    <p class="card-text mt-2"><strong>Telefone:</strong> <?= esc($cliente['telefone']) ?></p>
                    <p class="card-text mt-2"><strong>E-mail:</strong> <?= esc($cliente['email']) ?></p>

                    <a href="<?= site_url('clientes') ?>" class="btn btn-outline-secondary mt-4">Voltar para a Lista de Clientes</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
