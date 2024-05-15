function AddonLoad(eleId,type)
{
	$.ajax({
		url:'addon/'+type,
		type: "POST",
		dataType: 'html',
		async: false,
		data: {_token:$('input[name="_token"]').val()},
		success: function(result){
			if(result) {
				$('#'+eleId).html(result);
			}
		}
	});
}

$(document).ready(function(){
	//AddonLoad('fotorama-videos','video-fotorama');
	//AddonLoad('video-select','video-select');
	//AddonLoad('fanpage-facebook','fanpage-facebook');
	// AddonLoad('messages-facebook','messages-facebook');
});