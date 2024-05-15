<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Bảng điều khiển') }}</a></li>
                    <li class="breadcrumb-item active">
                        @if ((isset($request) && isset($config[$request->type])) || isset($other_title))
                            @if (isset($other_title))
                                {{ __($other_title) }}
                            @else
                                @if (isset($config[$request->type]['title_main_' . $request->category]))
                                    {{ __($config[$request->type]['title_main_' . $request->category]) }}
                                @elseif(isset($config[$request->type]['title_main']))
                                    {{ __($config[$request->type]['title_main']) }}
                                @endif
                            @endif
                        @endif
                    </li>
                </ol>
                <!--<h1 class="m-0 text-dark">Dashboard</h1>-->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
