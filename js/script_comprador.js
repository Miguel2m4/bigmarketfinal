$(document).ready(function(){
acc = 0,carga = 0;

	$('#accion').on('change',function(){
		$('input').not('[type="radio"], [type="submit"]').val('');

		if($(this).val()=='crear')
		{
			acc = 1;
			$('input').removeAttr('disabled');
			$('[name=nit]').removeAttr('readonly style');
			carga ='/&·(·';
		}
		if($(this).val()=='editar')
		{
			acc = 2 ;
			$('[name=nit]').removeAttr('disabled readonly style');
			$('input').not('[name=nit]').attr('disabled',true);
		}
		if($(this).val()=='')
		{
			acc = 0;
			$('input').attr('disabled',true);
			carga ='/&·(·';
		}
	})


	$('[name=nit]').on('blur',function(){
		tempnit =  $(this).val();
		if(tempnit!='' && tempnit!=carga)
			{
				if(acc==1)
				{
					$.post('libs/acc_comprador',{opc:'comprobar',nit:$('[name=nit]').val()}).done(function(data){
						if(data=='error')
						{
							$('#fondo').remove();
							$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
							$('#fondo').append("<div class='rp' style='display: none; text-align: center' id='rp'><span>Error! - El comprador ya existe</span></div>");
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
					$.getJSON('libs/acc_comprador',{opc:'cargardat',nit:$('[name=nit]').val()}).done(function(data){
						if(data.info=='')
							{
								$('#fondo').remove();
								$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
								$('#fondo').append("<div class='rp' style='display: none; text-align: center' id='rp'><span>Error! - El comprador no existe</span></div>");
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
						        carga ='/&·(·';
							}
						else
						{
							$('[name=nit]').attr('readonly',true).css('background','rgba(202, 202, 202, 0.24)');
							$('input').removeAttr('disabled');
							$.each(data.info,function(i,dat){
								$('[name="razon"]').val(dat.razon_cp);
								$('[name="telefono"]').val(dat.telefono_cp);
								$('[name="movil"]').val(dat.movil_cp);
								$('[name="direccion"]').val(dat.direccion_cp);
								$('[name="email"]').val(dat.email_cp);
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

	$('#comprador').on('submit',function(e){
		e.preventDefault();
		$('#fondo').remove();
		$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
		$('#fondo').append("<div style='position: absolute;top: 50%;left: 50%;'><img src='images/loader.gif'></div>");
		setTimeout(function() {
        	$('#fondo').fadeIn('fast',function(){
            $('#rp').fadeIn();
         	});
        }, 400);
        data = $(this).serializeArray();
        if(acc==1)
        	data.push({name:'opc',value:'crear'});
        if(acc==2)
        	data.push({name:'opc',value:'editar'});
        $.post('libs/acc_comprador',data).done(function(data){
        	if(data=='correcto')
        	{
        		$('#fondo').remove();
				$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
				if(acc==1)
					$('#fondo').append("<div class='rp' style='display: none; text-align: center' id='rp'><span>Comprador Creado</span></div>");
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
		        if(acc==2)
		        	$('input').not('[name=nit]').attr('disabled',true);
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
        })
	})


})