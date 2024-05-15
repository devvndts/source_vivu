@props([
    'photoNumbering' => '',
    'photoWidth' => 300,
    'photoHeight' => 200,
    'photoRatio' => 1,
    'photoImgType' => '.jpg|.gif|.png|.jpeg',
    'photoUrl' => '',
])
@php
    $photoWidth = $photoWidth ?? 300;
    $photoHeight = $photoHeight ?? 200;
    $photoRatio = $photoRatio ?? 1;
    $dimension = sprintf('Width: %spx - Height: %spx (%s)', $photoWidth * $photoRatio, $photoHeight * $photoRatio, $photoImgType);
@endphp
<div class="photoUpload-zone">
	<div class="photoUpload-detail" 
        id="photo{{ $photoNumbering }}Upload-preview">
        <img class="rounded" onerror=src="{{ asset('img/noimage1.png') }}" alt="Alt Photo" src="{{ $photoUrl }}" />
    </div>
	<label class="photoUpload-file" id="photo{{ $photoNumbering }}-zone" 
        for="file{{ $photoNumbering }}-zone">
		<input type="file" name="file{{ $photoNumbering }}" 
            id="file{{ $photoNumbering }}-zone">
		<i class="fas fa-cloud-upload-alt"></i>
		<p class="photoUpload-drop">{{ __('Kéo và thả hình vào đây') }}</p>
		<p class="photoUpload-or">{{ __('hoặc') }}</p>
		<p class="photoUpload-choose btn btn-sm bg-gradient-success">{{ __('Chọn hình') }}</p>
	</label>
    <div class="photoUpload-dimension">{{ $dimension }}</div>
</div>

<input type="hidden" name="width" value="{{ $photoWidth ?? 0 }}" />
<input type="hidden" name="height" value="{{ $photoHeight ?? 0 }}" />