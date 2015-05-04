$(document).ready(function(){
acc = 0,carga = 0;

	$('#accion').on('change',function(){
		$('input').not('[type="radio"], [type="submit"]').val('');

		if($(this).val()=='crear')
		{
			acc = 1;
			$('input,[name="categoria"]').removeAttr('disabled');
			$('[name=nit]').removeAttr('readonly style');
			carga ='/&·(·';
		}
		if($(this).val()=='editar')
		{
			acc = 2 ;
			$('[name=nit]').removeAttr('disabled readonly style');
			$('[name="categoria"]').val('');
			$('input,[name="categoria"]').not('[name=nit]').attr('disabled',true);
		}
		if($(this).val()=='')
		{
			acc = 0;
			$('input,[name="categoria"]').attr('disabled',true);
			carga ='/&·(·';
		}
	})


	$('[name=nit]').on('blur',function(){
		tempnit =  $(this).val();
		if(tempnit!='' && tempnit!=carga)
			{
				if(acc==1)
				{
					$.post('libs/acc_distribuidor',{opc:'comprobar',nit:$('[name=nit]').val()}).done(function(data){
						if(data=='error')
						{
							$('#fondo').remove();
							$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
							$('#fondo').append("<div class='rp' style='display: none; text-align: center' id='rp'><span>Error! - El distribuidor ya existe</span></div>");
							setTimeout(function() {
					        	$('#fondo').fadeIn('fast',function(){
					            $('#rp').animate({'top':'350px'},50).fadeIn();
					         	});
					        }, 400);
					        setTimeout(function() {
					            $("#rp").fadeOut();
					            $('#fondo').fadeOut('fast');
					        }, 2500);
					        $('[type="submit"]').attr('disabled',true);
					        carga ='/&·(·';
						}
						else
						{
							 $('[type="submit"]').removeAttr('disabled');
							 carga = tempnit;
						}
					})
				}
				if(acc==2)
				{
					$.getJSON('libs/acc_distribuidor',{opc:'cargardat',nit:$('[name=nit]').val()}).done(function(data){
						if(data.info=='')
							{
								$('#fondo').remove();
								$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
								$('#fondo').append("<div class='rp' style='display: none; text-align: center' id='rp'><span>Error! - El distribuidor no existe</span></div>");
								setTimeout(function() {
						        	$('#fondo').fadeIn('fast',function(){
						            $('#rp').animate({'top':'350px'},50).fadeIn();
						         	});
						        }, 400);
						        setTimeout(function() {
						            $("#rp").fadeOut();
						            $('#fondo').fadeOut('fast');
						        }, 2500);
						        $('[type="submit"]').attr('disabled',true);
						        $('input').not('[name=nit],[type="radio"],[type="submit"]').val('');
						        $('[name="categoria"]').val('');
						        carga ='/&·(·';
							}
						else
						{
							$('[name=nit]').attr('readonly',true).css('background','rgba(202, 202, 202, 0.24)');
							$('input,[name="categoria"]').removeAttr('disabled');
							$.each(data.info,function(i,dat){
								$('[name="categoria"]').val(dat.categoria_ds);
								$('[name="razon"]').val(dat.razon_ds);
								$('[name="telefono"]').val(dat.telefono_ds);
								$('[name="movil"]').val(dat.movil_ds);
								$('[name="direccion"]').val(dat.direccion_ds);
								$('[name="email"]').val(dat.email_ds);
								$.each($('[name="aprobar"]'),function(){
									if($(this).val()==dat.aprobado)
										$(this).attr('checked',true);
								})
							})
							carga = tempnit;
						}
					})
				}
			}
		else
			$('[name=nit]').attr('readonly',true).css('background','rgba(202, 202, 202, 0.24)');

	})

	$('[name=nit]').on('dblclick',function(){
		$(this).removeAttr('readonly style');
	})

	$('#distribuidor').on('submit',function(e){
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
		if(acc==1)
        	data.append('opc','crear');
        if(acc==2)
        	data.append('opc','editar');
		var otradata = $('#distribuidor').serializeArray();
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
					if(acc==1)
						$('#fondo').append("<div class='rp' style='display: none; text-align: center' id='rp'><span>Distribuidor Creado</span></div>");
					if(acc==2)
						$('#fondo').append("<div class='rp' style='display: none; text-align: center' id='rp'><span>Cambios Realizados</span></div>");
					setTimeout(function() {
			        	$('#fondo').fadeIn('fast',function(){
			            $('#rp').animate({'top':'350px'},50).fadeIn();
			         	});
			        }, 400);
			        setTimeout(function() {
			            $("#rp").fadeOut();
			            $('#fondo').fadeOut('fast');
			        }, 2500);
			        $('input').not('[type="radio"], [type="submit"]').val('');
			        $('[name="categoria"]').val('');
			        if(acc==2)
			        {
			        	$('input,[name="categoria"]').not('[name=nit]').attr('disabled',true);
			        }
			        $('[name=nit]').removeAttr('readonly style');
			        carga ='/&·(·';
				}
				else
				{
					$('#fondo').remove();
					$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
					$('#fondo').append("<div class='rp' style='display: none; text-align: center' id='rp'><span>Error!</span></div>");
					setTimeout(function() {
			        	$('#fondo').fadeIn('fast',function(){
			            $('#rp').animate({'top':'350px'},50).fadeIn();
			         	});
			        }, 400);
			        setTimeout(function() {
			            $("#rp").fadeOut();
			            $('#fondo').fadeOut('fast');
			        }, 2500);
				}
        	}
		});
	})


})