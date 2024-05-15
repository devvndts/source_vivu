$(document).ready(function() {
  $('#submit_nhantin').click(function(){
    if(isEmpty($('#email_nhantin').val(), lang_nhapemailcuaban))
    {
      $('#email_nhantin').focus();
      return false;
    }
    if(isEmail($('#email_nhantin').val(), lang_emailkhonghople))
    {
      $('#email_nhantin').focus();
      return false;
    }
    document.frm_dknt.submit(); 
  });
});