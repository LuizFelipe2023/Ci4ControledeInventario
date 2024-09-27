<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-md my-4">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-light">
                <div class="card-header" style="background-color: #3a5b7d; color: white; text-align: center;">
                    <h2 class="mb-0">Editar Cliente</h2>
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

                    <form id="clienteForm" action="<?= site_url('clientes/update/' . $cliente['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Cliente</label>
                            <input type="text" class="form-control" name="nome" value="<?= esc($cliente['nome']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control" name="endereco" value="<?= esc($cliente['endereco']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" name="cpf" value="<?= esc($cliente['cpf']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" name="telefone" value="<?= esc($cliente['telefone']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" name="email" value="<?= esc($cliente['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Foto do Cliente (Opcional):</label>
                            <input type="file" class="form-control" name="file">
                        </div>

                        <button type="submit" class="btn btn-success mb-3">Salvar Alterações</button>
                        <a href="<?= site_url('clientes') ?>" class="btn btn-outline-danger mb-3">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
