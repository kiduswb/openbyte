<nav class="navbar navbar-expand-lg py-3">
    <div class="container">
        <button class="navbar-toggler rounded-0 shadow-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fas text-dark fa-xl fa-bars"></span>
        </button>
        <a class="navbar-brand" href="/">
            <span class="navbar-logo text-dark">OpenByte</span>
        </a>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto d-flex gap-4">
                <a class="nav-link <?php echo ($activePage === 'dashboard') ? 'active' : ''; ?>" href="/dashboard">
                    <i class="fas fa-gauge-high me-2"></i> Dashboard
                </a>
                <a class="nav-link <?php echo ($activePage === 'settings') ? 'active' : ''; ?>" href="/dashboard/settings">
                    <i class="fas fa-user-cog me-1"></i> Account Settings
                </a>
                <a class="btn btn-dark rounded-0" href="/dashboard/logout">
                    Logout <i class="fas fa-sign-out-alt ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</nav>
