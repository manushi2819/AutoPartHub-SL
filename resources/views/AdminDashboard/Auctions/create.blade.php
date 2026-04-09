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
                <div class="mb-3 col-6">
                    <label class="form-label">Item Type <i class="text-danger">*</i></label>
                    <select name="item_type" id="item_type" class="form-control">
                        <option value="vehicle">Vehicle</option>
                        <option value="product">Spare Part</option>
                    </select>
                </div>

               <div class="mb-3 col-6">
                <label class="form-label">Select Item <i class="text-danger">*</i></label>
                <select name="item_id" id="item_id" class="form-control select2">
                </select>
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

function loadItems(type) {
    let data = type === 'vehicle' ? vehicles : products;
    let dropdown = document.getElementById('item_id');

    dropdown.innerHTML = ''; // clear previous options

    data.forEach(item => {
        let option = document.createElement('option');
        option.value = item.id;

        if(type === 'vehicle') {
            option.text = (item.brand?.name ?? '') + ' ' + item.model + ' (' + item.year + ')'  + (item.price ? ' | Price: Rs.' + item.price : '');
        } else {
            // show product name + SKU + brand
            option.text = item.name 
                + (item.sku ? ' | SKU: ' + item.sku : '') 
                + (item.brand ? ' | Brand: ' + item.brand : ''
                ) + (item.price ? ' | Price: Rs.' + item.price : ''
                );
        }

        dropdown.appendChild(option);
    });
}

// Event listener for type change
document.getElementById('item_type').addEventListener('change', function () {
    loadItems(this.value);
});

// Load vehicles by default
window.onload = () => loadItems('vehicle');
</script>

@endsection