<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') - Workia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root { --primary: #1a56db; --primary-dark: #1e40af; --secondary: #0e9f6e; --danger: #e02424; --warning: #ff5a1f; --gray-50: #f9fafb; --gray-100: #f3f4f6; --gray-200: #e5e7eb; --gray-300: #d1d5db; --gray-500: #6b7280; --gray-700: #374151; --gray-900: #111827; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; color: var(--gray-900); background: var(--gray-50); }
        .topbar { background: #fff; border-bottom: 1px solid var(--gray-200); padding: 0 1.5rem; display: flex; align-items: center; justify-content: space-between; height: 58px; position: sticky; top: 0; z-index: 100; }
        .topbar-brand { font-size: 1.25rem; font-weight: 800; color: var(--primary); text-decoration: none; }
        .topbar-brand span { color: var(--secondary); }
        .topbar-right { display: flex; align-items: center; gap: 1rem; }
        .topbar-user { font-size: .875rem; color: var(--gray-700); font-weight: 600; }
        .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .45rem .9rem; border-radius: 8px; font-size: .875rem; font-weight: 600; cursor: pointer; border: none; text-decoration: none; transition: all .2s; }
        .btn-primary { background: var(--primary); color: #fff; } .btn-primary:hover { background: var(--primary-dark); }
        .btn-outline { background: transparent; color: var(--primary); border: 1.5px solid var(--primary); } .btn-outline:hover { background: var(--primary); color: #fff; }
        .btn-success { background: var(--secondary); color: #fff; } .btn-danger { background: var(--danger); color: #fff; }
        .btn-warning { background: var(--warning); color: #fff; } .btn-secondary { background: var(--gray-500); color: #fff; }
        .btn-sm { padding: .3rem .65rem; font-size: .78rem; }
        .layout { display: grid; grid-template-columns: 220px 1fr; min-height: calc(100vh - 58px); }
        .sidebar { background: #fff; border-right: 1px solid var(--gray-200); }
        .sidebar-nav { list-style: none; padding: 1rem 0; }
        .sidebar-nav li a { display: flex; align-items: center; gap: .75rem; padding: .65rem 1.25rem; color: var(--gray-700); text-decoration: none; font-size: .875rem; font-weight: 500; border-left: 3px solid transparent; transition: all .2s; }
        .sidebar-nav li a:hover, .sidebar-nav li a.active { background: #eff6ff; color: var(--primary); border-left-color: var(--primary); }
        .sidebar-nav li a i { width: 16px; }
        .sidebar-sep { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--gray-500); padding: 1rem 1.25rem .4rem; }
        .content { padding: 1.75rem; overflow-y: auto; }
        .page-header { margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
        .page-header h1 { font-size: 1.4rem; font-weight: 800; }
        .page-header p { color: var(--gray-500); font-size: .875rem; margin-top: .2rem; }
        .alert { padding: .8rem 1.1rem; border-radius: 8px; margin-bottom: 1rem; font-size: .875rem; display: flex; align-items: center; gap: .5rem; }
        .alert-success { background: #def7ec; color: #03543f; border: 1px solid #a7f3d0; }
        .alert-error { background: #fde8e8; color: #9b1c1c; border: 1px solid #f8b4b4; }
        .alert-info { background: #e1effe; color: #1e429f; border: 1px solid #a4cafe; }
        .card { background: #fff; border-radius: 12px; border: 1px solid var(--gray-200); overflow: hidden; }
        .card-header { padding: 1rem 1.25rem; border-bottom: 1px solid var(--gray-200); font-weight: 700; display: flex; align-items: center; justify-content: space-between; }
        .card-body { padding: 1.25rem; }
        .form-group { margin-bottom: 1.1rem; }
        .form-label { display: block; font-size: .8rem; font-weight: 600; color: var(--gray-700); margin-bottom: .35rem; }
        .form-control { width: 100%; padding: .55rem .8rem; border: 1.5px solid var(--gray-300); border-radius: 8px; font-size: .875rem; color: var(--gray-900); background: #fff; transition: border-color .2s; }
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(26,86,219,.08); }
        textarea.form-control { resize: vertical; min-height: 90px; }
        select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right .7rem center; padding-right: 2.2rem; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: .7rem .9rem; text-align: left; border-bottom: 1px solid var(--gray-200); font-size: .85rem; }
        .table th { font-weight: 700; color: var(--gray-700); background: var(--gray-50); font-size: .78rem; text-transform: uppercase; letter-spacing: .04em; }
        .table tbody tr:hover { background: var(--gray-50); }
        .badge { display: inline-block; padding: .2rem .6rem; border-radius: 999px; font-size: .72rem; font-weight: 700; }
        .badge-success { background: #def7ec; color: #03543f; } .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fde8e8; color: #9b1c1c; } .badge-info { background: #e1effe; color: #1e429f; }
        .badge-secondary { background: var(--gray-200); color: var(--gray-700); } .badge-primary { background: #ebf5ff; color: var(--primary); }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit,minmax(160px,1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-card { background: #fff; border: 1px solid var(--gray-200); border-radius: 12px; padding: 1.1rem; }
        .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: .65rem; font-size: 1.1rem; }
        .stat-icon.blue { background: #ebf5ff; color: var(--primary); } .stat-icon.green { background: #def7ec; color: var(--secondary); }
        .stat-icon.orange { background: #fff3e0; color: var(--warning); } .stat-icon.red { background: #fde8e8; color: var(--danger); }
        .stat-value { font-size: 1.75rem; font-weight: 800; } .stat-label { font-size: .8rem; color: var(--gray-500); margin-top: .2rem; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }

        /* Mobile sidebar drawer */
        .sidebar-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:199; }
        .sidebar-overlay.open { display:block; }
        .topbar-toggle { display:none; background:none; border:none; cursor:pointer; padding:.4rem .5rem; color:var(--gray-700); font-size:1.2rem; border-radius:6px; margin-right:.5rem; }
        .topbar-toggle:hover { background:var(--gray-100); }

        @media(max-width:768px) {
            .layout { grid-template-columns:1fr; }
            .sidebar {
                display:block;
                position:fixed;
                left:-220px; top:0; bottom:0;
                width:220px;
                z-index:200;
                transition:left .28s cubic-bezier(.4,0,.2,1);
                overflow-y:auto;
                box-shadow:4px 0 20px rgba(0,0,0,.15);
            }
            .sidebar.open { left:0; }
            .grid-2, .grid-3 { grid-template-columns:1fr; }
            .topbar-toggle { display:inline-flex; align-items:center; }
            .topbar { padding:0 1rem; gap:.5rem; }
            .topbar-user { display:none; }
            .content { padding:1.25rem 1rem; }
            .page-header { flex-direction:column; align-items:flex-start; }
        }
    </style>
    @yield('styles')
</head>
<body>
<header class="topbar">
    <button class="topbar-toggle" id="sidebarToggle" aria-label="Menú"><i class="fas fa-bars"></i></button>
    <a href="{{ route('home') }}" class="topbar-brand">Work<span>ia</span></a>
    <div class="topbar-right">
        <span class="topbar-user"><i class="fas fa-user-circle" style="color:#1a56db"></i> {{ auth()->user()->name }}</span>
        <a href="{{ route('ofertas.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-briefcase"></i> Ver empleos</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button class="btn btn-secondary btn-sm"><i class="fas fa-sign-out-alt"></i> Salir</button>
        </form>
    </div>
</header>

<div class="sidebar-overlay" id="sidebarOverlay"></div>
<div class="layout">
    <aside class="sidebar" id="panelSidebar">
        <ul class="sidebar-nav">
            @yield('sidebar-links')
        </ul>
    </aside>
    <main class="content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif
        @yield('panel-content')
    </main>
</div>
@yield('scripts')
<script>
(function(){
    var toggle  = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('panelSidebar');
    var overlay = document.getElementById('sidebarOverlay');
    if (!toggle) return;
    toggle.addEventListener('click', function(){
        sidebar.classList.toggle('open');
        overlay.classList.toggle('open');
    });
    overlay.addEventListener('click', function(){
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
    });
})();
</script>
</body>
</html>
