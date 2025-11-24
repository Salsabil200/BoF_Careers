@extends('layouts.app')

@section('title', 'Recruitments')
@section('header', 'Recruitments')

@push('styles')
  <!-- DataTables (optional, biar tabel enak dipakai) -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      {{ session('success') }}
      <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="btn-group">
      <a href="{{ route('admin.recruitments.export') }}" class="btn btn-outline-success btn-rounded">
        <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
      </a>
    </div>
    <div>
      <button class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#createModal">
        <i class="bi bi-plus-lg me-1"></i> Add Recruitment
      </button>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table id="recruitmentTable" class="table table-striped table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Position</th>
              <th>Email</th>
              <th>Resume</th>
              <th>Status</th>
              <th>Applied At</th>
              <th class="text-center" style="width:120px;">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($recruitments as $r)
              <tr>
                <td>{{ $r->id }}</td>
                <td>{{ $r->name }}</td>
                <td>{{ $r->position }}</td>
                <td>{{ $r->email }}</td>
                <td>
                  @if($r->resume_path)
                    <a href="{{ Storage::url($r->resume_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary btn-rounded">
                      <i class="bi bi-paperclip"></i> File
                    </a>
                  @else
                    <span class="text-muted">—</span>
                  @endif
                </td>
                <td>
                  <span class="badge {{ $r->status === 'approved' ? 'bg-success' : ($r->status === 'rejected' ? 'bg-danger' : 'bg-secondary') }}">
                    {{ ucfirst($r->status ?? 'pending') }}
                  </span>
                </td>
                <td>{{ $r->created_at?->format('d M Y H:i') }}</td>
                <td class="text-center">
                  <a href="{{ route('admin.recruitments.edit', $r) }}" class="btn btn-sm btn-outline-primary me-1">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <form action="{{ route('admin.recruitments.destroy', $r) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Delete this item?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="8" class="text-center text-muted py-4">No data yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Create Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <form action="{{ route('admin.recruitments.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title">Add Recruitment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="applicant@mail.com" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Position</label>
                <input type="text" name="position" class="form-control" placeholder="e.g. Frontend Developer" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                  <option value="pending" selected>Pending</option>
                  <option value="approved">Approved</option>
                  <option value="rejected">Rejected</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label">Resume (PDF)</label>
                <input type="file" name="resume" class="form-control" accept="application/pdf">
                <div class="form-text">Optional. PDF only.</div>
              </div>
              <div class="col-12">
                <label class="form-label">Notes</label>
                <textarea name="notes" rows="3" class="form-control" placeholder="Notes (optional)"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(function(){
      $('#recruitmentTable').DataTable({
        pageLength: 10,
        order: [[0,'desc']],
        language: { search: "", searchPlaceholder: "Search..." }
      });
    });
  </script>
@endpush
