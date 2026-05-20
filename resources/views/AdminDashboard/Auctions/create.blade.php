@extends('AdminDashboard.master')
@section('title', 'Create Auction')

@section('content')


<div class="d-flex justify-content-between mb-24">
    <h6 class="fw-semibold">Create Auction</h6>
      <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
        Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.auctions.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="mb-1 col-6">
                    <label class="form-label">Item Type <i class="text-danger">*</i></label>
                    <select name="item_type" id="item_type" class="form-control">
                        <option value="vehicle">Vehicle</option>
                        <option value="product">Spare Part</option>
                    </select>
                </div>

                <div class="mb-1 col-6">
                    <label class="form-label">Select Item <i class="text-danger">*</i></label>
                    <select name="item_id" id="item_id" class="form-control select2">
                    </select>
                </div>
                <div class="mb-3 col-12">
                    <div id="selected-item-preview"></div>
                </div>

                <div class="mb-3 col-6">
                    <label class="form-label">Start Time <i class="text-danger">*</i></label>
                    <input type="datetime-local" name="start_time" class="form-control">
                </div>

                <div class="mb-3 col-6">
                    <label class="form-label">End Time <i class="text-danger">*</i></label>
                    <input type="datetime-local" name="end_time" class="form-control">
                </div>

                <div class="mb-3 col-6">
                    <label class="form-label">Starting Price <i class="text-danger">*</i></label>
                    <input type="number" name="starting_price" class="form-control">
                </div>

                <div class="mb-3 col-6">
                    <label class="form-label">Bid Increment <i class="text-danger">*</i></label>
                    <input type="number" name="bid_increment" class="form-control">
                </div>

                <div class="mb-3 col-6">
                    <label class="form-label">Active Status <i class="text-danger">*</i></label>
                    <select name="is_active" class="form-control">
                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Auto Status (read-only) --}}
                <div class="mb-3 col-6">
                    <label class="form-label">Auction Status <i class="text-muted">(auto)</i></label>
                    <input type="text" class="form-control" value="upcoming" disabled>
                </div>
            </div>

            <button class="btn btn-primary btn-sm">Create Auction</button>
        </form>
      </div>
</div>



<script>
let vehicles = @json($vehicles);
let products = @json($products);

function truncateText(text, limit = 45) {
    return text.length > limit ? text.substring(0, limit) + '...' : text;
}

function getImage(item, type) {

    if(type === 'vehicle') {

        if(item.images && item.images.length > 0) {
            return '/uploads/' + item.images[0].image_url;
        }

    } else {

        if(item.images && item.images.length > 0) {
            return '/uploads/' + item.images[0].image_url;
        }
    }

    return '/no-image.png';
}

function loadItems(type) {

    let data = type === 'vehicle' ? vehicles : products;

    let dropdown = document.getElementById('item_id');

    dropdown.innerHTML = '';

    data.forEach(item => {

        let option = document.createElement('option');

        option.value = item.id;

        if(type === 'vehicle') {

            option.text =
                (item.brand?.name ?? '') + ' ' +
                item.model + ' (' + item.year + ')' +
                (item.price ? ' | Rs.' + item.price : '');

        } else {

            let shortName = truncateText(item.name, 40);

            option.text =
                shortName +
                (item.sku ? ' | SKU: ' + item.sku : '') +
                (item.brand?.name ? ' | ' + item.brand.name : '') +
                (item.price ? ' | Rs.' + item.price : '');
        }

        dropdown.appendChild(option);
    });

    updatePreview(type);
}

function updatePreview(type) {

    let data = type === 'vehicle' ? vehicles : products;

    let selectedId = document.getElementById('item_id').value;

    let item = data.find(i => i.id == selectedId);

    if(!item) return;

    let image = getImage(item, type);

    document.getElementById('selected-item-preview').innerHTML = `
        <div class="mt-3">
            <img src="${image}" 
                 style="
                    width:220px;
                    height:160px;
                    object-fit:cover;
                    border-radius:10px;
                    border:1px solid #ddd;
                 ">
        </div>
    `;
}

// Type change
document.getElementById('item_type').addEventListener('change', function () {
    loadItems(this.value);
});

// Item change
document.getElementById('item_id').addEventListener('change', function () {
    updatePreview(document.getElementById('item_type').value);
});

// Initial load
window.onload = () => {
    loadItems('vehicle');
};
</script>

@endsection