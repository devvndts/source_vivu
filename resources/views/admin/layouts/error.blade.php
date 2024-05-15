@if (session()->has('alert') && is_string(session()->get('alert')))
    <div class="main-header alert alert-danger" role="alert">
      <i class="fas fa-exclamation-circle"></i> {{ session()->get('alert') }}
@endif

@if (session()->has('alertSuccess') && is_string(session()->get('alertSuccess')))
    <div class="main-header alert alert-success" role="alert">
      <i class="fas fa-exclamation-circle"></i> {{ session()->get('alertSuccess') }}
    </div>
@endif