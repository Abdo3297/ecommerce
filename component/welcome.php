<div class="container mt-3">
    <div class="alert alert-secondary text-capitalize" role="alert">
        <div class="d-flex align-items-center">
            <img src="../uploaded_files/<?= $_SESSION['user']['image']??''?>" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
            <div class="ms-3">
                <p class="fw-bold mb-1"><?= $_SESSION['user']['username']??''?></p>
                <p class="text-muted mb-0 text-lowercase"><?= $_SESSION['user']['email']??''?></p>
            </div>
        </div>
    </div>
</div>