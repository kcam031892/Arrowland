function messageAlert(message,mClass) {
  $('#success-alert').attr('class','alert alert-'+mClass);
  $('#success-message').html(message);
  $('#success-alert').fadeTo(500,1000).slideUp('slow', function(){
    $('#success-alert').slideUp('slow');

  });
}
