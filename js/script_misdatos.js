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
		data = $(this).serializeArray();
		data.push({name:'opc',value:'editar_cp'})
		$.post('libs/acc_comprador',data).done(function(data){
			if(data=='correcto')
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
		        }, 2500);
		        $('[name="pass"]').val('');
			}
		})
	})

})