@extends('AdminDashboard.master')
@section('title', 'Create Category')

@section('content')

<div class="d-flex justify-content-between mb-24">
    <h6 class="fw-semibold">Create Category</h6>
      <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">
        Back
    </a>
</div>


<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="card">
    <div class="card-body">

<div class="row">
    <div class="mb-3 col-6">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

       <div class="mb-3 col-6">
           <label class="form-label">Parent Category</label>
            <select name="parent_id" class="form-control">
                <option value="">Main Category</option>

                @foreach($categories->where('parent_id', null) as $parent)
                    @if(isset($category) && $category->id == $parent->id)
                        @continue <!-- skip self in edit -->
                    @endif

                    <option value="{{ $parent->id }}"
                        {{ (isset($category) && $category->parent_id == $parent->id) ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>

                    @if($parent->children)
                        @foreach($parent->children as $child)
                            @if(isset($category) && $category->id == $child->id)
                                @continue
                            @endif
                            <option value="{{ $child->id }}"
                                {{ (isset($category) && $category->parent_id == $child->id) ? 'selected' : '' }}>
                                — {{ $child->name }}
                            </option>

                            @if($child->children)
                                @foreach($child->children as $subchild)
                                    @if(isset($category) && $category->id == $subchild->id)
                                        @continue
                                    @endif
                                    <option value="{{ $subchild->id }}"
                                        {{ (isset($category) && $category->parent_id == $subchild->id) ? 'selected' : '' }}>
                                        —— {{ $subchild->name }}
                                    </option>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </select>

        </div>

        <div class="mb-3 col-6" id="imageField">
            <label class="form-label">Category Image (Parent Only)</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3 col-6">
            <label class="form-label">Vendor Commission (%)</label>
            <input type="number" name="vendor_commission_percentage" class="form-control" step="0.01" min="0" max="100" value="0">
        </div>

       <div class="mb-3 col-6">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
</div>
        <button class="btn btn-primary">Save</button>

    </div>
</div>

</form>


<script>
document.addEventListener("DOMContentLoaded", function () {

    const parentSelect = document.querySelector("select[name='parent_id']");
    const imageField = document.getElementById("imageField");

    function toggleImage() {
        if(parentSelect.value === ""){
            imageField.style.display = "block";
        }else{
            imageField.style.display = "none";
        }
    }

    toggleImage();
    parentSelect.addEventListener("change", toggleImage);

});
</script>
@endsection
