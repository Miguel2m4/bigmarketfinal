$(document).ready(function(){

	carrito  = localStorage.getItem("carrito");
	hentrega = localStorage.getItem("hentrega");

	carrito  = JSON.parse(carrito);
	hentrega = JSON.parse(hentrega);

	if(carrito==null)
		carrito = [];

	$.getJSON('libs/checkcon',{info:'tipo'}).done(function(data){
		if(data.tipo != 'error')
		{
			if(carrito.length > 0)
			{
				$('#fondo').remove();
				$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
				$('#fondo').append("<div style='position: absolute;top: 50%;left: 50%;'><img src='images/loader.gif'></div>");
				setTimeout(function() {
		        	$('#fondo').fadeIn('fast',function(){
		            $('#rp').fadeIn();
		         	});
		        }, 400);
				data = new FormData();
				for(var i in carrito)
				{
					prod = JSON.parse(carrito[i]);
					data.append('id[]',prod.id);
					data.append('nombre[]',prod.nombre);
					data.append('desc[]',prod.desc);
					data.append('cantidad[]',prod.cant);
					data.append('valor[]',prod.valor);
				}
				for(var i in hentrega)
				{
					entrega = JSON.parse(hentrega[i]);
					data.append('hora',entrega.hra);
					data.append('entrega',entrega.fec);
				}
				data.append('opc','registrar');
				var url = 'libs/acc_pedidos.php';
				$.ajax({
					url         : url,
					type        : 'POST',
					contentType : false,
					data        : data,
					processData : false,
					cache       : false,
					dataType    : 'json',
					success     : function(data){
						if(data.status == 'correcto')
						{
							$('#fondo').remove();
							$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
							$('#fondo').append("<div class='rp' style='display: none; text-align: center' id='rp'><span>Pedido Registrado</span></div>");
							setTimeout(function() {
					        	$('#fondo').fadeIn('fast',function(){
					            $('#rp').animate({'top':'350px'},50).fadeIn();
					         	});
					        }, 400);
					        setTimeout(function() {
					            $("#rp").fadeOut();
					            $('#fondo').fadeOut('fast');
					        }, 2500);
					        for(var i in carrito){
								carrito.splice(i-1, 1);
							}
							localStorage.removeItem('carrito');
							localStorage.removeItem('hentrega');
							setTimeout(function(){
								location.reload();
							},3000)
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
			}
		}
		else
		{
			if(carrito.length > 0)
			{
				$('#fondo').remove();
				$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
				$('#fondo').append("<div class='rp' style='display: none; text-align: center' id='rp'><span>Para realizar un pedido debe loguear como Comprador</span></div>");
				setTimeout(function() {
		        	$('#fondo').fadeIn('fast',function(){
		            $('#rp').animate({'top':'350px'},50).fadeIn();
		         	});
		        }, 400);
		        setTimeout(function() {
		            $("#rp").fadeOut();
		            $('#fondo').fadeOut('fast');
		        }, 3000);
		        for(var i in carrito){
					carrito.splice(i-1, 1);
				}
				localStorage.removeItem('carrito');
				localStorage.removeItem('hentrega');
			}
		}
	})

	$('.fecha-calend input').datetimepicker({
		timepicker 		  : false,
		lang       		  : 'es',
		format     		  : 'Y/m/d',
		closeOnDateSelect : true
	});

	$('.fecha-calend img').on('click',function(){
		$(this).prev().datetimepicker('show')
	})

	$('.ver').on('click',function(){
		$('<form action="libs/verpedido.php" method="POST" target="_blank">' +
   				 '<input type="hidden" name="pedido" value="' +$(this).prop('id')+ '">' +
     	'</form>').submit();
	})

})