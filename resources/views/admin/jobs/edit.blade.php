@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Job</h2>

        <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Judul Pekerjaan</label>
                <input type="text" name="title" class="form-control" value="{{ $job->title }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="6">{{ $job->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label>
                <img id="preview" src="{{ asset('storage/jobs/' . $job->image) }}" width="200" class="mb-3 rounded">
            </div>

            <div class="mb-3">
                <label class="form-label">Ganti Gambar</label>
                <input type="file" name="image" class="form-control" onchange="previewImage(event)">
            </div>

            <button type="submit" class="btn btn-primary">Update Job</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            document.getElementById('preview').src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
