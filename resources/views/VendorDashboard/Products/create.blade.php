@extends('VendorDashboard.master')
@section('title', isset($product) ? 'Edit Product' : 'Create Product')

@section('content')
<div class="d-flex justify-content-between mb-24">
    <h6 class="fw-semibold">{{ isset($product) ? 'Edit Vehicle Part' : 'Create Vehicle Part' }}</h6>
     <a href="{{ route('vendor.products.index') }}" class="btn btn-secondary btn-sm">
        Back
    </a>
</div>

<div class="card mb-24">
    <div class="card-body">
        <form action="{{ isset($product) ? route('vendor.products.update', $product->id) : route('vendor.products.store') }}" 
        method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif

            <div class="row g-3">
                {{-- Product Details --}}
                <div class="col-md-6">
                    <label class="form-label">Part Name <i class="text-danger">*</i></label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name ?? old('name') }}" required>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Category <i class="text-danger">*</i></label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $main)
                            <option value="{{ $main->id }}" data-commission="{{ $main->vendor_commission_percentage ?? 0 }}" {{ isset($product) && $product->category_id == $main->id ? 'selected' : '' }}>
                                {{ $main->name }}
                            </option>

                            @foreach($main->children as $sub)
                                <option value="{{ $sub->id }}" data-commission="{{ $sub->vendor_commission_percentage ?? 0 }}" {{ isset($product) && $product->category_id == $sub->id ? 'selected' : '' }}>
                                    — {{ $sub->name }}
                                </option>

                                @foreach($sub->children as $subsub)
                                    <option value="{{ $subsub->id }}" data-commission="{{ $subsub->vendor_commission_percentage ?? 0 }}" {{ isset($product) && $product->category_id == $subsub->id ? 'selected' : '' }}>
                                        —— {{ $subsub->name }}
                                    </option>
                                @endforeach
                            @endforeach
                        @endforeach
                    </select>

                    <small id="categoryCommission" class="text-danger" style="display:none; margin-top:6px;">Admin commission: 0%</small>
                </div>

               <div class="col-md-6">
                    <label class="form-label">Vehicle Type <i class="text-danger">*</i></label>

                    <div class="border p-3 rounded" style="max-height: 180px; overflow-y: auto;">
                        @foreach($vehicleTypes as $type)
                            <div class="form-check">
                                <input class="form-check-input  ms-3"
                                    type="checkbox"
                                    name="vehicle_type_ids[]"
                                    value="{{ $type->id }}"
                                    id="vt{{ $type->id }}"
                                    {{ isset($product) && in_array($type->id, $product->vehicle_type_ids ?? []) ? 'checked' : '' }}>

                                <label class="form-check-label ms-1" for="vt{{ $type->id }}">
                                    {{ $type->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>


                  <div class="col-md-6">
                    <label class="form-label">Condition <i class="text-danger">*</i></label>

                    @php
                        $selected = old('condition', $product->condition ?? '');
                    @endphp

                    <select name="condition" class="form-control">
                        <option value="">-- Select Condition --</option>

                        <option value="Brand New" {{ $selected == 'Brand New' ? 'selected' : '' }}>Brand New</option>
                        <option value="Used" {{ $selected == 'Used' ? 'selected' : '' }}>Used</option>
                    </select>
                </div>

            
                <div class="col-md-6">
                    <label class="form-label">Price <i class="text-danger">*</i></label>
                    <input type="number" id="productPrice" name="price" class="form-control" step="0.01" value="{{ $product->price ?? old('price') }}" required>
                    <small id="commissionAmount" class="text-muted" style="display:none; margin-top:6px;">Commission (0%): LKR 0.00</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Cost Price</label>
                    <input type="number" name="cost_price" class="form-control" step="0.01" value="{{ $product->cost_price ?? old('cost_price') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Stock Quantity <i class="text-danger">*</i></label>
                    <input type="number" name="stock_quantity" class="form-control" value="{{ $product->stock_quantity ?? old('stock_quantity') }}" required>
                </div>

                  <div class="col-md-6">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" value="{{ $product->sku ?? '' }}" placeholder="AUTO-GENERATED" readonly>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Status <i class="text-danger">*</i></label>
                    <select name="status" class="form-control">
                        <option value="1" {{ isset($product) && $product->status ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ isset($product) && !$product->status ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Small Description</label>
                    <textarea name="small_description" class="form-control" rows="3">{{ $product->small_description ?? old('small_description') }}</textarea>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <div class="quill-wrapper">
                        {{-- Display existing description if editing, otherwise old input --}}
                        <div id="editor">{!! $product->description ?? old('description') !!}</div>
                    </div>

                    {{-- Hidden input to submit Quill HTML --}}
                    <input type="hidden" name="description" id="description">
                </div>

                <hr>
                 <h6 class="fw-semibold">Vehicle Compatibility</h6>
                {{-- Single Compatibility --}}

                  <div class="col-md-6">
                    <label class="form-label">Brand <i class="text-danger">*</i></label>
                    <select name="brand_id" class="form-control">
                        <option value="">Select Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}"
                                {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Model <i class="text-danger">*</i></label>
                    <input type="text" name="compatibility_model" class="form-control" 
                        value="{{ $product->compatibility->model ?? '' }}" placeholder="e.g., Corolla" >
                </div>

                <div class="col-md-6">
                    <label class="form-label">Year <i class="text-danger">*</i></label>
                    <input type="number" name="compatibility_year_from" class="form-control" 
                        value="{{ $product->compatibility->year_from ?? '' }}" placeholder="e.g., 2010">
                </div>

                <!--<div class="col-md-6">
                    <label class="form-label">Year To</label>
                    <input type="number" name="compatibility_year_to" class="form-control" 
                        value="{{ $product->compatibility->year_to ?? '' }}" placeholder="e.g., 2015">
                </div>-->

                <div class="col-md-6">
                    <label class="form-label">Engine Type </label>
                    <input type="text" name="engine_type" class="form-control" 
                        value="{{ $product->compatibility->engine_type ?? '' }}" placeholder="e.g., V6">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Engine CC</label>
                    <input type="number" name="engine_cc" class="form-control" 
                        value="{{ $product->compatibility->engine_cc ?? '' }}" placeholder="e.g., 2000">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Fuel Type</label>

                    @php
                        $selected = old('fuel_type', $product->compatibility->fuel_type ?? '');
                    @endphp

                    <select name="fuel_type" class="form-control">
                        <option value="">-- Select Fuel Type --</option>

                        <option value="Petrol" {{ $selected == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                        <option value="Diesel" {{ $selected == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="Electric" {{ $selected == 'Electric' ? 'selected' : '' }}>Electric</option>
                        <option value="Hybrid" {{ $selected == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                        <option value="Gas" {{ $selected == 'Gas' ? 'selected' : '' }}>Gas</option>
                    </select>
                </div>

               <div class="col-md-6">
                    <label class="form-label">Transmission</label>
                    <select name="transmission" class="form-control">
                        <option value="">-- Select Transmission --</option>

                        <option value="Automatic"
                            {{ ($product->compatibility->transmission ?? '') == 'Automatic' ? 'selected' : '' }}>
                            Automatic
                        </option>

                        <option value="Manual"
                            {{ ($product->compatibility->transmission ?? '') == 'Manual' ? 'selected' : '' }}>
                            Manual
                        </option>

                        <option value="Both"
                            {{ ($product->compatibility->transmission ?? '') == 'Both' ? 'selected' : '' }}>
                            Both Automatic & Manual
                        </option>
                    </select>
                </div>

            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary btn-sm">{{ isset($product) ? 'Update Product' : 'Add Product' }}</button>
            </div>
        </form>
    </div>
</div>

@if(isset($product))
<div class="card mb-24">
    <div class="card-body">
        <h6 class="mb-3">Product Images</h6>

        {{-- Upload Form --}}
        <form action="{{ route('vendor.products.images.upload', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Upload Images</label>
                <input type="file" name="images[]" multiple class="form-control" accept="image/*">
            </div>
            <button class="btn btn-primary btn-sm mt-2">Upload</button>
        </form>

        {{-- Display Images --}}
        <div class="mb-3 d-flex flex-wrap gap-2 mt-3">
            @foreach($product->images as $img)
                <div class="position-relative">
                    <img src="{{ asset('uploads/' . $img->image_url) }}" alt="" width="100" class="border rounded">

                    {{-- Delete Button --}}
                    <button 
                        type="button" 
                        class="btn btn-sm btn-danger position-absolute top-0 end-0" 
                        onclick="deleteImage('{{ route('vendor.products.images.delete', $img->id) }}')">
                        ×
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
function deleteImage(url) {
    if(!confirm('Are you sure you want to delete this image?')) return;

    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
    })
    .then(res => {
        if(res.ok) {
            location.reload(); // reload page after delete
        } else {
            alert('Failed to delete image.');
        }
    })
}
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {

    function getSelectedCommission() {
        const opt = document.querySelector("select[name='category_id'] option:checked");
        if (!opt) return 0;
        return parseFloat(opt.dataset.commission || 0);
    }

    const categorySelect = document.querySelector("select[name='category_id']");
    const commissionLabel = document.getElementById('categoryCommission');
    const priceInput = document.getElementById('productPrice');
    const commissionAmount = document.getElementById('commissionAmount');

    function updateCommissionDisplay() {
        const pct = getSelectedCommission();

        if (pct && pct > 0) {
            commissionLabel.style.display = 'block';
            commissionLabel.textContent = `Admin commission: ${pct.toFixed(2)}%`;
        } else {
            commissionLabel.style.display = 'none';
        }

        const price = parseFloat(priceInput.value) || 0;
        const amount = (price * pct) / 100;
        if (price > 0 && pct > 0) {
            commissionAmount.style.display = 'block';
            commissionAmount.textContent = `Commission (${pct.toFixed(2)}%): LKR ${amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
        } else {
            commissionAmount.style.display = 'none';
        }
    }

    updateCommissionDisplay();

    categorySelect.addEventListener('change', updateCommissionDisplay);
    priceInput && priceInput.addEventListener('input', updateCommissionDisplay);

});
</script>

<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editor = document.getElementById('editor');
    const hiddenInput = document.getElementById('description'); // use correct ID
    const form = document.querySelector('#productForm'); // your product form

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

@endsection
