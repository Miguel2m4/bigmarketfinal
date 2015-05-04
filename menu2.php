<?php
	 if(!isset($_SESSION))
    {
        session_start();
    }
	if(!isset($_SESSION['usulogmarket']))
		header('Location: index');
	else
	{
		if($_SESSION['tipousumarket']=='comprador')
		{
			$acceso = '<li>
						<a href="misdatos"><span class="icon-comprador icon-tam"></span>Mis Datos</a>
					</li>
					<li>
						<a href="historial"><span class="icon-histor icon-tam"></span>Historial</a>
					</li>
					<li>
						<a href="index"><span class="icon-comprador icon-tam"></span>Ir al sitio</a>
					</li>
					<li>
						<a href="libs/logout"><span class="icon-cerrar icon-tam"></span>Cerrar Sesión</a>
					</li>';
		}
		if($_SESSION['tipousumarket']=='distribuidor')
		{
			$acceso = '<li>
						<a href="misdatosdis"><span class="icon-comprador icon-tam"></span>Mis Datos</a>
					</li>
					<li>
						<a href="productodis"><span class="icon-producto icon-tam"></span>Productos</a>
					</li>
					<li>
						<a href="index"><span class="icon-comprador icon-tam"></span>Ir al sitio</a>
					</li>
					<li>
						<a href="libs/logout"><span class="icon-cerrar icon-tam"></span>Cerrar Sesión</a>
					</li>';
		}
		if($_SESSION['tipousumarket']=='administrador')
		{
			$acceso = '<li >
						 <a href="comprador"><span class="icon-comprador icon-tam"></span>Comprador</a>
					</li>
					<li>
						<a href="distribuidor"><span class="icon-distribuidor icon-tam"></span>Distribuidor</a>
					</li>
					<li>
						<a href="producto"><span class="icon-producto icon-tam"></span>Productos</a>
					</li>
					<li>
						<a href="historial"><span class="icon-histor icon-tam"></span>Historial</a>
					</li>
					<li>
						<a href="index"><span class="icon-comprador icon-tam"></span>Ir al sitio</a>
					</li>
					<li>
						<a href="libs/logout"><span class="icon-cerrar icon-tam"></span>Cerrar Sesión</a>
					</li>';
		}
	}
?>
<nav>
	<div class="container">
		<a class="toggleMenu" href="#">Menu</a>
		<ul class="nav">
			<?php echo$acceso; ?>
		</ul>
	</div>
</nav>
