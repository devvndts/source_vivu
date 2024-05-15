<div class="card card-primary card-outline text-sm">
    <div class="card-header">
        <h3 class="card-title">Danh mục cha</h3>
    </div>

    <div class="card-body">
        <div class="miko-category-select">
            <i class="far fa-angle-down miko-angle-down"></i>
            <input type="text" value="{{($category['id']) ? $category['tenvi_parent'] : ''}}" class="miko-category-list" placeholder="Chọn danh mục" readonly="">
            <input type="hidden" name="id_parent" class="miko-category-id" value="{{($category['id']) ? $category['id_parent'] : ''}}">
            <ul class="miko-category-ul" data-url="{{url()->current()}}">
                <li value="0" class="miko-li-select" style="padding-left:20px;">Chọn danh mục</li>
                {{Helper::showCategory($danhmucparent, $category['id_parent'])}}
            </ul>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('body').click(function(e) {
            var target = $(e.target);
            if(!target.is('.miko-category-list')) {
                if($('.miko-category-ul').css('display') == 'block'){ 
                   $('.miko-category-ul').css('display','none');
                }
            }
        });

        $('.miko-category-list').click(function(){
            $('.miko-category-ul').toggle();
        });

        $('.miko-li-select').click(function(){
            var name = $(this).text();
            var value = $(this).attr('value');

            $('.miko-category-list').val(name);
            $('.miko-category-id').val(value);

            $('.miko-li-select').removeClass('miko-li-active');
            $(this).addClass('miko-li-active');

            $('.miko-category-ul').toggle();

            $.ajax({
                url: "{{ route('admin.ajax.multyCategory') }}",
                type: 'GET',
                dataType: 'html',
                data: {id_category:value},
                success: function(result){
                    if(result!=''){
                        $('.miko-multy-category-ul').html(result);
                    }
                }
            });
        });


        $('.form-filter-category .miko-li-select').click(function(){
            var name = '';
            var keyword = $("#keyword").val();
            var id_category = $('input[name="id_parent"]').val();            

            var url = $(this).parents('.miko-category-ul').attr("data-url")+'?';

            if(id_category>0){
                url += "id_category="+encodeURI(id_category);
            }
            if(keyword){
                url += "&keyword="+encodeURI(keyword);
            }

            return window.location = url;
        });
    </script>
@endpush