<?php
/**
 * @var QuarkView|CreateView $this
 * @var QuarkModel|User $user
 */
use Quark\QuarkModel;
use Quark\QuarkView;

use Models\User;

use ViewModels\Admin\User\CreateView;
?>
<form class="quark-container" id="app-admin-user-create" action="/admin/user/create" method="POST">
	<div class="quark-column">
		<div class="quark-container">
			<h1>User creation</h1>
		</div>
		<div class="quark-container">
			<div class="quark-column">
				<?php
				echo '',
					$this->Input($user, 'name', 'user.name'),
					$this->Input($user, 'email', 'user.email'),
					$this->Select($user, 'role', 'user.role', array(
						User::ROLE_USER,
						User::ROLE_OPERATOR,
						User::ROLE_ADMIN
					));
				?>
			</div>
		</div>
		<div class="quark-container">
			<div class="quark-column">
				<?php
				echo '',
					$this->Input($user, 'password', 'user.password', false, 'password', true),
					$this->Input($user, 'password_confirm', 'user.password_confirm', false, 'password', true);
				?>
			</div>
		</div>
		<div class="quark-container">
			<?php echo $this->Signature(); ?>
			<button class="quark-button" type="submit">Create</button>
		</div>
	</div>
</form>