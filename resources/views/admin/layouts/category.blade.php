@php
    //### lấy thông tin prefix
    $prefix = Helper::GetPrefixAdmin($request);
@endphp

<input type="hidden" name="multiple_category" value="{{(isset(config('category')[$type]['menu_multiple'])) ? config('category')[$type]['menu_multiple'] : 0}}">

<div class="card card-primary card-outline text-sm mb-3 {{($prefix=='category') ? '' : 'd-none'}}">
    <div class="card-header">
        <h3 class="card-title">{{ __('Cấp danh mục') }}</h3>
    </div>
    <div class="card-body">
        <div class="form-group-category row">
            <div class="px-0 mb-0 form-group col-sm-12">
                <select class="form-control" name="data[level]" id="category-multy-level">
                    @if($prefix=='category')
                        @if ($rowItem)
                            <option value="0" {{($rowItem['level']==0) ? 'selected' : ''}}>{{ __('Cấp') }} 1</option>
                            <option value="1" {{($rowItem['level']==1) ? 'selected' : ''}}>{{ __('Cấp') }} 2</option>
                            <option value="2" {{($rowItem['level']==2) ? 'selected' : ''}}>{{ __('Cấp') }} 3</option>
                        @else
                            <option value="0" selected>{{ __('Cấp') }} 1</option>
                            <option value="1">{{ __('Cấp') }} 2</option>
                            <option value="2">{{ __('Cấp') }} 3</option>
                        @endif
                        
                    @else
                        <option value="3" selected>{{ __('Cấp') }} 4</option>
                    @endif
                </select>
            </div>
        </div>
    </div>
</div>

<div id="load-select-category"></div>

@push('js')
    <script>
        $(window).on('load', function () {
            $('#category-multy-level').trigger('change');
        });

        $('body').on('click', function(e){
            var target = $(e.target);

            if(!target.is('.miko-multy-category-list')) {
                $('.miko-multy-category-list').each(function(){
                    var level = $(this).attr('data-level');
                    if($('.miko-multy-category-ul-'+level).css('display') == 'block'){
                        $('.miko-multy-category-ul-'+level).css('display','none');
                    }
                });
            }

            if(target.is('.multy-checkbox')) {              
                var level = target.parents('.miko-multy-category-select').find('.miko-multy-category-list').attr('data-level');
                if($('.miko-multy-category-ul-'+level).css('display') == 'none'){ 
                    $('.miko-multy-category-ul-'+level).css('display','block');
                }                
            }
        });

        $('body').on('click' ,'.miko-multy-category-list', function(){
            var level = $(this).attr('data-level');
            $('.miko-multy-category-ul-'+level).toggle();
        });
    </script>

    <script>
        $('body').on('change', '#category-multy-level', function(){
            var level = $(this).val();
            var type_category = $('.type-main').val();
            var id = $('input[name="id"]').val();
            var table = $('input[name="table"]').val();
            var level_begin = 0;

            if(level<1){
                $('.load-select-category').remove();
            }else{
                level_begin = 1;
            }

            $.ajax({
                url: "{{ route('admin.ajax.loadSelectCategory') }}",
                type: 'GET',
                dataType: 'html',
                data: {id:id, level:level_begin, type:type_category, table:table},
                success: function(result){
                    if(result!=''){
                        $('.load-select-category').remove();
                        $('#load-select-category').append("<div id='load-select-category-"+level_begin+"' class='load-select-category load-select-category-"+level_begin+"'></div>");
                        if($('#load-select-category-'+level_begin).length){
                            $('#load-select-category-'+level_begin).html(result);
                        }

                        $('.multy-checkbox').each(function(){
                            if($(this).is(':checked')){
                                $(this).trigger('change');
                            }
                            //$(this).trigger('change');
                        });
                    }
                }
            });
        });

        $('body').on('change', '.multy-checkbox', function(){
            var selected = [];
            var list_ids = '';
            var max_level = $('#category-multy-level').val();
            var level = $(this).parents('.miko-multy-category-select').find('.miko-multy-category-list').attr('data-level');
            var level_child = parseInt(level)+1;
            var type_category = $('.type-main').val();
            var id = $('input[name="id"]').val();
            var table = $('input[name="table"]').val();

            if($('input[name="multiple_category"]').val()==0){
                $('.miko-multy-category-ul-'+level).find('.multy-checkbox').prop('checked',false);
                $(this).prop('checked', true); 
            }            

            $('.multy-checkbox:checked').each(function() {
                selected.push($(this).val());
            });
            list_ids = selected.toString();

            for(let i=level_child;i<=max_level;i++){
                $('.load-select-category-'+i).remove();
            }

            //### show list name
            var name_selected = [];
            var list_name = '';

            $('.miko-multy-category-ul-'+level).find('.multy-checkbox:checked').each(function() {
                name_selected.push($(this).attr('data-name'));
            });
            list_name = (name_selected.length>0) ? name_selected.toString().replace(",", ", ") : __('Chọn danh mục');
            $('.miko-multy-category-list-'+level).attr('placeholder',list_name);
            //console.log(level);

            if(list_ids!='' && level_child<=max_level){
                $.ajax({
                    url: "{{ route('admin.ajax.loadSelectCategory') }}",
                    type: 'GET',
                    dataType: 'html',
                    data: {id:id, level:level_child, type:type_category, list_ids:list_ids, table:table},
                    success: function(result){
                        if(result!=''){
                            $('.load-select-category-'+level_child).remove();
                            $('#load-select-category').append("<div id='load-select-category-"+level_child+"' class='load-select-category load-select-category-"+level_child+"'></div>");
                            if($('#load-select-category-'+level_child).length){
                                $('#load-select-category-'+level_child).html(result);
                            }

                            $('.miko-multy-category-ul-'+level_child).find('.multy-checkbox:checked').each(function(){
                                $(this).trigger('change');
                            });
                        }
                    }
                });
            }
        });
    </script>
@endpush