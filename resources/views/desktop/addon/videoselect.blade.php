<!-- Video Select -->
<div class="video-main">
    <iframe width="100%" height="100%" src="//www.youtube.com/embed/{{Helper::getYoutube($videos[0]['link_video'])}}" frameborder="0" allowfullscreen></iframe>
</div>
<select class="listvideos">
    @foreach($videos as $k=>$v)
        <option value="{{$v['id']}}">{{$v['ten'.$lang]}}</option>
    @endforeach
</select>

<script type="text/javascript">
    /*$(document).ready(function()
    {
        $('.listvideos').change(function() 
        {
            var id = $(this).val();
            $.ajax({
	            url:'ajax/ajax_video.php',
	            type: "POST",
	            dataType: 'html',
	            data: {id:id},
	            success: function(result){
	                $('.video-main').html(result);
	            }
	        });
        });
    });*/
</script>