@extends('demo.master')
@php
    // echo $type;
@endphp
@section('content')
    <div class="container">
        <div class="flex items-start">
            @include('demo.nav')
            
            <div class="tab-content" id="tabs-tabContentVertical">
                <div class="tab-pane fade show active" id="tabs-homeVertical" role="tabpanel"
                    aria-labelledby="tabs-home-tabVertical">
                    @include('demo.demo_shared')
                </div>
                <div class="tab-pane fade" id="tabs-sharedVertical" role="tabpanel"
                    aria-labelledby="tabs-shared-tabVertical">
                    
                </div>
                <div class="tab-pane fade" id="tabs-messagesVertical" role="tabpanel"
                    aria-labelledby="tabs-profile-tabVertical">
                    Tab 3 content vertical
                </div>
            </div>
        </div>
    </div>
@endsection
