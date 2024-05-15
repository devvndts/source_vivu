<!-- Video Fotorama -->
<div id="fotorama-videos" data-width="100%" data-thumbmargin="5" data-height="360" data-fit="cover" data-thumbwidth="100" data-thumbheight="85" data-allowfullscreen="false" data-nav="thumbs">
    @foreach($videos as $k=>$v)
        <a href="https://youtube.com/watch?v={{Helper::getYoutube($v['link_video'])}}" title="{{$v['ten'.$lang]}}"></a>
    @endforeach
</div>

<script type="text/javascript">
	$(document).ready(function()
	{
		$("#fotorama-videos").fotorama();
	});
</script>