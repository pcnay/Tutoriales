<?php
	if ($_POST['r'] == 'movieseries-show' && isset($_POST['imdb_id']))
	{
		// Se mostraraa a información.
		$ms_controller = new MovieSeriesController();
		$ms = $ms_controller->get($_POST['imdb_id']);
		if (empty($ms))
		{
			printf('
				<div class="container">
					<p class="item error">Error Al Cargar La Información De La MovieSerie <b>%s</b></p>
				</div>
			',$_POST['imdb_id']);
		}
		else
		{
			$template_ms = '
				<div class="item movieseries-info">
					<h2 class="p_5">%s</h2>
					<p class="p_5>%s</p>
					<p class="p_5">
						<!-- block = Para que vayan en un renglon, ademas son letras pequeñas "small"-->
						<small class="block">( %s )</small>
						<small class="block"> %s </small>
						<small class="block"> %s </small>
						<small class="block"> %s </small>
						<small class="block"> %s </small>
						<small class="block"> %s </small>
					</p>
					<img class="p_5 poster" src="%s">
					<p class="p_5">Author : <b>%s</b></p>
					<p class="p_5">Actor  : <b>%s</b></p>
					<article class="p_5 ph7 mauto left">%s</article>
					<!-- Mostrando un video de Youtube -->
					<div class="p_5 trailer"> 
						<iframe src="%s" frameborder="0" allowfullscreen></iframe>						
					</div>
					<input class="p_5 button add" type="button" value="Regresar" onclick="history.back()">	
				</div>
			';
			/* Reproduce el video de la URL que se le proporcione. 
							https://www.youtube.com/watch?v=AL9zLctDJaU --> Se obtiene de "youtube"
							https://www.youtube.com/embed/k_UTfaGCDnU --> Esta forma para utilizar "iframe"

						
			*/		
			// Se utilizar una función de PHP para modificar la variable a utilizar en "iframe"
			$trailer = str_replace('watch?v=','embed/',$ms[0]['trailer']);

			printf($template_ms,
					$ms[0]['title'],
					$ms[0]['genres'],
					$ms[0]['imdb_id'],
					$ms[0]['estatus'],
					$ms[0]['category'],
					$ms[0]['country'],
					$ms[0]['primiere'],
					$ms[0]['rating'],
					$ms[0]['poster'],
					$ms[0]['author'],
					$ms[0]['actors'],
					$ms[0]['plot'],
					// $ms[0]['trailer']
					$trailer
				);
		}

	}	
	else
	{
		$controller = new ViewController();
		$controller->load_view('error404');
	}
?>
