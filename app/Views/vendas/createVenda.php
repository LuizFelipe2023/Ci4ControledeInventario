<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-md">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-light">
                <div class="card-header" style="background-color: #3a5b7d; color: white; text-align: center;">
                    <h2 class="mb-0 text-white">Adicionar Nova Venda</h2>
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

                    <form id="vendaForm" action="<?= site_url('vendas/store') ?>" method="post">
                        <div class="mb-3">
                            <label for="cliente" class="form-label">Cliente</label>
                            <select class="form-select" name="cliente_id" required>
                                <option value="">Selecione um Cliente</option>
                                <?php foreach ($clientes as $cliente): ?>
                                    <option value="<?= esc($cliente['id']) ?>"><?= esc($cliente['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div id="itemsContainer">
                            <div class="item mb-3 border p-3 rounded">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <label for="inventory0" class="form-label">Selecionar Item do Inventário</label>
                                        <select class="form-select" name="inventarios[0][id]" required>
                                            <option value="">Selecione um Item</option>
                                            <?php foreach ($itensInventario as $inventario): ?>
                                                <option value="<?= esc($inventario['id']) ?>"><?= esc($inventario['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label for="quantity0" class="form-label">Quantidade</label>
                                        <input type="number" class="form-control" name="inventarios[0][quantity]" id="quantity0" required min="1">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p id="itemCount" class="text-muted">Total de itens: 1</p>

                        <button type="button" id="addItem" class="btn btn-primary mb-3">Adicionar Outro Item</button>
                        <button type="submit" class="btn btn-success mb-3">Adicionar Venda</button>
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
        let itemIndex = 1;

        document.getElementById('addItem').addEventListener('click', function() {
            const newItem = document.createElement('div');
            newItem.className = 'item mb-3 border p-3 rounded';
            newItem.innerHTML = `
                <div class="row">
                    <div class="col-12 mb-2">
                        <label for="inventory${itemIndex}" class="form-label">Selecionar Item do Inventário</label>
                        <select class="form-select" name="inventarios[${itemIndex}][id]" required>
                            <option value="">Selecione um Item</option>
                            <?php foreach ($itensInventario as $inventario): ?>
                                <option value="<?= esc($inventario['id']) ?>"><?= esc($inventario['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-6 mb-2">
                        <label for="quantity${itemIndex}" class="form-label">Quantidade</label>
                        <input type="number" class="form-control" name="inventarios[${itemIndex}][quantity]" id="quantity${itemIndex}" required min="1">
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
