<form method="POST" action="/submit-registration">
    @csrf
    <!-- Isi formulir -->
    <button type="submit">Daftar</button>
</form>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
