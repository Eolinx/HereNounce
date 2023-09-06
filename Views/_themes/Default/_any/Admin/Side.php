<?php
/**
 * @var QuarkView|SideView $this
 */
use Quark\QuarkView;

use ViewModels\Admin\SideView;
?>
<div class="quark-container" id="app-main-side-admin">
	<div class="quark-column fill">
		<div class="quark-container app-section-header" id="app-main-side-admin-header">
			Administration
		</div>
		<div class="quark-container app-side-menu" id="app-main-side-admin-sections">
			<div class="quark-column fill">
				<a class="quark-link" href="/admin/article/list">Articles</a>
				<a class="quark-link" href="/admin/user/list">Users</a>
			</div>
		</div>
	</div>
</div>