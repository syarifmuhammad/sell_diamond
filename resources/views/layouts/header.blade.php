<header>
    {{-- <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-custom shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="https://xcashshop.com/">
                <img src="{{ asset('images/logo.png') }}" width="135px">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="mr-auto"></div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="https://xcashshop.com/"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="https://xcashshop.com/status">
                            <i class="fas fa-search"></i> Cek Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="//xcashshop.id/"><i class="fas fa-file-invoice"></i> Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="//xcoinshop.com/"><i class="fas fa-users"></i> Join
                            Reseller</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav> --}}
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-custom shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{url('/')}}">
                <img src="{{ asset('images/logo-min.png') }}" width="80px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navItem"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navItem">
                <ul class="navbar-nav">
                    <li class="nav-item me-3">
                        <a class="nav-link active" href="{{url('/')}}"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/status')}}">
                            <i class="fas fa-search"></i> Cek Pesanan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
