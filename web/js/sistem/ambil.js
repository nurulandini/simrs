var paket_pekerjaan_id = [];
var select2Options = { /*dropdownParent: $(this).parent(),*/ width: 'resolve' };
const number_control_config = {
    displayId: "",
    maskedInputOptions:{
        prefix: "Rp. ",
        alias: "numeric",
        allowMinus: false,
        autoGroup: true,
        autoUnmask: false,
        digits: 1000,
        groupSeparator: ".",
        radixPoint: ",",
    }
};
const date_picker_config = {
	options: {
		placeholder: 'Pilih Tanggal',
    	readonly: true
	},
    pluginOptions: {
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
    },
};

function setUrl()
{
    var baseUrl = window.location.protocol + '//' + window.location.host;
    var url = $('form').attr('action');
    var changed_url = baseUrl+url;
    window.history.pushState({}, '', changed_url);
}



$(document).on('click', '.btn_open_modal_paket', function(e){
	$.ajax({
        url: '?r=berita-acara-ambil-paket/data-paket',
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


var anggaran = 0;
var paket_volume = 0;



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
		            url: '?r=berita-acara-ambil-paket/paket',
		            type: 'POST',
		            data: {'id' : id},
		        })
		        .done(function(response) {
		            if (response != false)
		            {
                        var rowCount = $('.table_paket > tbody > tr').length;

		                var form_perusahaan = "<div class='form-group'>"+
				            "<label>Perusahaan Pelaksana</label>"+
				            "<select name='BeritaAcaraAmbilPaketDetail["+rowCount+"][perusahaan_id]' id='detail_perusahaan_id-"+rowCount+"' class='form_perusahaan_id' style='width: 100%' required=true>";
				            form_perusahaan += "<option value=''>Pilih Perusahaan</option>";
				            $.each(data_perusahaan, function(val, text) {
				                form_perusahaan += "<option value='"+val+"'>"+text+"</option>";
				            });
				            form_perusahaan += "</select></div>";

				        var form_volume = "<div class='form-group'>"+
                            "<label>Volume Paket Diambil</label>" +
                            "<input type='text' data-baris="+rowCount+" id='detail_volume-"+rowCount+"-disp' class='detail_volume_input-"+rowCount+" form-control kv-monospace' name='detail_volume-"+rowCount+"-disp' required=true>"+
                            "<div style='display:none'>"+
                            "<input type='text' id='detail_volume-"+rowCount+"' class='form-control' name='BeritaAcaraAmbilPaketDetail["+rowCount+"][volume]' data-krajee-numbercontrol='numberControl_detail_volume-"+rowCount+"' tabindex='10000'>"+
                            "</div>"+
                            "<div class ='volume_tidak_sesuai-"+rowCount+"'>" +
                            "</div>" +
				            "</div>";

				        var form_satuan = "<div class='form-group'>"+
				        	"<label>Satuan</label>"+
					        "<input type='text' id='detail_satuan-"+rowCount+"' class='form-control form_satuan' value='"+response.satuan+"' disabled>"+
					        "</div>";

				        var form_anggaran = "<div class='form-group'>"+
				                "<label>Perkiraan Anggaran (Rp)</label>"+
				                "<input type='text' id='detail_anggaran-"+rowCount+"-disp' class='detail_anggaran_input-"+rowCount+" form-control kv-monospace' name='detail_anggaran-"+rowCount+"-disp' required=true disabled>"+
				                "<div style='display:none'>"+
				                    "<input type='text' id='detail_anggaran-"+rowCount+"' class='detail_anggaran_diambil-"+rowCount+" form-control' name='BeritaAcaraAmbilPaketDetail["+rowCount+"][anggaran]' data-krajee-numbercontrol='numberControl_detail_anggaran-"+rowCount+"' tabindex='10000'>"+
				                "</div>"+
				            "</div>";

				        var form_volume_satuan_anggaran = "<div class='row'>"+
				        		"<div class='col'>"+form_volume+"</div>"+
				        		"<div class='col'>"+form_satuan+"</div>"+
				        		"<div class='col'>"+form_anggaran+"</div>"+
				        	"</div>";

				        var form_tgl_mulai = "<div class='form-group'>"+
				        		"<label>Tanggal Mulai</label>"+
				        		"<input type='text' class='form-control form_tgl_mulai' id='detail_tgl_mulai-"+rowCount+"' name='BeritaAcaraAmbilPaketDetail["+rowCount+"][tgl_mulai]'>"+
				        	"</div>";

				        var form_tgl_selesai = "<div class='form-group'>"+
				        		"<label>Tanggal Selesai</label>"+
				        		"<input type='text' class='form-control form_tgl_selesai' id='detail_tgl_selesai-"+rowCount+"' name='BeritaAcaraAmbilPaketDetail["+rowCount+"][tgl_selesai]'>"+
				        	"</div>";

				        var form_tgl_mulai_selesai = "<div class='row'>"+
				        		"<div class='col'>"+form_tgl_mulai+"</div>"+
				        		"<div class='col'>"+form_tgl_selesai+"</div>"+
				        	"</div>";

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
		                                '<div class="col-2">Volume Paket Tesedia</div>'+
		                                '<div class="col-1">:</div>'+
		                                '<div class="volume_tersedia col">'+response.volume+'</div>'+
                                    '</div>' +
                                    '<div class="row">'+
		                                '<div class="col-2">Volume Sisa Paket Tesedia</div>'+
		                                '<div class="col-1">:</div>'+
		                                '<div class="col">'+response.sisa+'</div>'+
		                            '</div>'+
		                            '<div class="row">'+
		                                '<div class="col-2">Perkiraan Anggaran</div>'+
		                                '<div class="col-1">:</div>'+
		                                '<div class="col">'+response.anggaran+'</div>'+
		                            '</div>'+
		                            '<br>'+form_perusahaan+form_volume_satuan_anggaran+form_tgl_mulai_selesai+
		                        '</td>'+
		                        '<td class="text-center vcenter" style="width: 90px; white-space: nowrap;">'+
		                            '<button type="button" class="btn btn-danger btn-sm btn_remove_paket"><span class="fa fa-times"></span></button>'+
		                            '<input type="hidden" class="form_paket_id_id" id="paket_id_id-'+rowCount+'" name="BeritaAcaraAmbilPaketDetail['+rowCount+'][id]">'+
		                            '<input type="hidden" class="form_paket_id" id="paket_id-'+rowCount+'" name="BeritaAcaraAmbilPaketDetail['+rowCount+'][paket_pekerjaan_id]" value="'+response.id+'">'+
		                        '</td>'+
		                    '</tr>');
                        paket_volume = response.volume;
                        anggaran = response.anggaran;
					    if(rowCount >= 0)
					    {
					        $('.collapse_paket').collapse('show');
					    }

					    $('#detail_perusahaan_id-'+rowCount).select2(select2Options);

					    number_control_config.displayId = 'detail_anggaran-'+rowCount+'-disp';
					    number_control_config.maskedInputOptions.prefix = '';
					    number_control_config.maskedInputOptions.rightAlign = true;
					    $('#detail_anggaran-'+rowCount).numberControl(number_control_config);

					    number_control_config.displayId = 'detail_volume-'+rowCount+'-disp';
					    number_control_config.maskedInputOptions.prefix = '';
					    number_control_config.maskedInputOptions.rightAlign = false;
					    $('#detail_volume-'+rowCount).numberControl(number_control_config);

					    date_picker_config.options.id = '#detail_tgl_mulai-'+rowCount;
					    $('#detail_tgl_mulai-'+rowCount).kvDatepicker(date_picker_config);

					    date_picker_config.options.id = '#detail_tgl_selesai-'+rowCount;
					    $('#detail_tgl_selesai-'+rowCount).kvDatepicker(date_picker_config);
                    }
                    // $('').unbind();

                    // $('#detail_volume-0-disp').keyup(function () {
                    //     alert(parseFloat($('#detail_volume-0-disp').val()) + " | " +  + " | " + response.volume)
                    //     $('#detail_anggaran-0-disp').val(parseFloat($('#detail_volume-0-disp').val()) * (response.anggaran_raw/response.volume_raw));
                    
                    // })

                    

                    $(document).ready(function () {
                        
                        $(document).on('change', '#detail_volume-' + rowCount + '-disp', function (data) {
                            // console.log(data)
                            var volume_diambil = parseFloat($('#detail_volume-' + rowCount + '-disp').val());
                            var sisa = response.sisa_raw;
                            if (parseFloat(volume_diambil) <= sisa && parseFloat(volume_diambil) != 0) {
                                //console.log(parseFloat($(data.currentTarget).val()) + " | " + response.anggaran_raw + " | " + response.volume + " | " + sisa + " | " + volume_diambil)
                                $('.detail_anggaran_input-' + [rowCount]).val(volume_diambil * (response.anggaran_raw / response.volume_raw));
                                $('.detail_anggaran_diambil-' + [rowCount]).val(volume_diambil * (response.anggaran_raw / response.volume_raw));
                                $('.volume_tidak_sesuai-' + rowCount).empty();
                                $('#ambil_input').attr('disabled', false);
                            } else {
                                //console.log('Volume paket diambil tidak sesuai dengan volume paket tersedia');
                                $('.detail_anggaran_input-' + [rowCount]).val(0);
                                $('.volume_tidak_sesuai-' + rowCount).append('<span class="badge badge-pill badge-danger">Volume paket diambil tidak sesuai dengan volume paket tersedia : ' + response.sisa_raw + " " + response.satuan + '</span>');  
                                $('#ambil_input').attr('disabled', true);
                            }
                                
                            // console.log($(e).val(), $(e).data('baris'))
                        });

                        
                            
                    }); 
                    
                    
                    
                    
                    
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
    var paket_id = tr.find('input[type="hidden"][class=form_paket_id]').val();

	for (var i = paket_pekerjaan_id.length - 1; i >= 0; i--) {
		if (paket_pekerjaan_id[i] === paket_id) {
			paket_pekerjaan_id.splice(i, 1);
		}
	}
	tr.remove();

    var field_paket_id = $('.form_paket_id_id');
    var count_paket_id = 0;
    $.each(field_paket_id, function() {
        $(this).attr('name', 'BeritaAcaraAmbilPaketDetail['+count_paket_id+'][id]');
        $(this).attr('id', 'paket_id_id-'+count_paket_id);
        count_paket_id++;
    });

    var field_paket_pekerjaan_id = $('.form_paket_id');
    var count_paket_pekerjaan_id = 0;
    $.each(field_paket_pekerjaan_id, function() {
        $(this).attr('name', 'BeritaAcaraAmbilPaketDetail['+count_paket_pekerjaan_id+'][paket_pekerjaan_id]');
        $(this).attr('id', 'paket_id-'+count_paket_pekerjaan_id);
        count_paket_pekerjaan_id++;
    });

    var field_perusahaan = $('.form_perusahaan_id');
    var count_perusahaan = 0;
    $.each(field_perusahaan, function() {
        $(this).attr('id', 'detail_perusahaan_id-'+count_perusahaan);
        $(this).attr('name', 'BeritaAcaraAmbilPaketDetail['+count_perusahaan+'][perusahaan_id]');
        $(this).select2('destroy');
        $(this).removeAttr('data-s2-options');
        $(this).removeAttr('data-krajee-select2');
        $(this).attr('style', 'width: 100%');
        $(this).attr('class', 'form_perusahaan_id');
        $(this).select2(select2Options);
        count_perusahaan++;
    });

    var hasVolume = $('.container-paket').find('input[data-krajee-numbercontrol*="numberControl"][id^="detail_volume-"]');
    var count_volume = 0;
    hasVolume.each(function() {
        var table = $(this).closest('td');
        var form_display = table.find('input[id*="detail_volume-"][name*="-disp"]');
        var form_value = table.find('input[data-krajee-numbercontrol*="numberControl"][id^="detail_volume-"]');

        form_display.attr('id', 'detail_volume-'+count_volume+'-disp');
        form_display.attr('name', 'detail_volume-'+count_volume+'-disp');
        form_display.attr('required', true);

        form_value.attr('id', 'detail_volume-'+count_volume);
        form_value.attr('name', 'BeritaAcaraAmbilPaketDetail['+count_volume+'][volume]');
        form_value.attr('data-krajee-numbercontrol', 'numberControl_detail_volume-'+count_volume);

        number_control_config.displayId = 'detail_volume-'+count_volume+'-disp';
        number_control_config.maskedInputOptions.prefix = '';
        number_control_config.maskedInputOptions.rightAlign = false;
        
        $(this).numberControl(number_control_config);
        count_volume++;
    });

    var hasAnggaran = $('.container-paket').find('input[data-krajee-numbercontrol*="numberControl"][id^="detail_anggaran-"]');
    var count_anggaran = 0;
    hasAnggaran.each(function() {
        var table = $(this).closest('td');
        var form_display = table.find('input[id*="detail_anggaran-"][name*="-disp"]');
        var form_value = table.find('input[data-krajee-numbercontrol*="numberControl"][id^="detail_anggaran-"]');

        form_display.attr('id', 'detail_anggaran-'+count_anggaran+'-disp');
        form_display.attr('name', 'detail_anggaran-'+count_anggaran+'-disp');

        form_value.attr('id', 'detail_anggaran-'+count_anggaran);
        form_value.attr('name', 'BeritaAcaraAmbilPaketDetail['+count_anggaran+'][anggaran]');
        form_value.attr('data-krajee-numbercontrol', 'numberControl_anggaran_sub_aktivitas-'+count_anggaran);

        number_control_config.displayId = 'detail_anggaran-'+count_anggaran+'-disp';
        number_control_config.maskedInputOptions.prefix = '';
        number_control_config.maskedInputOptions.rightAlign = true;
        
        $(this).numberControl(number_control_config);
        count_anggaran++;
    });

    var field_tgl_mulai = $('.form_tgl_mulai');
    var count_tgl_mulai = 0;
    $.each(field_tgl_mulai, function() {
        $(this).attr('name', 'BeritaAcaraAmbilPaketDetail['+count_tgl_mulai+'][tgl_mulai]');
        $(this).attr('id', 'detail_tgl_mulai-'+count_tgl_mulai);
        count_tgl_mulai++;

        date_picker_config.options.id = '#detail_tgl_mulai-'+count_tgl_mulai;
	    $('#detail_tgl_mulai-'+count_tgl_mulai).kvDatepicker(date_picker_config);
    });

    var field_tgl_selesai = $('.form_tgl_selesai');
    var count_tgl_selesai = 0;
    $.each(field_tgl_selesai, function() {
        $(this).attr('name', 'BeritaAcaraAmbilPaketDetail['+count_tgl_selesai+'][tgl_selesai]');
        $(this).attr('id', 'detail_tgl_selesai-'+count_tgl_selesai);
        count_tgl_selesai++;

        date_picker_config.options.id = '#detail_tgl_selesai-'+count_tgl_selesai;
	    $('#detail_tgl_selesai-'+count_tgl_selesai).kvDatepicker(date_picker_config);
    });

    var rowCount = $('.table_paket tr').length;
    if(rowCount <= 0)
    {
        $('.collapse_paket').collapse('hide');
    }
});

$(document).on('click', '#btn_add_verifikator', function(e){
	var rowCount = $('.table_verifikator > tbody > tr').length;

	var id_verifikator = '<input type="hidden" id="id_verifikator-'+rowCount+'" class="form_verifikator_id" name="BeritaAcaraAmbilPaketVerifikator['+rowCount+'][id]">';

    var form_verifikator = "<div class='form-group'>"+
        "<input type='text' id='verifikator-"+rowCount+"' class='form-control form_verifikator' name='BeritaAcaraAmbilPaketVerifikator["+rowCount+"][verifikator]' placeholder='Nama Verifikator' required=true>"+
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
        $(this).attr('name', 'BeritaAcaraAmbilPaketVerifikator['+count_verifikator_id+'][id]');
        $(this).attr('id', 'id_verifikator-'+count_verifikator_id);
        count_verifikator_id++;
    });

    var field_verifikator = $('.form_verifikator');
    var count_verifikator = 0;
    $.each(field_verifikator, function() {
        $(this).attr('name', 'BeritaAcaraAmbilPaketVerifikator['+count_verifikator+'][verifikator]');
        $(this).attr('id', 'verifikator-'+count_verifikator);
        count_verifikator++;
    });


    
});