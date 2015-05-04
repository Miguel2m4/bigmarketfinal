var $menu = $(".carrito"),
	$button = $("#mostrar-carrito").first();

	function mostrarMenu(){
	$menu.slideToggle()
	return false;
}

//Eventos
$button.click( mostrarMenu);