@extends('admin.layout')

@section('title', 'Backup')
@section('page-title', 'Backup')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-1 fw-bold" style="color: #2d3748;">Site Backup</h4>
        <p class="text-muted mb-0">Download a database dump and a ZIP of uploaded images. Copies are also saved on the server.</p>
    </div>
</div>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-3 p-3 me-3" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                        <i class="bi bi-database text-white fs-4"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">Database Backup</h5>
                        <small class="text-muted">Full SQL / SQLite export</small>
                    </div>
                </div>
                <p class="card-text small text-muted mb-3">
                    Exports the current application database. On MySQL this uses <code>mysqldump</code> when available, otherwise a PHP fallback.
                </p>
                <a href="{{ route('admin.backup.database') }}" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-download me-1"></i> Download Database
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-3 p-3 me-3" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                        <i class="bi bi-images text-white fs-4"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">Images Backup</h5>
                        <small class="text-muted">ZIP archive</small>
                    </div>
                </div>
                <p class="card-text small text-muted mb-2">Includes these folders:</p>
                <ul class="small text-muted mb-3">
                    @forelse($imageSources as $source)
                        <li><code>{{ $source }}</code></li>
                    @empty
                        <li>No image folders found.</li>
                    @endforelse
                </ul>
                <a href="{{ route('admin.backup.images') }}" class="btn btn-success btn-sm w-100">
                    <i class="bi bi-download me-1"></i> Download Images ZIP
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Recent Backups on Server</h5>
    </div>
    <div class="card-body p-0">
        @if(count($recentBackups) === 0)
            <p class="text-muted mb-0 p-4">No backups created yet.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>File</th>
                            <th>Size</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBackups as $backup)
                            <tr>
                                <td><code>{{ $backup['name'] }}</code></td>
                                <td>{{ number_format($backup['size'] / 1024 / 1024, 2) }} MB</td>
                                <td>{{ \Carbon\Carbon::createFromTimestamp($backup['modified'])->format('M d, Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.backup.download', $backup['name']) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
