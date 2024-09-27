<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-md">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-light">
                <div class="card-header mb-2" style="background-color: #3a5b7d; color: white; text-align: center;">
                    <h2 class="mb-0 text-white">Detalhes do Item do Inventário</h2>
                </div>
                <div class="card-body text-center"> 
                    <?php if (!empty($inventario['imagem'])): ?>
                        <div class="mb-3">
                            <img src="<?= base_url($inventario['imagem']) ?>" alt="Imagem do Item" class="img-fluid mb-3" style="max-width: 100%; height: auto;">
                        </div>
                    <?php else: ?>
                        <div class="mb-3">
                            <p>Nenhuma imagem disponível.</p>
                        </div>
                    <?php endif; ?>

                    <h5 class="card-title mt-4">Nome do Item: <?= esc($inventario['name']) ?></h5>
                    <p class="card-text mt-2"><strong>Quantidade:</strong> <?= esc($inventario['quantity']) ?></p>
                    <p class="card-text mt-2"><strong>Preço:</strong> R$ <?= number_format(esc($inventario['price']), 2, ',', '.') ?></p>
                    <p class="card-text mt-2"><strong>Categoria:</strong> <?= esc($inventario['category']) ?></p>

                    <a href="<?= site_url('inventario') ?>" class="btn btn-outline-secondary mt-4">Voltar para o Inventário</a> <!-- Added mt-4 class for spacing -->
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
