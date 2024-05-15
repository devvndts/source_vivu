@if (!empty(session('message')))
@php
    $type = session('type') ?? 'success';
@endphp
<div class="container max-w-screen-xl">
    {{-- <div class="mb-0 alert alert-success alert-dismissible">
        <i class="fas fa-exclamation-circle"></i><strong>{{thongbao}} : </strong> {{ session('message') }}
    </div> --}}
    <x-alerts.alerts :type="$type">
        <strong>{{thongbao}} : </strong> {{ session('message') }}
    </x-alerts.alerts>
</div>
@endif
@if($errors->any())
    <div class="container max-w-screen-xl my-6">
        @foreach ($errors->all() as $error)
            <div class="flex p-4 mb-4 text-lg text-red-700 bg-red-100 rounded-lg" role="alert">
                <svg class="inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <div>
                    {{ $error }}
                </div>
            </div>
        @endforeach
    </div>
@endif
