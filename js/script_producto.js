$(document).ready(function(){
acc = 0,carga = 0;

	lst = window.location.search.substring(1);
	if(lst != '')
	{
		$('#verproductos').fadeIn();
		window.location.hash = '#verproductos';
	}

	$('#accion').on('change',function(){
		$('input').not('[type="radio"], [type="submit"]').val('');

		if($(this).val() == 'crear')
		{
			acc = 1;
			$('[name=nombre]').removeClass('auto');
			$('input,[name="distribuidor"]').removeAttr('disabled');
			$('[name=nombre]').removeAttr('readonly style');
			carga = '/&·(·';
		}
		if($(this).val() == 'editar')
		{
			acc = 2 ;
			$('[name=nombre]').removeAttr('disabled readonly style');
			$('[name=nombre]').addClass('auto');
			$('[name="distribuidor"]').val('');
			$('input,[name="distribuidor"]').not('[name=nombre]').attr('disabled',true);
		}
		if($(this).val() == '')
		{
			acc = 0;
			$('input,[name="distribuidor"]').attr('disabled',true);
			carga = '/&·(·';
		}
	})


	$('[name=nombre]').on('blur',function(){
		tempnit =  $(this).val();
		if(tempnit !='' && tempnit != carga)
			{
				if(acc == 1)
				{
					$.post('libs/acc_producto',{opc:'comprobar',nombre:$('[name=nombre]').val()}).done(function(data){
						if(data == 'error')
						{
							$('#fondo').remove();
							$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
							$('#fondo').append("<div class='rp' style='display: none; text-align: center' id='rp'><span>Error! - El producto ya existe</span></div>");
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
					        carga = '/&·(·';
						}
						else
						{
							 $('[type="submit"]').removeAttr('disabled');
							 carga = tempnit;
						}
					})
				}
				if(acc == 2)
				{
					carga = tempnit;
				}
			}

	})

	$('.auto').live('click focus',function(){
		prod = $(this);
		$(this).autocomplete({
		 source: "libs/acc_producto.php",
      	 minLength: 1,
      	  select: function( a, b ) {
      	 	setTimeout(function(){
      	 		$.getJSON('libs/acc_producto',{opc:'cargardat',nombre:prod.val()}).done(function(data){
      	 			$('[name=nombre]').attr('readonly',true).css('background','rgba(202, 202, 202, 0.24)');
      	 			$.each(data.info,function(i,dat){
      	 				$('input').removeAttr('disabled');
      	 				$('[name="idprod"]').val(dat.Id_pr);
      	 				$('[name="descr"]').val(dat.descr_pr);
      	 				$('[name="valor"]').val(dat.valor_pr);
      	 				$('[name="distribuidor"]').val(dat.distribuidor_pr);
      	 				$.each($('[name="aprobar"]'),function(){
							if($(this).val() == dat.aprobado)
								$(this).attr('checked',true);
						})
      	 			})
      	 			// temprod=prod.val();
      	 		})
      	 	},100);
      	 }
		});
	});

	$('[name=nombre]').on('dblclick',function(){
		$(this).removeAttr('readonly style');
	})

	$('#producto').on('submit',function(e){
		e.preventDefault();
		// if(acc==1)
		// 	temprod=$('[name=nombre]').val(),prod=$('[name=nombre]');
		// if(temprod==prod.val())
		// {
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
			data.append('imagenprod',file);
			if(acc == 1)
	        	data.append('opc','crear');
	        if(acc == 2)
	        	data.append('opc','editar');
			var otradata = $('#producto').serializeArray();
			$.each(otradata,function(key,input){
	       		data.append(input.name,input.value);
	    	});
	    	var url = 'libs/acc_producto.php';

	    	$.ajax({
				url         : url,
				type        : 'POST',
				contentType : false,
				data        : data,
				processData : false,
				cache       : false,
				dataType    : 'json',
				success: function(data){
					if(data.status == 'correcto')
					{
						$('#fondo').remove();
						$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
						if(acc == 1)
							$('#fondo').append("<div class='rp' style='display: none; text-align: center' id='rp'><span>Producto Creado</span></div>");
						if(acc == 2)
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
				        $('[name="distribuidor"]').val('');
				        if(acc == 2)
				       		$('input,[name="distribuidor"]').not('[name=nombre]').attr('disabled',true);
				        $('[name=nombre]').removeAttr('readonly style');
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

	$('#verprods').on('click',function(){
		$('#verproductos').fadeIn();
	})

	$('#edit').on('click',function(){
		$('#verproductos').fadeOut();
		window.history.replaceState("", "Title", window.location.pathname);
	})

	$('.auto2').live('click focus',function(){
		prod = $(this);
		$(this).autocomplete({
			source    : "libs/acc_producto.php",
      		minLength : 1,
		});
	});

	$('.bloqueo').live('click',function(){
		if($(this).is(':checked'))
			aprobar = 'no';
		else
			aprobar = 'si';
		$.post('libs/acc_producto',{opc:'bloquear',idprod:$(this).prop('id'),aprobar:aprobar});
	})

})