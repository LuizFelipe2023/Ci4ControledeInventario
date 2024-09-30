<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-md">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-light">
                <div class="card-header" style="background-color: #3a5b7d; color: white; text-align: center;">
                    <h2 class="mb-0 text-white">Verifique seu Email</h2>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <form action="<?= site_url('validate-token') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="token" class="form-label">Digite o Token de Verificação</label>
                            <input type="text" class="form-control" id="token" name="token" placeholder="XXXXXX" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Verificar Token</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">Não recebeu o token? <a href="<?= site_url('/resend-verification-email') ?>">Reenviar Email de Verificação</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
