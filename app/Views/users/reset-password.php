<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-md">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-light">
                <div class="card-header" style="background-color: #3a5b7d; color: white; text-align: center;">
                    <h2 class="mb-0">Redefinir Senha</h2>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <form action="<?= site_url('update-password') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="token" class="form-label">Token de Redefinição</label>
                            <input type="text" class="form-control" id="token" name="token" placeholder="XXXXXX" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmação da Nova Senha</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Redefinir Senha</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
