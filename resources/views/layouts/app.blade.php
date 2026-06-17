<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Workia') - Empleos Bolivia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #1a56db;
            --primary-dark: #1e40af;
            --secondary: #0e9f6e;
            --danger: #e02424;
            --warning: #ff5a1f;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-900: #111827;
        }
        body { font-family: 'Segoe UI', system-ui, sans-serif; color: var(--gray-900); background: var(--gray-50); min-height: 100vh; display: flex; flex-direction: column; }

        /* Navbar */
        .navbar { background: #fff; border-bottom: 1px solid var(--gray-200); padding: 0 2rem; display: flex; align-items: center; justify-content: space-between; height: 64px; position: sticky; top: 0; z-index: 100; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        .navbar-brand { font-size: 1.5rem; font-weight: 800; color: var(--primary); text-decoration: none; letter-spacing: -0.5px; }
        .navbar-brand span { color: var(--secondary); }
        .navbar-nav { display: flex; align-items: center; gap: 0.5rem; list-style: none; }
        .navbar-nav a { color: var(--gray-700); text-decoration: none; padding: 0.4rem 0.75rem; border-radius: 6px; font-size: 0.9rem; font-weight: 500; transition: all .2s; }
        .navbar-nav a:hover { background: var(--gray-100); color: var(--primary); }
        .btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.875rem; font-weight: 600; cursor: pointer; border: none; text-decoration: none; transition: all .2s; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-outline { background: transparent; color: var(--primary); border: 1.5px solid var(--primary); }
        .btn-outline:hover { background: var(--primary); color: #fff; }
        .btn-success { background: var(--secondary); color: #fff; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-sm { padding: 0.3rem 0.7rem; font-size: 0.8rem; }
        .btn-warning { background: var(--warning); color: #fff; }
        .btn-secondary { background: var(--gray-500); color: #fff; }

        /* Alerts */
        .alert { padding: 0.85rem 1.25rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; }
        .alert-success { background: #def7ec; color: #03543f; border: 1px solid #a7f3d0; }
        .alert-error { background: #fde8e8; color: #9b1c1c; border: 1px solid #f8b4b4; }
        .alert-info { background: #e1effe; color: #1e429f; border: 1px solid #a4cafe; }

        /* Cards */
        .card { background: #fff; border-radius: 12px; border: 1px solid var(--gray-200); overflow: hidden; }
        .card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--gray-200); font-weight: 700; font-size: 1.05rem; }
        .card-body { padding: 1.5rem; }

        /* Forms */
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: 0.875rem; font-weight: 600; color: var(--gray-700); margin-bottom: 0.4rem; }
        .form-control { width: 100%; padding: 0.6rem 0.85rem; border: 1.5px solid var(--gray-300); border-radius: 8px; font-size: 0.9rem; color: var(--gray-900); background: #fff; transition: border-color .2s; }
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(26,86,219,.1); }
        .form-control.is-invalid { border-color: var(--danger); }
        .invalid-feedback { color: var(--danger); font-size: 0.8rem; margin-top: 0.25rem; }
        textarea.form-control { resize: vertical; min-height: 100px; }
        select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.75rem center; padding-right: 2.5rem; }

        /* Badge */
        .badge { display: inline-block; padding: 0.25rem 0.65rem; border-radius: 999px; font-size: 0.75rem; font-weight: 600; }
        .badge-success { background: #def7ec; color: #03543f; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fde8e8; color: #9b1c1c; }
        .badge-info { background: #e1effe; color: #1e429f; }
        .badge-secondary { background: var(--gray-200); color: var(--gray-700); }
        .badge-primary { background: #ebf5ff; color: var(--primary); }

        /* Table */
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 0.85rem 1rem; text-align: left; border-bottom: 1px solid var(--gray-200); font-size: 0.875rem; }
        .table th { font-weight: 700; color: var(--gray-700); background: var(--gray-50); }
        .table tbody tr:hover { background: var(--gray-50); }

        /* Container */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
        .container-sm { max-width: 640px; margin: 0 auto; padding: 0 1.5rem; }

        /* Footer */
        .footer { background: var(--gray-900); color: var(--gray-300); padding: 3rem 2rem 2rem; margin-top: auto; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 3rem; max-width: 1200px; margin: 0 auto 2rem; }
        .footer-brand { font-size: 1.5rem; font-weight: 800; color: #fff; margin-bottom: 0.75rem; }
        .footer-brand span { color: var(--secondary); }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 0.5rem; }
        .footer-links a { color: var(--gray-300); text-decoration: none; font-size: 0.9rem; }
        .footer-links a:hover { color: #fff; }
        .footer-bottom { text-align: center; font-size: 0.85rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,.1); max-width: 1200px; margin: 0 auto; }

        /* Sidebar layout */
        .panel-layout { display: grid; grid-template-columns: 240px 1fr; min-height: calc(100vh - 64px); }
        .sidebar { background: #fff; border-right: 1px solid var(--gray-200); padding: 1.5rem 0; }
        .sidebar-nav { list-style: none; }
        .sidebar-nav li a { display: flex; align-items: center; gap: 0.75rem; padding: 0.7rem 1.5rem; color: var(--gray-700); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: all .2s; border-left: 3px solid transparent; }
        .sidebar-nav li a:hover, .sidebar-nav li a.active { background: #eff6ff; color: var(--primary); border-left-color: var(--primary); }
        .sidebar-nav li a i { width: 18px; }
        .sidebar-section { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gray-500); padding: 1rem 1.5rem 0.5rem; }
        .panel-content { padding: 2rem; overflow-y: auto; }
        .panel-header { margin-bottom: 1.5rem; }
        .panel-header h1 { font-size: 1.5rem; font-weight: 800; color: var(--gray-900); }
        .panel-header p { color: var(--gray-500); font-size: 0.9rem; margin-top: 0.25rem; }

        /* Stats cards */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-card { background: #fff; border: 1px solid var(--gray-200); border-radius: 12px; padding: 1.25rem; }
        .stat-value { font-size: 2rem; font-weight: 800; color: var(--gray-900); }
        .stat-label { font-size: 0.85rem; color: var(--gray-500); margin-top: 0.25rem; }
        .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 0.75rem; font-size: 1.25rem; }
        .stat-icon.blue { background: #ebf5ff; color: var(--primary); }
        .stat-icon.green { background: #def7ec; color: var(--secondary); }
        .stat-icon.orange { background: #fff3e0; color: var(--warning); }
        .stat-icon.red { background: #fde8e8; color: var(--danger); }

        /* Pagination */
        .pagination { display: flex; gap: 0.35rem; list-style: none; margin-top: 1.5rem; }
        .pagination .page-link { display: block; padding: 0.4rem 0.75rem; border-radius: 6px; border: 1px solid var(--gray-200); color: var(--gray-700); text-decoration: none; font-size: 0.85rem; }
        .pagination .page-link:hover { background: var(--gray-100); }
        .pagination .active .page-link { background: var(--primary); color: #fff; border-color: var(--primary); }
        .pagination .disabled .page-link { color: var(--gray-300); cursor: not-allowed; }

        /* Job card */
        .job-card { background: #fff; border: 1px solid var(--gray-200); border-radius: 12px; padding: 1.25rem; transition: all .2s; }
        .job-card:hover { border-color: var(--primary); box-shadow: 0 4px 12px rgba(26,86,219,.1); transform: translateY(-1px); }
        .job-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1rem; }

        /* Hamburger */
        .navbar-toggle { display: none; background: none; border: none; cursor: pointer; padding: .4rem .5rem; color: var(--gray-700); font-size: 1.2rem; border-radius: 6px; }
        .navbar-toggle:hover { background: var(--gray-100); }

        @media (max-width: 768px) {
            .navbar { padding: 0 1rem; }
            .navbar-toggle { display: block; }
            .navbar-nav {
                display: none;
                position: fixed;
                top: 64px; left: 0; right: 0;
                background: #fff;
                border-bottom: 1px solid var(--gray-200);
                padding: .75rem;
                flex-direction: column;
                gap: .25rem;
                z-index: 99;
                box-shadow: 0 6px 16px rgba(0,0,0,.1);
            }
            .navbar-nav.open { display: flex; }
            .navbar-nav li { width: 100%; }
            .navbar-nav a { padding: .7rem 1rem; font-size: .95rem; display: flex; border-radius: 8px; }
            .navbar-nav .btn-outline,
            .navbar-nav .btn-primary { width: 100%; justify-content: center; }
            .navbar-nav form { width: 100%; }
            .navbar-nav form .btn { width: 100%; justify-content: center; }
            .panel-layout { grid-template-columns: 1fr; }
            .sidebar { display: none; }
            .footer-grid { grid-template-columns: 1fr; gap: 2rem; }
            .job-grid { grid-template-columns: 1fr; }
            .container { padding: 0 1rem; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">Work<span>ia</span></a>
        <button class="navbar-toggle" id="navToggle" aria-label="Menú"><i class="fas fa-bars" id="navIcon"></i></button>
        <ul class="navbar-nav" id="navMenu">
            <li><a href="{{ route('ofertas.index') }}"><i class="fas fa-briefcase"></i> Empleos</a></li>
            @auth
                @if(auth()->user()->isAdmin())
                    <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-shield-alt"></i> Admin</a></li>
                @elseif(auth()->user()->isEmpresa())
                    <li><a href="{{ route('empresa.dashboard') }}"><i class="fas fa-building"></i> Mi Empresa</a></li>
                @else
                    <li><a href="{{ route('candidato.dashboard') }}"><i class="fas fa-user"></i> Mi Panel</a></li>
                @endif
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm">Salir</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}" class="btn btn-outline btn-sm">Iniciar sesión</a></li>
                <li><a href="{{ route('register') }}" class="btn btn-primary btn-sm">Registrarse</a></li>
            @endauth
        </ul>
    </nav>

    <main style="flex:1">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">Work<span>ia</span></div>
                <p style="font-size:.9rem;line-height:1.7">Conectamos talento boliviano con las mejores oportunidades laborales del país.</p>
            </div>
            <div>
                <h4 style="color:#fff;margin-bottom:.75rem">Candidatos</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('ofertas.index') }}">Buscar empleos</a></li>
                    <li><a href="{{ route('register') }}">Crear cuenta</a></li>
                </ul>
            </div>
            <div>
                <h4 style="color:#fff;margin-bottom:.75rem">Empresas</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('register') }}">Publicar vacante</a></li>
                    <li><a href="{{ route('login') }}">Acceder</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">&copy; {{ date('Y') }} Workia Bolivia. Todos los derechos reservados.</div>
    </footer>
    @yield('scripts')
    <script>
    (function(){
        var t = document.getElementById('navToggle');
        var m = document.getElementById('navMenu');
        var i = document.getElementById('navIcon');
        if (!t) return;
        t.addEventListener('click', function(e){
            e.stopPropagation();
            var open = m.classList.toggle('open');
            i.className = open ? 'fas fa-times' : 'fas fa-bars';
        });
        document.addEventListener('click', function(e){
            if (!e.target.closest('nav.navbar')) {
                m.classList.remove('open');
                i.className = 'fas fa-bars';
            }
        });
    })();
    </script>
</body>
</html>
