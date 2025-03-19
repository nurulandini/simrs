$(document).on('click', '#asal_usulan', function (e) {
    var value = $(this).prop('checked');
    if(value == true)
    {
      // console.log(role);
      $('#_asal_usulan_').addClass('d-none');
        
      if (role === 'Opd') {        
          $('#asal_usulan_').val('5');
      }
      else if (role === 'Lsm') {
        $('#asal_usulan_').val('2');
          
      }
      else if (role === 'Umkm') {
        $('#asal_usulan_').val('1');
          
      }
      else if (role === 'Perusahaan') {
        $('#asal_usulan_').val('7');
          
      }
      else {
        $('#asal_usulan_').val('6');
      }
        
    }
    else
    {
        $('#_asal_usulan_').removeClass('d-none');
        $('#asal_usulan_').val('');    
    }
});