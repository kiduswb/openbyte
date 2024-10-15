<nav class="navbar navbar-expand-lg navbar-dark py-3 bg-blur sticky-top">
    <div class="container">
        <button class="navbar-toggler rounded-0 shadow-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fas text-white fa-xl fa-bars"></span>
        </button>
        <a class="navbar-brand" href="/">
            <span class="navbar-logo text-white">OpenByte</span>
        </a>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto d-flex gap-3">
                <a class="nav-link <?php echo ($activePage === 'home') ? 'active' : ''; ?>" href="/">
                    Home
                </a>
                <a class="nav-link <?php echo ($activePage === 'premium') ? 'active' : ''; ?>" href="/premium">
                    Get Premium
                </a>
                <a class="nav-link <?php echo ($activePage === 'donate') ? 'active' : ''; ?>" href="/donate">
                    Contribute
                </a>
                <a class="nav-link" href="https://forum.openbytehosting.com" target="_blank">
                    Support Forum &nbsp;<i class="fas fa-arrow-up-right-from-square"></i>
                </a>
                <a class="btn btn-outline-columbia-blue rounded-0" href="/dashboard">
                    Dashboard
                </a>
            </div>
        </div>
    </div>
</nav>
