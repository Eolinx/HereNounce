<?php
/**
 * @var QuarkView|LoginView $this
 */
use Quark\QuarkView;

use ViewModels\User\LoginView;
?>
<form class="quark-container" id="app-user-recover" action="/user/recover" method="POST">
	<div class="quark-column">
		<div class="quark-container">
			<div class="quark-column">
				<h1>Recovering password</h1>
				<div class="quark-container content">
					Please fill in your E-mail, used for registering, in order to reset your password<br />
					<br />
					Already have an account? <a class="quark-link" href="/user/login">Log in</a> or <a class="quark-link" href="/user/register">register</a> a new one.
				</div>
			</div>
		</div>
		<div class="quark-container form-group" id="app-user-recover-main">
			<div class="quark-column">
				<?php
				echo '',
				$this->Input(null, 'email', 'user.email', false, 'email');
				?>
			</div>
		</div>
		<div class="quark-container">
			<div class="quark-column">
				<button class="quark-button" type="submit">Recover</button>
			</div>
		</div>
	</div>
</form>