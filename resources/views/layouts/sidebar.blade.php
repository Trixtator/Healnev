<style>
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 200px;
        height: 100vh;
        background-color: #007bff;
        padding: 20px;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        z-index: 1000;
    }

    .sidebar h2 {
        font-size: 22px;
        margin-bottom: 30px;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        margin: 10px 0;
        font-weight: bold;
        transition: color 0.3s;
    }

    .sidebar a:hover {
        color: #d4d4d4;
    }

    .sidebar .nav-links {
        display: flex;
        flex-direction: column;
    }

    .logout-container {
        margin-bottom: 30px; /* Tambahan jarak dari bawah */
    }

    .logout-button {
        background: transparent;
        border: none;
        color: white;
        font-weight: bold;
        cursor: pointer;
        padding: 0;
        text-align: left;
    }

    .logout-button:hover {
        color: #d4d4d4;
    }
</style>

<div class="sidebar">
    <div>
        <h2>Admin Panel</h2>
        <div class="nav-links">
            <a href="{{ route('admin.index') }}">Dashboard</a>
            <a href="{{ route('rumahsakit.index') }}">Rumah Sakit</a>
            <a href="{{ route('paket.index') }}">Paket</a>
            <a href="{{ route('user.index') }}">Users</a>
            <a href="{{ route('admin.testimoni.index') }}">Testimoni</a>
        </div>
    </div>

    <div class="logout-container">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>
</div>
