<?php
	session_start();
	if(isset($_SESSION['usulogmarket']))
		$acceso = '<li><a href="historial">Mi cuenta</a></li>
				  <li><a href="libs/logout">Cerrar Sesión</a></li>';
	else
		$acceso = '<li><a class="cd-signin" href="javascript:void(0)">Iniciar Sesión</a></li>';
?>
<nav>
	<div class="container">
	<a class="toggleMenu" href="#">Menu</a>
		<ul class="nav">
			<li  class="test">
				<a href="index">Inicio</a>
			</li>
			<li>
				<a href="nuestra-empresa">Nosotros</a>
			</li>
			<li>
				<a href="#">Quiero ser Cliente</a>
			</li>
			<li>
				<a href="contactenos">Contáctenos</a>
			</li>
			<?php echo$acceso; ?>
		</ul>
	</div>
</nav>
