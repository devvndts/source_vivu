function doEnter(evt){
    var key;
    if(evt.keyCode == 13 || evt.which == 13){
     onSearch(evt);
   }
 }
 function onSearch(evt) {
   var keyword1 = $('.keyword:eq(0)').val();
   var keyword2 = $('.keyword:eq(1)').val();
   if(keyword1==lang_nhaptukhoatimkiem)
   {
    keyword = keyword2;
  }
  else
  {
    keyword = keyword1;
  }
  if(keyword=='' || keyword==lang_nhaptukhoatimkiem)
  {
    alert(lang_chuanhaptukhoa);
  }
  else{
    location.href = "tim-kiem/keyword="+keyword;
  }
}
 function onSearch2(evt) {
   var keyword = $('#keyword').val();
   var id_huong = $('#id_huong').val();
   var id_danhmuc = $('input[name="id_danhmuc"]').val();
   var id_list = $('#id_list').val();
   var id_khoanggia = $('#id_khoanggia').val();
   var thanhpho = $('#thanhpho').val();
   var quan = $('#quan').val();
   location.href = "tim-kiem/id_huong="+id_huong+"&id_danhmuc="+id_danhmuc+"&id_list="+id_list+"&id_khoanggia="+id_khoanggia+"&id_city="+thanhpho+"&id_dist="+quan+"&keyword="+keyword;
}
$(document).ready(function() {
  $('.timkiem_icon').click(function(event) {
    if($('#search').hasClass('hien')){
      $('#search').removeClass('hien');
    }else{
      $('#search').addClass('hien');
    }
  });
  $('.valak_mmenu__search-icon').click(function(event) {
    if($('.valak-search').hasClass('hien')){
      $('.valak-search').removeClass('hien');
    }else{
      $('.valak-search').addClass('hien');
    }
  });
});