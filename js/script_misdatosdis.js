$(document).ready(function(){

	$('#perfil').on('submit',function(e)
	{
		e.preventDefault();
		$('#fondo').remove();
		$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
		$('#fondo').append("<div style='position: absolute;top: 50%;left: 50%;'><img src='images/loader.gif'></div>");
		setTimeout(function() {
        	$('#fondo').fadeIn('fast',function(){
            $('#rp').fadeIn();
         	});
        }, 400);
		 var inputFileImage = document.getElementById('adjunto');
		var file = inputFileImage.files[0];
		var data = new FormData();
		data.append('imagendis',file);
        data.append('opc','editar_ds');
		var otradata = $('#perfil').serializeArray();
		$.each(otradata,function(key,input){
       		data.append(input.name,input.value);
    	});
    	var url = 'libs/acc_distribuidor.php';

    	$.ajax({
			url:url,
			type:'POST',
			contentType:false,
			data: data,
			processData:false,
			cache:false,
			dataType: 'json',
			success: function(data){
				if(data.status == 'correcto')
				{
					$('#fondo').remove();
					$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
					$('#fondo').append("<div class='rp' style='display: none; text-align: center' id='rp'><span>Cambios Realizados</span></div>");
					setTimeout(function() {
			        	$('#fondo').fadeIn('fast',function(){
			            $('#rp').animate({'top':'350px'},50).fadeIn();
			         	});
			        }, 400);
			        setTimeout(function() {
			            $("#rp").fadeOut();
			            $('#fondo').fadeOut('fast');
			         	location.reload();
			        }, 2500);

				}
        	}
		});
	})

})