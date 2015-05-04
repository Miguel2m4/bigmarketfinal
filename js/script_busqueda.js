$(document).ready(function(){
	h1 = '9 - 11: AM';
	h2 = '3 - 6: PM';

	buscar_prod($('[name=producto]').val());

	$('#busqueda').on('submit',function(e){
		e.preventDefault();
		buscar_prod($('[name=producto]').val())
	})

	function buscar_prod(pr)
	{
		var data = new FormData();
		$.each($('#tags a'),function(){
			data.append('categoria[]',$(this).prop('id'));
		})
		data.append('producto',pr);
		$('#resultados').fadeOut(0,function(){
			$(this).empty();
		})
		$('#carga').fadeIn()
		$.ajax({
			url:'libs/acc_busqueda',
			type:'POST',
			contentType:false,
			data: data,
			processData:false,
			cache:false,
			dataType: 'json',
			success: function(data){
				$.each(data,function(i,dat){
					if(dat.imagen_pr!='')
						imgprod = (dat.imagen_pr).substr(1);
					else
						imgprod = (dat.imagen_ds).substr(1);

					valor = jsDecimal(dat.valor_pr,'',',','.');
					$('#resultados').append('<div class="produ">'+
												'<div class="imagen-pro" style="background: url('+imgprod+');background-size: cover;"></div>'+
												'<div class="contenido-pro" id="'+dat.Id_pr+'">'+
													'<h2>'+dat.nombre_pr+'</h2>'+
													'<p> <input type="number" min="0" step="1" placeholder="Cant" class="cant">  '+dat.descr_pr+'</p>'+
													'<h3>$ '+valor+'</h3>'+
													'<p><a href="javascript:void(0)" class="tocart"><span class="icon-shopping-cart"></span>Añadir al carrito</a></p>'+
													'<br>'+
												'</div>'+
											'</div>')
				})
				$('#carga').fadeOut(function(){
					$('#resultados').fadeIn();
				});
	    	}
		});
	}

	$('.icon-borrar').live('click',function(){
		$(this).parent().remove()
	})

	$('#categorias li').on('click',function(){
		if($(this).text() != 'Todas')
		{
			cate = $(this).text();
			if($('#tags').length !== $('#tags:contains("'+cate+'")').length)
				$('#tags').append('<a href="javascript:void(0)" id="'+$(this).prop('id')+'">'+cate+'<span class="icon-borrar"></span></a>');
		}
		else
		{
			$.each($('#categorias li'),function(){
				if($(this).text() != 'Todas')
				{
					cate = $(this).text();
					if($('#tags').length !== $('#tags:contains("'+cate+'")').length)
						$('#tags').append('<a href="javascript:void(0)" id="'+$(this).prop('id')+'">'+cate+'<span class="icon-borrar"></span></a>');
				}
			})
		}
	})

	var index = -1;

	var carrito = localStorage.getItem("carrito");

	carrito = JSON.parse(carrito);

	if(carrito==null)
		carrito = [];
	else
		ListCar();

	function ListCar(){
		$('#lista').empty();
		$('.carrito-respon').empty()

		subtotal = 0,totalprod=0;
		for(var i in carrito){
			prod       = JSON.parse(carrito[i]);
			totalprod += parseInt(prod.cant);
			subtotal  += parseInt((prod.valor)*(prod.cant));
		}
		tmpsub   = subtotal;
		subtotal = jsDecimal(subtotal,'',',','.');
		total    = jsDecimal((tmpsub+5000),'',',','.');
		var datos =" ";
		var datosmini =" ";
		datos += "<thead>";
		datos +=	"<tr>";
		datos +=	"	<td><h2>Numero de Items</h2><p>("+totalprod+")</p></td>";
		datos +=	"	<td><h2>Subtotal</h2><p>$ "+subtotal+"</p></td>";
		datos +=	"	<td><h2>Valor Servicio<p>$ 5.000</p></h2></td>";
		datos +=	"	<td><h2>Total</h2><p>$ "+total+"</p></td>";
		datos +=	"	<td><a href='javascript:void(0)' id='elimcpr'>Eliminar Compra</a></td>";
		datos +=	"</tr>";
		datos +="</thead>";
		datos +="<tbody>";

		$('.bgc').html(totalprod);

		for(var i in carrito){
			var prod = JSON.parse(carrito[i]);

			valuni = jsDecimal(prod.valor,'',',','.');
			valtol = jsDecimal((prod.valor*prod.cant),'',',','.');

		  	datos +="<tr>";
			datos += '	<td><h2>'+prod.nombre+'</h2>';
			datos += '  <p>'+prod.desc+'</p></td>' ;
			datos += '	<td><h2>Valor Unitario</h2>' ;
			datos += '  <p>$ '+valuni+'</p></td>' ;
			datos += '	<td><h2>Valor Total</h2>' ;
			datos += '  <p>$ '+valtol+'</p></td>' ;
			datos += '	<td><input type="number" min="0" step="1" placeholder="Cant" class="mascant" id="'+i+'" value="'+prod.cant+'"></td>' ;
			datos += '	<td><a href="javascript:void(0)" class="elimprod" id="'+i+'">Retirar</a></td>' ;
			datos += "</tr>";

			datosmini += '<div class="item-despl">';
			datosmini += '<h2>'+prod.nombre+'</h2>'
			datosmini += '<p><input type="number" min="0" step="1" placeholder="Cant" class="mascant" id="'+i+'" value="'+prod.cant+'">  '+prod.desc+'</p>';
			datosmini += '<h3>$ '+valtol+'</h3>';
			datosmini += '<a href="javascript:void(0)" class="elimprod" id="'+i+'">Retirar</a>';
			datosmini += '</div>';
		}
		datos +="</tbody>";
		$('#lista').append(datos);
		$('.carrito-respon').append(datosmini);
	}

	function AddProd(a){
		comprobar = AddExist(a);
		if(comprobar!=true)
		{
			var producto = JSON.stringify({
				id     :  a.parent().parent().prop('id'),
				nombre :  a.parent().parent().find('h2').text(),
				desc   :  a.parent().parent().find('h2').next().text(),
				cant   :  a.parent().parent().find('.cant').val(),
				valor  :  (a.parent().parent().find('h3').text().substr(1)).replace(/\./g, '')
			});
			carrito.push(producto);
			localStorage.setItem("carrito", JSON.stringify(carrito));
			a.parent().parent().find('.cant').val(''),
			ListCar();
			return true;
		}
		else
			a.parent().parent().find('.cant').val('');
	}

	function AddExist(a){
		nombre =  a.parent().parent().find('h2').text();
		desc   =  a.parent().parent().find('h2').next().text();
		cant   =  a.parent().parent().find('.cant').val();

		for(var i in carrito){
			prod = JSON.parse(carrito[i]);
			if(prod.nombre==nombre && prod.desc==desc){
				EditProd(i,(parseInt(cant)+parseInt(prod.cant)));
				return true;
			}
		}
	}

	function ElimProd(index,e){
		carrito.splice(index, 1);
		localStorage.setItem("carrito", JSON.stringify(carrito));
		e.closest('tr').fadeOut(500, function() {
			ListCar();
		});
		e.closest('.item-despl').fadeOut(500, function() {
			ListCar();
		});
		if(carrito.length<1)
			$('#elimcpr').click();
	}

	function EditProd(index,ct){
		var prod = JSON.parse(carrito[index]);
		carrito[index] = JSON.stringify({
				id     :  prod.id,
				nombre :  prod.nombre,
				desc   :  prod.desc,
				cant   :  ct,
				valor  :  prod.valor
			});
		localStorage.setItem("carrito", JSON.stringify(carrito));
		ListCar();
		return true;
	}

	$('.tocart').live('click',function(){
		val = $(this).parent().parent().find('.cant').val();
		if(isNaN(val)==false && val>0)
			AddProd($(this));
	})

	$('#elimcpr').live('click',function(){
		for(var i in carrito){
			carrito.splice(i-1, 1);
		}
		localStorage.removeItem('carrito');
		localStorage.removeItem('hentrega');
		carrito = [];
		msj = '<thead>'+
				'<tr><td><h2>El carrito esta vacio.</h2></td></tr>'+
				'</thead>';
		$('#lista').fadeOut(500,function(){
			$(this).html(msj);
			$(this).fadeIn(2000,function(){
				$('#mostrar-carrito').click()
			});
		})
		$('.carrito-respon').fadeOut(500);
		$('.bgc').html(0);
	})

	$('.elimprod').live('click',function(){
		ElimProd($(this).prop('id'),$(this));
	})

	$('.mascant').live('change',function(){
		ind  = $(this).prop('id');
		cant = $(this).val();
		if(isNaN(cant)==false && cant>0)
			EditProd(ind,cant);
	})

	function jsDecimal(numero, decimales, separador_decimal, separador_miles) {
		numero = parseFloat(numero);
		if(isNaN(numero)) {
			return "";
		}

		if(decimales !== undefined) {
			numero = numero.toFixed(decimales);
		}

		numero = numero.toString().replace(".", separador_decimal !== undefined ? separador_decimal : ",");

		if (separador_miles) {
			var miles = new RegExp("(-?[0-9]+)([0-9]{3})");
			while(miles.test(numero)) {
				numero = numero.replace(miles, "$1" + separador_miles + "$2");
			}
		}

		return numero;
	}

	$('.terminar-ped').on('click',function(){
		if(carrito.length<1)
		{
			$('#fondo').remove();
			$('body').append("<div class='fondo' id='fondo' style='display:none;'></div>");
			$('#fondo').append("<div class='rp' style='display: none; text-align: center' id='rp'><span>Tu carrito de compras esta vacio!</span></div>");
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
		else
		{
			swal({
					title              : 'Fecha de Entrega',
					html               : '<input id="fech" type="text" style="display:none">',
					confirmButtonColor : '#FFD324',
					closeOnConfirm     : false
				},
				function(isConfirm) {
				   if (isConfirm)
				    {
				    	swal({
							title			   : 'Horario de Entrega',
							showCancelButton   : true,
							confirmButtonText  : h1,
							cancelButtonText   : h2,
							confirmButtonColor : '#D33E3E',
							cancelButtonColor  : '#D33E3E',
							closeOnConfirm     : false,
							closeOnCancel      : false
						},
						function(isConfirm) {
						   if (isConfirm) {
						   		logueo(h1);
						    }
						    else {
						    	logueo(h2);
						     }
						});
				    }
			});

			$('#fech').datetimepicker({
				timepicker : false,
				lang       : 'es',
				inline     : true,
				format     : 'Y/m/d',
				onGenerate:function(dp,$input){
					fec = dp.dateFormat('Y/m/d');
				},
				onChangeDateTime:function(dp,$input){
					fec = ($input.val());
				}
			});
		}
	})

	function logueo(hr)
	{
		$.getJSON('libs/checkcon',{info:'log'}).done(function(data){
    		if(data.login == 'error')
    		{
    			swal({
    				title             : 'No has iniciado sesión',
    				text              : 'Debes iniciar sesión para realizar un pedido',
    				type              : 'error',
    				showConfirmButton : false,
    				timer             : 2000
    			},
    			function(){
    				$('.cd-signin').click()
    			})
    		}
    		else
    		{
    			swal({
    				title             : 'Correcto!',
    				text              : 'Seras redireccionado en un momento...',
    				type              : 'success',
    				showConfirmButton : false,
    				timer             : 3000
    			},
    			function(){
    				window.location.href = data.redirec;
    			})
    		}

			horaped = [];
			localStorage.removeItem('hentrega');
			entrega = JSON.stringify({
				hra : hr,
				fec : fec
			});
			horaped.push(entrega);
			localStorage.setItem("hentrega", JSON.stringify(horaped));
    	});
	}

})