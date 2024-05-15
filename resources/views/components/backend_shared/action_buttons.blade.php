@props([
    'urlMan' => '',
    'urlOption' => '',
    'isShowOption' => false,
    'isShowDropdown' => true,
    'isShowSaveDraft' => false,
    ])
<div class="text-sm card-footer sticky-top {{ $attributes["class"] }}" {{ $attributes }}>
    <button type="submit" class="btn btn-sm bg-gradient-primary submit-check">
        <i class="mr-2 far fa-save"></i>{{ __('Lưu') }}
    </button>
    @if ($isShowDropdown)
        <div class="pl-0 ml-1 btn dropdown">
            <button class="btn btn-sm btn-info dropdown-toggle" 
            type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ __('Thao tác') }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <button type="submit" class="btn btn-sm bg-gradient-success submit-check btn-none-css"
                    name="savehere">
                    <i class="mr-2 far fa-save"></i>{{ __('Lưu tại trang') }}
                </button>

                @if ($isShowSaveDraft)
                    <button type="submit" name="savedraft" 
                    class="btn btn-sm bg-gradient-success submit-check btn-none-css">
                        <i class="mr-2 fas fa-file-export"></i>{{ __('Lưu nháp') }}
                    </button>
                @endif
                
                <button type="reset" class="btn btn-sm bg-gradient-secondary btn-none-css">
                    <i class="mr-2 fas fa-redo"></i>{{ __('Làm lại') }}
                </button>
                <a class="btn btn-sm bg-gradient-danger btn-none-css"
                    href="{{ $urlMan }}" >
                    <i class="mr-2 fas fa-sign-out-alt"></i>{{ __('Thoát') }}
                </a>
                @if ($isShowOption)
                    <a class="btn btn-sm bg-gradient-info btn-none-css"
                        href="{{ $urlOption }}">
                        <i class="text-sm nav-icon fas fa-layer-group" target="_blank"></i> {{ __('Xem phiên bản') }}
                    </a>
                @endif
            </div>
        </div>
    @else
    <button type="reset" class="btn btn-sm bg-gradient-secondary">
        <i class="mr-2 fas fa-redo"></i> {{ __('Làm lại') }}
    </button>
    @endif
</div>