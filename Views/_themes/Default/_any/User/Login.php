<?php
/**
 * @var QuarkView|LoginView $this
 */
use Quark\QuarkView;

use ViewModels\User\LoginView;
?>
<form class="quark-container" id="app-user-login" action="/user/login" method="POST">
	<div class="quark-column">
		<div class="quark-container">
			<div class="quark-column">
				<h1>Authorization</h1>
				<div class="quark-container content">
					Please fill in the following fields for log in<br />
					<br />
					Don't have an account? <a class="quark-link" href="/user/register">Register</a> a new one.<br />
					Lost your account? You can try to <a class="quark-link" href="/user/recover">recover</a> it.
				</div>
			</div>
		</div>
		<div class="quark-container form-group" id="app-user-login-main">
			<div class="quark-column">
				<?php
				echo '',
					$this->Input(null, 'email', 'user.email', false, 'email'),
					$this->Input(null, 'password', 'user.password', false, 'password');
				?>
			</div>
		</div>
		<div class="quark-container">
			<div class="quark-column">
				<button class="quark-button" type="submit">Log in</button>
			</div>
		</div>
	</div>
</form>