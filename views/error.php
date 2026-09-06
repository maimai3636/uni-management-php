<div class="text-center mt-5">
    <h1 class="display-1 text-danger"><i class="fas fa-exclamation-triangle"></i></h1>
    <h2 class="text-danger"><?= $title ?? 'Lỗi' ?></h2>
    <p class="lead"><?= $message ?? 'Đã xảy ra lỗi' ?></p>
    <a href="<?= url('/') ?>" class="btn btn-primary"><i class="fas fa-home"></i> Về trang chủ</a>
</div>