@if (Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h5><i class="bi bi-exclamation-octagon me-1"></i> Error!</h5> {{ session::get('error') }}
    </div>
@endif


@if (Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h5><i class="bi bi-check-circle me-1"></i> Success!</h5> {{ session::get('success') }}
    </div>
@endif
