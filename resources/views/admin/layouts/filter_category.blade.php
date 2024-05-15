<select class="form-control select-filter-category" data-url="{{url()->current()}}">
	<option value="" {{($level=='') ? 'selected' : ''}}>Chọn cấp danh mục</option>
    <option value="0" {{($level==0) ? 'selected' : ''}}>Cấp 1</option>
    <option value="1" {{($level==1) ? 'selected' : ''}}>Cấp 2</option>
    <option value="2" {{($level==2) ? 'selected' : ''}}>Cấp 3</option>
</select>

@push('js')
    <script>
        $('.select-filter-category').change(function(){
	        var name = '';
	        var keyword = $("#keyword").val();
	        var level = $(this).val();

	        var url = '{{url()->current()}}'+'?';

	        if(level!=''){
	            url += "level="+encodeURI(level);
	        }
	        if(keyword){
	            url += "&keyword="+encodeURI(keyword);
	        }

	        return window.location = url;
	    });
    </script>
@endpush