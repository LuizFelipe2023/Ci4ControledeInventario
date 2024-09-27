<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-md my-4 flex-grow-1">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success text-center"><?= session()->getFlashdata('success') ?></div>
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
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger text-center"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <table id="clientesTable" class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Endereço</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $c): ?>
                            <tr>
                                <td><?= esc($c['id']) ?></td>
                                <td><?= esc($c['nome']) ?></td>
                                <td><?= esc($c['endereco']) ?></td>
                                <td><?= esc($c['cpf']) ?></td>
                                <td><?= esc($c['telefone']) ?></td>
                                <td><?= esc($c['email']) ?></td>
                                <td>
                                    <a href="<?= site_url('clientes/edit/' . $c['id']) ?>" class="btn btn-warning btn-sm mb-2">Editar</a>
                                    <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $c['id'] ?>">Excluir</button>
                                    <a href="<?= site_url('clientes/show/' . $c['id']) ?>" class="btn btn-info btn-sm mb-2">Visualizar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Não há clientes cadastrados.</td>
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
                Você tem certeza que deseja excluir este cliente?
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
        $('#clientesTable').DataTable({
            responsive: true,
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
            window.location.href = "<?= site_url('clientes/delete/') ?>" + deleteId;
        });
    });
</script>
<?= $this->endSection() ?>
