<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-md">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-light">
                <div class="card-header" style="background-color: #3a5b7d; color: white; text-align: center;">
                    <h2 class="mb-0 text-white">Adicionar Novo Item ao Inventário</h2>
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

                    <form id="inventarioForm" action="<?= site_url('inventario/insert') ?>" method="post" enctype="multipart/form-data">
                        <div id="itemsContainer">
                            <div class="item mb-3 border p-3 rounded">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <label for="name" class="form-label">Nome do Item</label>
                                        <input type="text" class="form-control" name="inventarios[0][name]" required>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label for="quantity" class="form-label">Quantidade</label>
                                        <input type="number" class="form-control" name="inventarios[0][quantity]" required min="1">
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label for="price" class="form-label">Preço</label>
                                        <input type="number" step="0.01" class="form-control" name="inventarios[0][price]" required min="0">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label for="category" class="form-label">Categoria</label>
                                        <input type="text" class="form-control" name="inventarios[0][category]" required>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label for="image" class="form-label">Imagem do Item</label>
                                        <input type="file" class="form-control" name="inventarios[0][imagem]" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p id="itemCount" class="text-muted">Total de itens: 1</p>

                        <button type="button" id="addItem" class="btn btn-primary mb-3">Adicionar Outro Item</button>
                        <button type="submit" class="btn btn-success mb-3">Adicionar Item</button>
                        <a href="<?= site_url('inventario') ?>" class="btn btn-outline-danger mb-3">Cancelar</a>
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
                    <i class="fa-sharp fa-solid fa-trash removeItem" style="cursor: pointer; color: red;"> Deletar</i>
                </div>
                <div class="col-12 mb-2">
                    <label for="name" class="form-label">Nome do Item</label>
                    <input type="text" class="form-control" name="inventarios[${itemIndex}][name]" required>
                </div>
                <div class="col-6 mb-2">
                    <label for="quantity" class="form-label">Quantidade</label>
                    <input type="number" class="form-control" name="inventarios[${itemIndex}][quantity]" required min="1">
                </div>
                <div class="col-6 mb-2">
                    <label for="price" class="form-label">Preço</label>
                    <input type="number" step="0.01" class="form-control" name="inventarios[${itemIndex}][price]" required min="0">
                </div>
                <div class="col-12 mb-2">
                    <label for="category" class="form-label">Categoria</label>
                    <input type="text" class="form-control" name="inventarios[${itemIndex}][category]" required>
                </div>
                <div class="col-12 mb-2">
                    <label for="image" class="form-label">Imagem do Item</label>
                    <input type="file" class="form-control" name="inventarios[${itemIndex}][imagem]" accept="image/*">
                </div>
            </div>
        `;
        document.getElementById('itemsContainer').appendChild(newItem);
        itemIndex++;
        updateItemCount();
    });

    
    document.getElementById('itemsContainer').addEventListener('click', function(e) {
        if (e.target.classList.contains('removeItem')) {
            e.target.closest('.item').remove();
            itemIndex--;
            updateItemCount();
        }
    });

    function updateItemCount() {
        document.getElementById('itemCount').textContent = `Total de itens: ${itemIndex}`;
    }
});

</script>
<?= $this->endSection() ?>