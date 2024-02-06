<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <title>@yield('title')</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
         <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
         </div>
         <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item">
                   <a href="#" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/barang/')}}" class="nav-link">Data Barang</a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/jual/')}}" class="nav-link">Jual</a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/beli/')}}" class="nav-link">Beli</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"></a>
                </li>
            </ul>
         </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            @yield('content')
        </div>
    </div>
</body>
<footer>@yield('footer')</footer>
</html>