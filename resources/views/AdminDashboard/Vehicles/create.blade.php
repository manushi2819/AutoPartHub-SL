@extends('AdminDashboard.master')
@section('title', isset($vehicle) ? 'Edit Vehicle' : 'Create Vehicle')

@section('content')
<div class="d-flex justify-content-between mb-24">
    <h6 class="fw-semibold">
        {{ isset($vehicle) ? 'Edit Vehicle' : 'Create Vehicle' }}
    </h6>
    <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary btn-sm">
        Back
    </a>
</div>

<div class="card mb-24">
    <div class="card-body">

        <form action="{{ isset($vehicle) ? route('admin.vehicles.update', $vehicle->id) : route('admin.vehicles.store') }}"
              method="POST" enctype="multipart/form-data" id="vehicleForm">
            @csrf
            @if(isset($vehicle))
                @method('PUT')
            @endif

            <div class="row g-3">

                {{-- Brand --}}
                <div class="col-md-6">
                    <label class="form-label">Brand <i class="text-danger">*</i></label>
                    <select name="brand_id" class="form-control" required>
                        <option value="">Select Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}"
                                {{ isset($vehicle) && $vehicle->brand_id == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Model --}}
                <div class="col-md-6">
                    <label class="form-label">Model <i class="text-danger">*</i></label>
                    <input type="text" name="model" class="form-control"
                           value="{{ $vehicle->model ?? old('model') }}" >
                </div>

                {{-- Year --}}
                <div class="col-md-6">
                    <label class="form-label">Year </label>
                    <input type="number" name="year" class="form-control"
                           value="{{ $vehicle->year ?? old('year') }}" >
                </div>

                {{-- Price --}}
                <div class="col-md-6">
                    <label class="form-label">Price (LKR)<i class="text-danger">*</i></label>
                    <input type="number" name="price" step="0.01" class="form-control"
                           value="{{ $vehicle->price ?? old('price') }}" required>
                </div>

                {{-- Mileage --}}
                <div class="col-md-6">
                    <label class="form-label">Mileage (km)</label>
                    <input type="number" name="mileage" class="form-control"
                           value="{{ $vehicle->mileage ?? old('mileage') }}">
                </div>

                {{-- Condition --}}
                <div class="col-md-6">
                    <label class="form-label">Condition <i class="text-danger">*</i></label>
                    <select name="condition" class="form-control">
                        <option value="new" {{ isset($vehicle) && $vehicle->condition == 'new' ? 'selected' : '' }}>New</option>
                        <option value="used" {{ isset($vehicle) && $vehicle->condition == 'used' ? 'selected' : '' }}>Used</option>
                        <option value="reconditioned" {{ isset($vehicle) && $vehicle->condition == 'reconditioned' ? 'selected' : '' }}>Reconditioned</option>
                    </select>
                </div>

                {{-- Fuel --}}
                <div class="col-md-6">
                    <label class="form-label">Fuel Type</label>
                    <input type="text" name="fuel_type" class="form-control"
                           value="{{ $vehicle->fuel_type ?? old('fuel_type') }}">
                </div>

                {{-- Transmission --}}
                <div class="col-md-6">
                    <label class="form-label">Transmission</label>
                    <input type="text" name="transmission" class="form-control"
                           value="{{ $vehicle->transmission ?? old('transmission') }}">
                </div>

                {{-- Engine CC --}}
                <div class="col-md-6">
                    <label class="form-label">Engine CC</label>
                    <input type="number" name="engine_cc" class="form-control"
                           value="{{ $vehicle->engine_cc ?? old('engine_cc') }}">
                </div>

                {{-- Body Type --}}
                <div class="col-md-6">
                    <label class="form-label">Body Type</label>
                    <input type="text" name="body_type" class="form-control"
                           value="{{ $vehicle->body_type ?? old('body_type') }}">
                </div>

                {{-- Color --}}
                <div class="col-md-6">
                    <label class="form-label">Color</label>
                    <input type="text" name="color" class="form-control"
                           value="{{ $vehicle->color ?? old('color') }}">
                </div>

                {{-- District --}}
                <div class="col-md-6">
                    <label class="form-label">District</label>
                    <input type="text" name="district" class="form-control"
                           value="{{ $vehicle->district ?? old('district') }}">
                </div>

                {{-- City --}}
                <div class="col-md-6">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control"
                           value="{{ $vehicle->city ?? old('city') }}">
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label">Status <i class="text-danger">*</i></label>
                    <select name="status" class="form-control">
                        <option value="1" {{ isset($vehicle) && $vehicle->status ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ isset($vehicle) && !$vehicle->status ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Description --}}

                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <div class="quill-wrapper">
                        {{-- Display existing description if editing, otherwise old input --}}
                        <div id="editor">{!! $vehicle->description ?? old('description') !!}</div>
                    </div>

                    {{-- Hidden input to submit Quill HTML --}}
                    <input type="hidden" name="description" id="description">
                </div>


            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    {{ isset($vehicle) ? 'Update Vehicle' : 'Add Vehicle' }}
                </button>
            </div>

        </form>
    </div>
</div>

{{-- IMAGE SECTION (ONLY EDIT) --}}
@if(isset($vehicle))
<div class="card mb-24">
    <div class="card-body">
        <h6 class="mb-3">Vehicle Images</h6>

        <form action="{{ route('admin.vehicles.images.upload', $vehicle->id) }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="images[]" multiple class="form-control">
            <button class="btn btn-primary mt-3">Upload</button>
        </form>

        <div class="d-flex flex-wrap gap-2 mt-3">
            @foreach($vehicle->images as $img)
                <div class="position-relative">
                    <img src="{{ asset('uploads/' . $img->image_url) }}"
                         width="100" class="border rounded">

                    <button type="button"
                        class="btn btn-sm btn-danger position-absolute top-0 end-0"
                        onclick="deleteImage('{{ route('admin.vehicles.images.delete', $img->id) }}')">
                        ×
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- SCRIPTS --}}
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">


<script>
document.addEventListener('DOMContentLoaded', function () {
    const editor = document.getElementById('editor');
    const hiddenInput = document.getElementById('description'); // use correct ID
    const form = document.querySelector('#vehicleForm'); // your product form

    if (!editor || !hiddenInput || !form) return;

    // Initialize Quill
    const quill = new Quill(editor, {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'header': [1, 2, 3, false] }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                [{ 'script': 'sub' }, { 'script': 'super' }],
                [{ 'indent': '-1' }, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // On form submit, save editor content to hidden input
    form.addEventListener('submit', function () {
        hiddenInput.value = quill.root.innerHTML;
    });
});
</script>

<script>
function deleteImage(url) {
    if (!confirm('Are you sure you want to delete this image?')) return;

    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // refresh page after delete
        } else {
            alert('Delete failed');
        }
    })
    .catch(error => {
        console.error(error);
        alert('Something went wrong');
    });
}
</script>
@endsection