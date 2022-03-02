<div class="row row-paragrafo row-form-contatti">
    <div class="myIn">
	    <div class="form_contatti_in">
      		<h3>Contattaci per maggiori informazioni:</h3>
	  		<form action="" method="get" class="form_cnt">
			  <div class="form-row">
			    <input type="text" name="nome" id="nome" placeholder="Nome" required>
			    <input type="email" name="email" id="email" placeholder="Email" required>
			    <input type="tel" name="tel" id="tel" placeholder="Telefono">
			  </div>

			   <div class="form-row">
				   <textarea>Messaggio..</textarea>
			  </div>
			  

			    <button type="submit" value="Invia"><?= appLabel('Invia', $app->labels, true) ?></button>
			</form>
	    </div>
    </div>
</div>