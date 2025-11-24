@extends('layouts.admin')

@section('title', 'Admin - Jobs')

@section('content')
<div class="container mt-4">
    <div class="row mb-0">
        <div class="col-lg-9 col-xl-6">
            <h4 class="mb-3">{{ $pageTitle ?? 'Jobs' }}</h4>
        </div>
        <div class="col-lg-3 col-xl-6">
            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createJob">
                <i class="bi bi-plus-circle me-1"></i> Add Job
            </button>
        </div>
    </div>
    <hr>

    <div class="table-responsive border p-3 rounded-3">
        <table class="table table-bordered table-hover table-striped mb-0" id="jobTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>No.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

{{-- Modal Create Job --}}
<div class="modal fade" id="createJob" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.jobs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Job</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Job Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter Title">
                    </div>
                    <div class="form-group mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" placeholder="Enter Description"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Image (optional)</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Job</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    $('#jobTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.jobs.get') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
