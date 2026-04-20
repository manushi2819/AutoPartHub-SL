@extends('Frontend.master')

@section('title', 'Vehicle Details - AutoPartHub SL')

@section('content')

<style>
    /* Theme Colors */

    /* Vehicle Details Section */
    .vehicle-details {
        font-family: 'Poppins', sans-serif;
    }

    /* Gallery Section */
    .gallery-wrapper {
        display: flex;
        gap: 15px;
    }

    .thumbnail-vertical {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100px;
    }

    .thumbnail-vertical .thumb-img {
        width: 100%;
        height: 80px;
        object-fit: cover !important;
        border-radius: 0px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .thumbnail-vertical .thumb-img:hover {
        border-color: var(--primary-red);
        transform: translateX(-5px);
    }

    .thumbnail-vertical .thumb-img.active {
        border-color: var(--primary-red);
        box-shadow: 0 0 0 2px rgba(194,13,13,0.2);
    }

    .main-image-container {
        flex: 1;
    }

    .main-image-container img {
        width: 100%;
        height: 450px;
        object-fit: cover;
        border-radius: 0px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    /* Vehicle Info */
    .vehicle-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--primary-black);
        margin-bottom: 15px;
    }

    .vehicle-price {
        font-size: 32px;
        font-weight: 700;
        color: var(--primary-red);
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .details-list {
        list-style: none;
        padding: 0;
        margin: 10px 0;
    }

    .details-list li {
        padding: 5px 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        font-size: 14px;
    }

    .details-list li strong {
        width: 110px;
        color: var(--primary-black);
        font-weight: 600;
    }

    .details-list li i {
        width: 15px;
        color: var(--primary-red);
        margin-right: 10px;
    }

    /* Contact Section */
    .contact-card {
        background: var(--light-gray);
        padding: 20px;
        border-radius: 0px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }

    .contact-info {
        margin-bottom: 15px;
    }

    .contact-info p {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .contact-info i {
        width: 30px;
        color: var(--primary-red);
        font-size: 16px;
    }

    /* Description Box */
    .description-box {
        background: #ffffff;
        border: 1px solid #f0f0f0;
        border-radius: 0px;
        padding: 25px;
        margin-top: 30px;
        line-height: 1.8;
        color: #555;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }

    .description-box h4 {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-black);
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary-red);
        display: inline-block;
    }

    /* Inquiry Form */
    .inquiry-box {
        background: #ffffff;
        border: 1px solid #f0f0f0;
        border-radius: 0px;
        padding: 25px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }

    .inquiry-box h4 {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-black);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary-red);
        display: inline-block;
    }

    /* Form Styles */
    .form-control, select.form-control {
        border: 2px solid #e0e0e0;
        border-radius: 0px;
        padding: 10px 12px;
        transition: all 0.3s ease;
        font-size: 14px;
        width: 100%;
    }

    .form-control:focus, select.form-control:focus {
        border-color: var(--primary-red);
        box-shadow: 0 0 0 0.2rem rgba(194,13,13,0.1);
        outline: none;
    }

    .btn-dark {
        background: var(--primary-black);
        border: none;
        border-radius: 0px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-dark:hover {
        background: var(--primary-red);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(194,13,13,0.3);
    }

    /* Similar Vehicles Card */
    .vehicle-card {
        background: #ffffff;
        border: none;
        border-radius: 0px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        height: 100%;
    }

    .vehicle-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .vehicle-image {
        overflow: hidden;
        height: 200px;
    }

    .vehicle-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .vehicle-card:hover .vehicle-image img {
        transform: scale(1.05);
    }

    .vehicle-card .card-body {
        padding: 15px;
    }

    .vehicle-card h6 {
        font-size: 16px;
        font-weight: 700;
        color: var(--primary-black);
        margin-bottom: 8px;
    }

    .vehicle-card p {
        font-size: 13px;
        color: #666;
        margin-bottom: 8px;
    }

    .vehicle-card strong {
        font-size: 18px;
        color: var(--primary-red);
        display: block;
        margin-bottom: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .gallery-wrapper {
            flex-direction: column-reverse;
        }
        
        .thumbnail-vertical {
            flex-direction: row;
            width: 100%;
        }
        
        .thumbnail-vertical .thumb-img {
            width: 80px;
            height: 70px;
        }
        
        .main-image-container img {
            height: 300px;
        }
        
        .vehicle-title {
            font-size: 22px;
        }
        
        .vehicle-price {
            font-size: 24px;
        }
        
        .details-list li strong {
            width: 100px;
            font-size: 13px;
        }
    }

.share-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.whatsapp-btn {
    background: #25D366;
    color: white;
    box-shadow: 0 2px 8px rgba(37, 211, 102, 0.3);
}

.whatsapp-btn:hover {
    background: #128C7E;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
    color: white;
}

.facebook-btn {
    background: #1877F2;
    color: white;
    box-shadow: 0 2px 8px rgba(24, 119, 242, 0.3);
}

.facebook-btn:hover {
    background: #0C5D9E;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(24, 119, 242, 0.4);
    color: white;
}

.share-btn i {
    font-size: 18px;
}

@media (max-width: 576px) {
    .share-btn {
        padding: 10px 12px;
        font-size: 12px;
        gap: 6px;
    }
    
    .share-btn i {
        font-size: 14px;
    }
}
</style>

<section class="vehicle-details pt-5 pb-5">
    <div class="auto-container">
        <div class="row">
            {{-- LEFT COLUMN: IMAGES AND DETAILS --}}
            <div class="col-lg-8">
                {{-- IMAGES WITH VERTICAL THUMBNAILS --}}
                <div class="gallery-wrapper">
                    {{-- VERTICAL THUMBNAILS --}}
                    <div class="thumbnail-vertical">
                        @foreach($vehicle->images as $index => $img)
                            <img src="{{ asset('uploads/'.$img->image_url) }}"
                                 class="thumb-img {{ $index == 0 ? 'active' : '' }}"
                                 onclick="changeImage(this)"
                                 alt="Thumbnail {{ $index + 1 }}">
                        @endforeach
                    </div>

                    {{-- MAIN IMAGE --}}
                    @php
                        $mainImage = $vehicle->images->first();
                    @endphp

                    <div class="main-image-container">
                        <img id="mainImage"
                             src="{{ $mainImage ? asset('uploads/'.$mainImage->image_url) : asset('no-image.png') }}"
                             alt="Main Vehicle Image">
                    </div>
                </div>

                
             <div class="description-box mt-3">
                <h4 class="mb-3"><i class="fas fa-share-alt"></i> Share This Vehicle</h4>
                <div class="d-flex gap-3">
                    @php
                        $vehicleLink = route('Frontend.vehicle.details', $vehicle->id);
                        $encodedLink = urlencode($vehicleLink);
                        $whatsappMessage = urlencode("Check out this vehicle: $vehicleLink");
                    @endphp

                    <!-- WhatsApp Share -->
                    <a href="https://wa.me/?text={{ $whatsappMessage }}" 
                    target="_blank"
                    class="share-btn whatsapp-btn">
                        <i class="fab fa-whatsapp"></i> Share on WhatsApp
                    </a>

                    <!-- Facebook Share -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedLink }}" 
                    target="_blank"
                    class="share-btn facebook-btn">
                        <i class="fab fa-facebook-f"></i> Share on Facebook
                    </a>
                </div>
            </div>


                {{-- DESCRIPTION BOX --}}
                <div class="description-box">
                    <h4><i class="fas fa-file-alt me-2"></i> Description</h4>
                    <div style="margin-top: 15px;">
                        {!! $vehicle->description !!}
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: CONTACT SELLER & INQUIRY FORM --}}
            <div class="col-lg-4">
                 {{-- VEHICLE DETAILS --}}
                <div class="contact-card">
                    <h3 class="vehicle-title">{{ $vehicle->brand->name }} {{ $vehicle->model }}</h3>

                    <div class="vehicle-price">
                        LKR {{ number_format($vehicle->price) }}
                    </div>

                    <ul class="details-list">
                        <li><i class="fas fa-calendar-alt"></i> <strong>Year:</strong> {{ $vehicle->year }}</li>
                        <li><i class="fas fa-info-circle"></i> <strong>Condition:</strong> {{ $vehicle->condition }}</li>
                        <li><i class="fas fa-gas-pump"></i> <strong>Fuel:</strong> {{ $vehicle->fuel_type }}</li>
                        <li><i class="fas fa-cogs"></i> <strong>Transmission:</strong> {{ $vehicle->transmission }}</li>
                        <li><i class="fas fa-road"></i> <strong>Mileage:</strong> {{ number_format($vehicle->mileage) }} km</li>
                        <li><i class="fas fa-car-battery"></i> <strong>Engine:</strong> {{ $vehicle->engine_cc }} cc</li>
                        <li><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> {{ $vehicle->district }} - {{ $vehicle->city }}</li>
                    </ul>
                </div>
                {{-- CONTACT SELLER --}}
                <div class="contact-card mt-1">
                  
                    @php
                    $whatsappNumber = '94716136143'; // Seller number without +
                    $vehicleLink = route('Frontend.vehicle.details', $vehicle->id); // Full vehicle URL

                    $message = "Hello, I'm interested in your vehicle:\n\n" .
                            "Brand: {$vehicle->brand->name}\n" .
                            "Model: {$vehicle->model}\n" .
                            "Year: {$vehicle->year}\n" .
                            "Price: LKR " . number_format($vehicle->price) . "\n\n" .
                            "View Vehicle: {$vehicleLink}";

                    $encodedMessage = urlencode($message);
                    @endphp

                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $encodedMessage }}" 
                    target="_blank" 
                    class="btn btn-dark w-100 mt-3">
                    Contact via WhatsApp
                    </a>

                   
                </div>

                {{-- INQUIRY FORM --}}
                <div class="inquiry-box mt-4" id="inquiry-form">
                    <h4><i class="fas fa-paper-plane me-2"></i> Send Inquiry</h4>
                    
                    <form action="{{ route('vehicle.inquiry') }}" method="POST">
                        @csrf
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                        <div class="row g-3">
                            <div class="col-12">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>

                            <div class="col-12">
                                <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                            </div>

                            <div class="col-12">
                                <select name="district" class="form-control" required>
                                    <option value="">Select District</option>
                                    <option>Colombo</option>
                                    <option>Kandy</option>
                                    <option>Galle</option>
                                    <option>Kurunegala</option>
                                    <option>Jaffna</option>
                                    <option>Gampaha</option>
                                    <option>Kalutara</option>
                                    <option>Matara</option>
                                    <option>Negombo</option>
                                    <option>Anuradhapura</option>
                                    <option>Polonnaruwa</option>
                                    <option>Badulla</option>
                                    <option>Ratnapura</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <input type="text" name="phone" class="form-control" placeholder="Mobile Number" required>
                            </div>

                            <div class="col-12">
                                <textarea name="message" class="form-control" rows="4" placeholder="Your Message..."></textarea>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-dark w-100">
                                    <i class="fas fa-send"></i> Send Inquiry
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- SIMILAR VEHICLES SECTION --}}
        @if($similarVehicles->count() > 0)
        <div class="mt-5">
            <h4 class="mb-4" style="font-weight: 700; color: var(--primary-black);">
                <i class="fas fa-car"></i> Similar Vehicles
            </h4>

            <div class="row">
                @foreach($similarVehicles as $item)
                    @php
                        $image = $item->images->first();
                    @endphp

                    <div class="col-md-3 mb-4">
                        <div class="vehicle-card">
                            <div class="vehicle-image">
                                <img src="{{ $image ? asset('uploads/'.$image->image_url) : asset('no-image.png') }}"
                                     alt="{{ $item->brand->name }} {{ $item->model }}">
                            </div>
                            <div class="card-body">
                                <h6>{{ $item->brand->name }} {{ $item->model }}</h6>
                                <p>{{ $item->year }} • {{ $item->fuel_type }}</p>
                                <strong>LKR {{ number_format($item->price) }}</strong>
                                <a href="{{ route('Frontend.vehicle.details', $item->id) }}"
                                   class="btn btn-dark w-100 mt-2">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

{{-- JS for Image Gallery --}}
<script>
function changeImage(el) {
    // Update main image
    document.getElementById('mainImage').src = el.src;
    
    // Remove active class from all thumbnails
    var thumbs = document.querySelectorAll('.thumb-img');
    thumbs.forEach(function(thumb) {
        thumb.classList.remove('active');
    });
    
    // Add active class to clicked thumbnail
    el.classList.add('active');
}
</script>

@endsection