<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-md">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-light">
                <div class="card-header" style="background-color: #3a5b7d; color: white; text-align: center;">
                    <h2 class="mb-0 text-white">Editar Venda</h2>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form id="vendaForm" action="<?= site_url('vendas/update/' . $venda['id']) ?>" method="post">
                        <div class="mb-3">
                            <label for="cliente" class="form-label">Cliente</label>
                            <select class="form-select" name="cliente_id" required>
                                <option value="">Selecione um Cliente</option>
                                <?php foreach ($clientes as $cliente): ?>
                                    <option value="<?= esc($cliente['id']) ?>" <?= ($cliente['id'] == $venda['cliente_id']) ? 'selected' : '' ?>>
                                        <?= esc($cliente['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div id="itemsContainer">
                            <?php foreach ($venda['itens'] as $index => $item): ?>
                                <div class="item mb-3 border p-3 rounded">
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <label for="inventory" class="form-label">Selecionar Item do Inventário</label>
                                            <select class="form-select" name="inventarios[<?= $index ?>][id]" required>
                                                <option value="">Selecione um Item</option>
                                                <?php foreach ($inventarios as $inventario): ?>
                                                    <option value="<?= esc($inventario['id']) ?>" <?= ($inventario['id'] == $item['id']) ? 'selected' : '' ?>>
                                                        <?= esc($inventario['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label for="quantity" class="form-label">Quantidade</label>
                                            <input type="number" class="form-control" name="inventarios[<?= $index ?>][quantity]" value="<?= esc($item['quantidade']) ?>" required min="1">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <p id="itemCount" class="text-muted">Total de itens: <?= count($venda['itens']) ?></p>

                        <button type="button" id="addItem" class="btn btn-primary mb-3">Adicionar Outro Item</button>
                        <button type="submit" class="btn btn-success mb-3">Salvar Alterações</button>
                        <a href="<?= site_url('vendas') ?>" class="btn btn-outline-danger mb-3">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = <?= count($venda['itens']) ?>;

    document.getElementById('addItem').addEventListener('click', function() {
        const newItem = document.createElement('div');
        newItem.className = 'item mb-3 border p-3 rounded';
        newItem.innerHTML = `
            <div class="row">
                <div class="col-12 mb-2">
                    <label for="inventory" class="form-label">Selecionar Item do Inventário</label>
                    <select class="form-select" name="inventarios[${itemIndex}][id]" required>
                        <option value="">Selecione um Item</option>
                        <?php foreach ($inventarios as $inventario): ?>
                            <option value="<?= esc($inventario['id']) ?>"><?= esc($inventario['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 mb-2">
                    <label for="quantity" class="form-label">Quantidade</label>
                    <input type="number" class="form-control" name="inventarios[${itemIndex}][quantity]" required min="1">
                </div>
            </div>
        `;
        document.getElementById('itemsContainer').appendChild(newItem);
        itemIndex++;
        updateItemCount();
    });

    function updateItemCount() {
        document.getElementById('itemCount').textContent = `Total de itens: ${itemIndex}`;
    }
});
</script>
<?= $this->endSection() ?>
