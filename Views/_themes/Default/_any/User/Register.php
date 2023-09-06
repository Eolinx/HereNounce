<?php
/**
 * @var QuarkView|RegisterView $this
 * @var QuarkModel|User $user
 */
use Quark\QuarkModel;
use Quark\QuarkView;

use Models\User;

use ViewModels\User\RegisterView;
?>
<form class="quark-container" id="app-user-register" action="/user/register" method="POST">
	<div class="quark-column">
		<div class="quark-container">
			<div class="quark-column">
				<h1>Registration</h1>
				<div class="quark-container content">
					Please fill in the following fields in order to sign up<br />
					<br />
					Already have an account? <a class="quark-link" href="/user/login">Log in</a>.<br />
					Lost your account? You can try to <a class="quark-link" href="/user/recover">recover</a> it.
				</div>
			</div>
		</div>
		<div class="quark-container form-group" id="app-user-login-main">
			<div class="quark-column">
				<?php
				echo '',
				$this->Input($user, 'email', 'user.email', false, 'email'),
				$this->Input($user, 'name', 'user.name', false, 'name'),
				$this->Input($user, 'password', 'user.password', false, 'password', true),
				$this->Input($user, 'password_confirm', 'user.password_confirm', false, 'password', true);
				?>
			</div>
		</div>
		<div class="quark-container">
			<div class="quark-column">
				<button class="quark-button" type="submit">Register</button>
			</div>
		</div>
	</div>
</form>