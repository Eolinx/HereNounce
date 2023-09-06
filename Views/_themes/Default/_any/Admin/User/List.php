<?php
/**
 * @var QuarkView|ListView $this
 * @var QuarkCollection|User[] $list
 * @var string $act
 */
use Quark\QuarkCollection;
use Quark\QuarkView;

use Models\User;

use ViewModels\Admin\User\ListView;
?>
<div class="quark-container" id="app-admin-user-list">
	<div class="quark-column">
		<div class="quark-container">
			<h1>Users</h1>
		</div>
		<div class="quark-container">
			<a class="quark-button" href="/admin/user/create">Create</a>
		</div>
		<?php echo $this->StatusAct('user', $act); ?>
		<div class="quark-container" id="app-admin-user-list-list">
			<div class="quark-column">
				<?php
				if (sizeof($list) == 0)
					echo '<div class="quark-container quark-status info">There are no any registered users yet</div>';

				foreach ($list as $user)
					echo '
						<div class="quark-container quark-box app-entity app-admin-user-list-item">
							<div class="quark-column app-admin-user-list-item-image" style="background-image: url(', $user->avatar->URL(), ');"></div>
							<div class="quark-column app-admin-user-list-item-meta">
								<div class="quark-container app-admin-user-list-item-meta-name">
									<!--<a class="quark-link" href="/admin/user/', $user->id, '">', $user->name, '</a>-->
									', $user->name, '
								</div>
								<div class="quark-container app-admin-user-list-item-meta-email">', $user->email, '</div>
								<div class="quark-container app-admin-user-list-item-meta-role">', $this->CurrentLocalizationOf('enum.user.role.' . $user->role), '</div>
								<div class="quark-container app-admin-user-list-item-meta-actions">
									<a class="quark-link" href="/admin/user/update/', $user->id, '">Edit</a>
									<a class="quark-link app-action remove" href="', $this->Link('/admin/user/remove/' . $user->id, true), '" quark-dialog="#app-dialog-user-remove">Delete</a>
								</div>
							</div>
						</div>
					';
				?>
			</div>
		</div>
	</div>
</div>
<?php
echo $this->Dialog(
	'app-dialog-user-remove',
	'user_remove'
);