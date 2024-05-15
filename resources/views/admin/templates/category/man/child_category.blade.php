@php
    $v = $categories;
    $path_upload = config('config_all.fileupload') ? config('config_upload.UPLOAD_GALLERY') : config('config_upload.UPLOAD_CATEGORY');
    $photoUrl = Thumb::Crop($path_upload, $v['photo'], 150, 150, 3, null, 'jpg');
    $editUrl = route('admin.category.edit', [$type, $v['id'] ?? 0]);
    $deleteUrl = route('admin.category.delete', [$type, $v['id'] ?? 0]);
    $data = $v;
    $data['model'] = 'category';
    $data['level'] = 'man';
    $data['name'] = $v['tenvi'] ?? '';
    if ($data['name']) {
        $data['name'] = $level . $data['name'];
    }
    $data['edit_url'] = $editUrl ?? '';
    $data['delete_url'] = $deleteUrl ?? '';
    $data['photo_url'] =  $photoUrl;
@endphp
<tr>
    <x-backend.index_select :data=$data />
    <x-backend.index_ordering :data=$data />

    @if (isset($config[$type]['show_images_category']) && $config[$type]['show_images_category'])
    <x-backend.index_photo :data=$data />
    @endif

    <x-backend.index_name :data=$data />
    @if (isset($config[$type]['check_category']) && $config[$type]['check_category'])
        @foreach ($config[$type]['check_category'] as $key => $value)
            @php
                $loai = $key;
            @endphp                                            
            <x-backend.index_checkbox :data=$data :loai=$loai />
        @endforeach
    @endif
    
    @php
        $loai = 'hienthi';
    @endphp                                            
    <x-backend.index_checkbox :data=$data :loai=$loai />

    <td class="text-center align-middle dev-item-option">
        <div class="dropdown show">
            <a class="btn-dropdown" href="#" role="button"
                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="true">
                <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <x-backend.index_operation :data=$data />

                @php
                    $loai = 'delete';
                @endphp  
                <x-backend.index_operation :data=$data :loai=$loai />
            </div>
        </div>
    </td>
</tr>