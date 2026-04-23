
<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AutoPartHub-SL - Admin Dashboard</title>
  <!-- Fav Icon -->
    <link rel="icon" href="{{ asset('icon.png') }}" type="image/x-icon">
  <!-- remix icon font css  -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/remixicon.css') }}">
  <!-- BootStrap css -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/bootstrap.min.css') }}">
  <!-- Apex Chart css -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/apexcharts.css') }}">
  <!-- Data Table css -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/dataTables.min.css') }}">
  <!-- Text Editor css -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/editor-katex.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/editor.atom-one-dark.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/editor.quill.snow.css') }}">
  <!-- Date picker css -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/flatpickr.min.css') }}">
  <!-- Calendar css -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/full-calendar.css') }}">
  <!-- Vector Map css -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/jquery-jvectormap-2.0.5.css') }}">
  <!-- Popup css -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/magnific-popup.css') }}">
  <!-- Slick Slider css -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/slick.css') }}">
  <!-- prism css -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/prism.css') }}">
  <!-- file upload css -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/file-upload.css') }}">
  
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />


  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/audioplayer.css') }}">
  <!-- main css -->
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/style.css') }}">

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">


  <style>
    /* simple fade out effect */
    .flash-message {
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .flash-message.fade-out {
        opacity: 0;
        transform: translateX(50px);
    }

    .quill-wrapper {
        background: #fff;
        border:1px solid #dbd9d9;
    }

    .ql-container {
        min-height: 150px;
    }

    .ql-editor {
        min-height: 150px;
    }


</style>

</head>
  
<body>

@include('AdminDashboard.sidebar')

<main class="dashboard-main">

@include('AdminDashboard.header')
  
<div class="dashboard-main-body">

    @yield('content')

    

    {{-- Notifications --}}
    <div id="flash-messages" class="position-fixed top-0 end-0 p-3" style="top: 20px !important; z-index: 1050;">
        @if(session('success'))
           <div class="alert flash-message alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between" role="alert">
                <div class="d-flex align-items-start justify-content-between text-lg">
                    <div class="d-flex align-items-start gap-2">
                        <iconify-icon icon="bi:patch-check" class="icon text-xl mt-4 flex-shrink-0"></iconify-icon>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close remove-button text-success-600" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert flash-message alert-warning bg-warning-100 text-warning-600 border-warning-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between" role="alert">
                <div class="d-flex align-items-start justify-content-between text-lg">
                    <div class="d-flex align-items-start gap-2">
                        <iconify-icon icon="mdi:clock-outline" class="icon text-xl mt-4 flex-shrink-0"></iconify-icon>
                        <div>{{ session('warning') }}</div>
                    </div>
                    <button type="button" class="btn-close remove-button text-warning-600" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error') || session('danger'))
             <div class="alert flash-message alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between" role="alert">
                <div class="d-flex align-items-start justify-content-between text-lg">
                    <div class="d-flex align-items-start gap-2">
                        <iconify-icon icon="mingcute:delete-2-line" class="icon text-xl mt-4 flex-shrink-0"></iconify-icon>
                        <div>{{ session('error') ?? session('danger') }}</div>
                    </div>
                    <button type="button" class="btn-close remove-button text-danger-600" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>




</div>

  @include('AdminDashboard.footer')
</main>
  
  <!-- jQuery library js -->
  <script src="{{ asset('dashboard/assets/js/lib/jquery-3.7.1.min.js') }}"></script>
  <!-- Bootstrap js -->
  <script src="{{ asset('dashboard/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
  <!-- Apex Chart js -->
  <script src="{{ asset('dashboard/assets/js/lib/apexcharts.min.js') }}"></script>
  <!-- Data Table js -->
  <script src="{{ asset('dashboard/assets/js/lib/dataTables.min.js') }}"></script>
  <!-- Iconify Font js -->
  <script src="{{ asset('dashboard/assets/js/lib/iconify-icon.min.js') }}"></script>
  <!-- jQuery UI js -->
  <script src="{{ asset('dashboard/assets/js/lib/jquery-ui.min.js') }}"></script>
  <!-- Vector Map js -->
  <script src="{{ asset('dashboard/assets/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script>
  <!-- Popup js -->
  <script src="{{ asset('dashboard/assets/js/lib/magnifc-popup.min.js') }}"></script>
  <!-- Slick Slider js -->
  <script src="{{ asset('dashboard/assets/js/lib/slick.min.js') }}"></script>
  <!-- prism js -->
  <script src="{{ asset('dashboard/assets/js/lib/prism.js') }}"></script>
  <!-- file upload js -->
  <script src="{{ asset('dashboard/assets/js/lib/file-upload.js') }}"></script>
  <!-- audioplayer -->
  <script src="{{ asset('dashboard/assets/js/lib/audioplayer.js') }}"></script>
  
  <!-- main js -->
  <script src="{{ asset('dashboard/assets/js/app.js') }}"></script>

  <script src="{{ asset('dashboard/assets/js/homeOneChart.js') }}"></script>
  <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
      $(document).ready(function () {
          $('#dataTable').DataTable({
              pageLength: 10
          });
      });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const flashMessages = document.querySelectorAll('#flash-messages .flash-message');

        flashMessages.forEach(msg => {
            // Auto hide after 3 seconds
            setTimeout(() => {
                msg.classList.add('fade-out');
                setTimeout(() => msg.remove(), 500); // remove after fade-out
            }, 2000);

            // Manual close button
            const btn = msg.querySelector('.remove-button');
            if(btn){
                btn.addEventListener('click', () => msg.remove());
            }
        });
    });
</script>


<!-- Small Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header text-white py-3 px-3">
        <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3 px-3 text-center">
        <p class="mb-0">Are you sure you want to delete?</p>
        <small class="text-muted">This action cannot be undone.</small>
      </div>
      <div class="modal-footer justify-content-center py-2 px-3">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <form id="deleteForm" method="POST" action="" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Yes, Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(document).on('click', '.open-delete-modal', function () {
    var url = $(this).data('url');

    $('#deleteForm').attr('action', url);

    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
});
</script>

</body>
</html>