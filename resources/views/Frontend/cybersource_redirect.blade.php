@extends('Frontend.master')

@section('title', 'Redirecting to Payment')

@section('content')
<div class="container mt-5 text-center">
    <h4>Redirecting you to the secure payment gateway...</h4>
    <form id="cybersourceForm" method="POST" action="{{ $cybsUrl }}">
        @foreach($fields as $name => $value)
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endforeach
    </form>
</div>

<script>
    document.getElementById('cybersourceForm').submit();
</script>
@endsection