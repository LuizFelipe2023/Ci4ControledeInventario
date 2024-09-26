<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<div class="container-md my-4 flex-grow-1">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success text-center"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger text-center"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger text-center">
                    <ul class="list-unstyled">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <table id="inventarioTable" class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($inventarios)): ?>
                        <?php foreach ($inventarios as $i): ?>
                            <tr>
                                <td><?= esc($i['id']) ?></td>
                                <td><?= esc($i['name']) ?></td>
                                <td><?= esc($i['quantity']) ?></td>
                                <td>R$ <?= number_format(esc($i['price']), 2, ',', '.') ?></td> <!-- Format price -->
                                <td><?= esc($i['category']) ?></td>
                                <td>
                                    <a href="<?= site_url('inventario/edit/' . $i['id']) ?>" class="btn btn-warning btn-sm mb-2">Editar</a>
                                    <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $i['id'] ?>">Excluir</button>
                                    <a href="<?= site_url('inventario/' . $i['id']) ?>" class="btn btn-info btn-sm mb-2">Visualizar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Não há itens no inventário.</td> 
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Você tem certeza que deseja excluir este item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Excluir</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#inventarioTable').DataTable({
            language: {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Nenhum registro encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(filtrado de _MAX_ registros no total)",
                "search": "Buscar:",
                "paginate": {
                    "next": "Próximo",
                    "previous": "Anterior"
                }
            }
        });

        let deleteId;

        $('#deleteModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            deleteId = button.data('id');
        });

        $('#confirmDelete').on('click', function() {
            window.location.href = "<?= site_url('inventario/delete/') ?>" + deleteId;
        });
    });
</script>
<?= $this->endsection() ?>
