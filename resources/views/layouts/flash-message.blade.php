@if ($message = Session::get('success'))
<!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><i class="fa-solid fa-circle-check"></i> {!! $message !!}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> -->
<script>
    Swal.fire({
        title: "Success!",
        text: "{!! $message !!}",
        icon: "success"
    });
</script>
{{ session()->forget('success') }}
@endif

@if ($message = Session::get('error'))
<!-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong><i class="fa-solid fa-circle-exclamation"></i> {!! $message !!}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> -->
<script>
    Swal.fire({
        title: "Error!",
        text: "{!! $message !!}",
        icon: "error"
    });
</script>
{{ session()->forget('error') }}
@endif

@if ($message = Session::get('warning'))
<!-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong> <i class="fa-solid fa-circle-exclamation"></i> {!! $message !!}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> -->
<script>
    Swal.fire({
        title: "Warning!",
        text: "{!! $message !!}",
        icon: "warning"
    });
</script>
{{ session()->forget('warning') }}
@endif

@if ($message = Session::get('info'))
<!-- <div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong><i class="fa-solid fa-circle-info"></i> {!! $message !!}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> -->
<script>
    Swal.fire({
        title: "Info!",
        text: "{!! $message !!}",
        icon: "info"
    });
</script>
{{ session()->forget('info') }}
@endif

@if ($errors->any())
<!-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fa-solid fa-circle-exclamation"></i>
    Please check the form below for errors<br />
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> -->
<script>
    Swal.fire({
        title: "Validation Error!",
        text: "",
        icon: "error"
    });
</script>
@endif