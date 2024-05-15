@if(isset($config[$type]['taptin']) && $config[$type]['taptin'])
<div class="text-sm card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">PDF</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body myfile-section">
        <ul id="sortable">
            @isset($taptin)
                @foreach ($taptin as $itemTaptin)
                @php
                    $itemTaptinName = $itemTaptin["tenvi"] ?? '';
                    $itemTaptinDesc = $itemTaptin["motavi"] ?? '';
                    $itemTaptinID = $itemTaptin["id"] ?? 0;
                @endphp
                <li class="ui-state-default">
                    <div>
                        <input type="file" name="myfile[file][]">
                        <input type="hidden" value="{{ $itemTaptinID }}" name="myfile[id][]" value="0">
                    </div>
                    <div style="display: flex; justify-content: space-between" class="mt-2">
                        <input type="text" class="form-control" value="{{ $itemTaptinName }}" name="myfile[name][]">
                        <div class="ml-2 btn btn-dark" title="Change order">
                            <span class="ui-icon ui-icon-arrow-4"></span>
                        </div>
                        <button type="button" data-id="{{ $itemTaptinID }}" class="ml-2 btn btn-danger btn-delete-myfile"><i class="fas fa-trash-alt "></i></button>
                    </div>
                    <div class="mt-2">
                        <textarea name="myfile[desc][]" class="form-control-ckeditor-custom" id="ckId_{{ $itemTaptinID }}">{!! $itemTaptinDesc !!}</textarea>
                    </div>
                </li>
                @endforeach
            @endisset
        </ul>
        <button class="btn btn-info btn-add-myfile" type="button">Add</button>
    </div>
</div>
<style>
    #sortable { list-style-type: none; margin: 0; padding: 0;  }
    #sortable .ui-state-default{ background: #fff; color: #000; }
    #sortable li { margin: 0 0 10px 0; padding: 0.4em; padding-left: .5em; font-size: 1.4em; }
    #sortable .ui-icon {
        transform: scale(1.8);
        margin-top: 5px;
    }
</style>
@push('js')
<input type="hidden" name="ajax-delete-gallery-url" value="{{ route('admin.ajax.ajaxDeleteGallery') }}">
<input type="hidden" name="folder_upload" value="{{ $folder_upload }}">
<script id="templateHtml" type="text/x-handlebars-template">
    <li class="ui-state-default">
        <div>
            <input type="file" name="myfile[file][]" >
            <input type="hidden" name="myfile[id][]" value="0">
        </div>
        <div style="display: flex; justify-content: space-between" class="mt-2">
            <input type="text" class="form-control" name="myfile[name][]">
            <div class="ml-2 btn btn-dark " title="Change order"><span class="ui-icon ui-icon-arrow-4"></span></div>
            <button type="button" class="ml-2 btn btn-danger btn-delete-myfile"><i class="fas fa-trash-alt "></i></button>
        </div>
        <div class="mt-2">
            <textarea name="myfile[desc][]" class="form-control-ckeditor-custom" id="ckId_{ckId}"></textarea>
        </div>
    </li>
</script>
<script>
    $(document).ready(function () {
        let $myfileBtnAdd = $('.myfile-section .btn-add-myfile');
        let $myfileTemplate = $('.template-add-myfile').html();
        let $myfileAppendSection = $('#sortable');
        let $htmlTemplate = $('#templateHtml');

        $( "#sortable" ).sortable();
        
        $($myfileBtnAdd).click(function (e) { 
            e.preventDefault();
            let $htmlMore = $htmlTemplate.html();
            let $ckId = 'ck' + $('#sortable li').length + 1;
            $htmlMore = $htmlMore.replace(/{ckId}/g, $ckId);
            $myfileAppendSection.append($htmlMore);
            CKEDITOR.replace(`ckId_${$ckId}`, {
                customConfig: url_ckeditor+'public/ckeditor/custom/ckeditor_config.js'
            });
        });

        $( "body .myfile-section" ).on( "click", ".btn-delete-myfile", function() {
            var url = $('input[name="ajax-delete-gallery-url"]').val();
            var folder_upload = $('input[name="folder_upload"]').val();
            var id = $(this).data('id');
            var itemParent = $(this).parents('.ui-state-default');
            var _token = $('input[name="_token"]').val();
            if (id != undefined) {
                $.ajax({
                    type: "post",
                    url,
                    data: {id, folder_upload, _token},
                    dataType: "json",
                    success: function (response) {
                        if (response) {
                            itemParent.remove();
                        }
                    }
                });
            } else {
                itemParent.remove();
            }
        });
    });
</script>
@endpush

@endif