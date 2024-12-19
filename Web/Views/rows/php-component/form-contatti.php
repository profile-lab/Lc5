<div class="row row-paragrafo row-form-contatti">
	<div class="myIn">
		<div class="form_contatti_in">
			<h3>Contattaci per maggiori informazioni:</h3>
			<form method="post" action="#sendmailform" id="sendmailform" class="form_cnt">
				<?php if (isset($form_result) && isset($form_result->user_mess)) { ?>
					<div class="form-mess form-mess-<?= $form_result->user_mess->type ?>">
						<?= h5($form_result->user_mess->title) ?>
						<?= h6(isset($form_result->user_mess->subtitle) ? $form_result->user_mess->subtitle : null) ?>
						<div><?= $form_result->user_mess->content ?></div>
					</div>
				<?php } ?>
				<div class="form-row">
					<div class="form-field">
						<label for="nome">Nome</label>
						<input type="text" name="name" value="<?= getPost('name')  ?>" placeholder="Nome *" />
					</div>
					<div class="form-field">
						<label for="cognome">Cognome</label>
						<input type="text" name="surname" value="<?= getPost('surname')  ?>" placeholder="Cognome *" />
					</div>
				</div>
				<div class="form-row">
					<div class="form-field">
						<label for="email">Email</label>
						<input type="text" name="email" value="<?= getPost('email')  ?>" placeholder="Indirizzo email *" />
					</div>
				</div>
				<div class="form-row">
					<div class="form-field">
						<label for="tel">Telefono</label>
						<input type="tel" name="tel" value="<?= getPost('tel')  ?>" placeholder="Numero di telefono" />
					</div>
				</div>
				<div class="form-row">
					<div class="form-field form-field-textarea">
						<label for="messaggio">Messaggio</label>
						<textarea name="message" rows="10" placeholder="Il tuo messaggio...*"><?= getPost('message')  ?></textarea>
					</div>
				</div>

				<input type="hidden" name="checkfield" value="name|surname|email|message" />
				<button type="submit" name="send_action" value="sendmailtoinfo"><?= appLabel('Invia', $app->labels, true) ?></button>

			</form>
		</div>
	</div>
</div>

