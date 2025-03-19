var paket_pekerjaan_id = [];

function setUrl()
{
    var baseUrl = window.location.protocol + '//' + window.location.host;
    var url = $('form').attr('action');
    var changed_url = baseUrl+url;
    window.history.pushState({}, '', changed_url);
}

$(document).on('click', '.btn_open_modal_paket', function(e){
	$.ajax({
        url: '?r=berita-acara-verifikasi-paket/data-paket',
        type: 'POST',
        data: {paket_pekerjaan_id: paket_pekerjaan_id},
        success: function (data) {
            $('#content-paket').html(data);
        }
    });
});

$('#modal_paket').on('hidden.bs.modal', function () {
    setUrl();
    $('#gridview_paket-pjax').attr('id', 'content-paket');
    $('#content-paket').empty();
});

$(document).on('click', '.btn_pilih_paket', function(e) {
    setUrl();
        
    // See if we have a selector set
    var selection = 'selection';
    if ($(this).data("selector") != null) {
    	selection = $(this).data("selector");
    }
    
    $('input:checkbox[name="' + selection + '[]"]').each(function () {
        if (this.checked)
        {
        	var id = $(this).val();

        	if ($.inArray(id, paket_pekerjaan_id) == -1)
			{
	            $.ajax({
		            dataType: 'json',
		            url: '?r=berita-acara-verifikasi-paket/paket',
		            type: 'POST',
		            data: {'id' : id},
		        })
		        .done(function(response) {
		            if (response != false)
		            {
		                var rowCount = $('.table_paket > tbody > tr').length;

		                $('.container-paket').append(
		                    '<tr>'+
		                        '<td>'+
		                            '<div class="row">'+
		                                '<div class="col-2">Paket Pekerjaan</div>'+
		                                '<div class="col-1">:</div>'+
		                                '<div class="col">'+response.nama+'</div>'+
		                            '</div>'+
		                            '<div class="row">'+
		                                '<div class="col-2">Deskripsi</div>'+
		                                '<div class="col-1">:</div>'+
		                                '<div class="col">'+response.deskripsi+'</div>'+
		                            '</div>'+
		                            '<div class="row">'+
		                                '<div class="col-2">Asal Usulan</div>'+
		                                '<div class="col-1">:</div>'+
		                                '<div class="col">'+response.asal_usulan+'</div>'+
		                            '</div>'+
		                            '<div class="row">'+
		                                '<div class="col-2">Penerima</div>'+
		                                '<div class="col-1">:</div>'+
		                                '<div class="col">'+response.penerima+'</div>'+
		                            '</div>'+
		                            '<div class="row">'+
		                                '<div class="col-2">Alamat</div>'+
		                                '<div class="col-1">:</div>'+
		                                '<div class="col">'+response.alamat+'</div>'+
		                            '</div>'+
		                            '<div class="row">'+
		                                '<div class="col-2">Volume Paket Tersedia</div>'+
		                                '<div class="col-1">:</div>'+
		                                '<div class="col">'+response.volume+'</div>'+
		                            '</div>'+
		                            '<div class="row">'+
		                                '<div class="col-2">Perkiraan Anggaran</div>'+
		                                '<div class="col-1">:</div>'+
		                                '<div class="col">'+response.anggaran+'</div>'+
		                            '</div>'+
		                        '</td>'+
		                        '<td class="text-center vcenter" style="width: 90px; white-space: nowrap;">'+
		                            '<button type="button" class="btn btn-danger btn-sm btn_remove_paket"><span class="fa fa-times"></span></button>'+
		                            '<input type="hidden" class="form_paket_id_id" id="paket_id_id-'+rowCount+'" name="BeritaAcaraVerifikasiPaketDetail['+rowCount+'][id]">'+
		                            '<input type="hidden" class="form_paket_id" id="paket_id-'+rowCount+'" name="BeritaAcaraVerifikasiPaketDetail['+rowCount+'][paket_pekerjaan_id]" value="'+response.id+'">'+
		                        '</td>'+
		                    '</tr>');

					    if(rowCount >= 0)
					    {
					        $('.collapse_paket').collapse('show');
					    }
		            }
		        });

				paket_pekerjaan_id.push(id);
			}
        }
    });

    $('#gridview_paket-pjax').attr('id', 'content-paket');
    $('#content-paket').empty();
});

$(document).on('click', '.btn_remove_paket', function(e){
    var tr = $(this).closest('tr');
    var paket_id = tr.find('input[type="hidden"]').val();

	for (var i = paket_pekerjaan_id.length - 1; i >= 0; i--) {
		if (paket_pekerjaan_id[i] === paket_id) {
			paket_pekerjaan_id.splice(i, 1);
		}
	}
	tr.remove();

    var field_paket_id = $('.form_paket_id_id');
    var count_paket_id = 0;
    $.each(field_paket_id, function() {
        $(this).attr('name', 'BeritaAcaraVerifikasiPaketDetail['+count_paket_id+'][id]');
        $(this).attr('id', 'paket_id_id-'+count_paket_id);
        count_paket_id++;
    });

    var field_paket_pekerjaan_id = $('.form_paket_id');
    var count_paket_pekerjaan_id = 0;
    $.each(field_paket_pekerjaan_id, function() {
        $(this).attr('name', 'BeritaAcaraVerifikasiPaketDetail['+count_paket_pekerjaan_id+'][paket_pekerjaan_id]');
        $(this).attr('id', 'paket_id-'+count_paket_pekerjaan_id);
        count_paket_pekerjaan_id++;
    });

    var rowCount = $('.table_paket tr').length;
    if(rowCount <= 0)
    {
        $('.collapse_paket').collapse('hide');
    }
});

$(document).on('click', '#btn_add_verifikator', function(e){
	var rowCount = $('.table_verifikator > tbody > tr').length;

	var id_verifikator = '<input type="hidden" id="id_verifikator-'+rowCount+'" class="form_verifikator_id" name="BeritaAcaraVerifikasiPaketVerifikator['+rowCount+'][id]">';

    var form_verifikator = "<div class='form-group'>"+
        "<input type='text' id='verifikator-"+rowCount+"' class='form-control form_verifikator' name='BeritaAcaraVerifikasiPaketVerifikator["+rowCount+"][verifikator]' placeholder='Nama Verifikator' required=true>"+
        "</div>";

    $('.container-verifikator').append(
        '<tr>'+
            '<td>'+form_verifikator+'</td>'+
            '<td class="text-center vcenter" style="width: 90px; white-space: nowrap;">'+
                '<button type="button" class="btn btn-danger btn-sm" id="btn_remove_verifikator"><span class="fa fa-times"></span></button>'+id_verifikator+
            '</td>'+
        '</tr>');
});

$(document).on('click', '#btn_remove_verifikator', function(e){
    $(this).closest('tr').remove();

    var field_verifikator_id = $('.form_verifikator_id');
    var count_verifikator_id = 0;
    $.each(field_verifikator_id, function() {
        $(this).attr('name', 'BeritaAcaraVerifikasiPaketVerifikator['+count_verifikator_id+'][id]');
        $(this).attr('id', 'id_verifikator-'+count_verifikator_id);
        count_verifikator_id++;
    });

    var field_verifikator = $('.form_verifikator');
    var count_verifikator = 0;
    $.each(field_verifikator, function() {
        $(this).attr('name', 'BeritaAcaraVerifikasiPaketVerifikator['+count_verifikator+'][verifikator]');
        $(this).attr('id', 'verifikator-'+count_verifikator);
        count_verifikator++;
    });
});