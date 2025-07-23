<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar (Opsional, Bisa Diubah Sesuai Role User) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">MyApp</a>
        <div class="d-flex">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

<!-- Header -->
<div class="container mt-4">
    <h2 class="fw-semibold">Dashboard</h2>

    <!-- Dashboard Card -->
    <div class="card mt-4 shadow">
        <div class="card-body">
            <p class="mb-0">{{ __("You're logged in!") }}</p>
        </div>
    </div>
</div>

</body>
</html>
