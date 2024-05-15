<div class="text-sm card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Hỏi đáp</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                    class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body ">
        <div class="fieldGroup">
            <a class="text-white addMore btn btn-sm bg-gradient-success d-inline-block"
                title="Thêm hỏi đáp">Thêm hỏi đáp</a>
        </div>
        @foreach ($qaData as $item)
            @php
                $qaStt = $item->stt;
                $qaId = $item->id;
                $qaTenvi = $item->tenvi;
                $qaMota = $item->motavi;
            @endphp
            <div class="fieldGroup">
                <div class="p-2 my-2 bg-gradient-cyan">
                    <div class="mt-2 d-flex justify-content-between">
                        <div class="mb-0 mr-2 form-group flex-grow-1">
                            <label>Hỏi đáp: </label>
                            <div class="">
                                <input type="hidden" name="idgoi[]" value="{{ $qaId }}" />
                                <input type="text" name="tengoi[]" value="{{ $qaTenvi }}"
                                    title="Tên" class="tipS form-control" />
                            </div>
                        </div>
                        <a href="javascript:void(0)" data-id="{{ $qaId }}" style="height: 45px;"
                            class="mt-auto btn btn-danger remove align-items-center">Xóa</a>
                    </div>
                    <div class="mt-2 ">
                        <div class="form-group ">
                            <label>Trả lời: </label>
                            <div class="">
                                <textarea name="textgoi[]" class="form-control" cols="30" rows="4">{!! $qaMota !!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 ">
                        <div class="form-group d-flex justify-content-start align-items-center">
                            <label class="mr-2">STT: </label>
                            <input type="number" min="0" name="sttgoi[]"
                                value="{{ $qaStt }}" title="STT" class="w-25 form-control" />
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>