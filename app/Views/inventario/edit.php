<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-md">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-light">
                <div class="card-header" style="background-color: #3a5b7d; color: white; text-align: center;">
                    <h2 class="mb-0 text-white">Editar Item do Inventário</h2>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <form action="<?= site_url('inventario/update/' . $inventario['id']) ?>" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome do Item</label>
                            <input type="text" class="form-control" name="name" value="<?= esc($inventario['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantidade</label>
                            <input type="number" class="form-control" name="quantity" value="<?= esc($inventario['quantity']) ?>" required min="1">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Preço</label>
                            <input type="number" step="0.01" class="form-control" name="price" value="<?= esc($inventario['price']) ?>" required min="0">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Categoria</label>
                            <input type="text" class="form-control" name="category" value="<?= esc($inventario['category']) ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="background-color: #3a5b7d; border-color: #3a5b7d;">Atualizar Item</button>
                        <a href="<?= site_url('inventario') ?>" class="btn btn-outline-danger">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
