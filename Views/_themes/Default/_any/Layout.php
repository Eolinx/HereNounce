<?php
/**
 * @var QuarkView|LayoutView $this
 */
use Quark\QuarkModel;
use Quark\QuarkView;

use Models\User;

use ViewModels\IView;
use ViewModels\LayoutView;

/**
 * @var QuarkModel|User $user
 */
$user = $this->User();
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $this->Title(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<?php echo $this->Resources(); ?>
</head>
<body>
	<div class="quark-screen" id="app-header">
		<div class="quark-container">
			<div class="quark-column" id="app-header-logo">
				<a class="quark-container" href="/">
					<div class="quark-column">Here</div>
					<div class="quark-column">Nounce</div>
				</a>
			</div>
			<div class="quark-column" id="app-header-mobile">
				<a class="quark-button fa fa-bars"></a>
			</div>
			<div class="quark-column" id="app-header-menu">
				<div class="quark-container">
					<a class="quark-link" href="/">Home</a>
					<a class="quark-link" href="/article/list">Feed</a>
					<a class="quark-link" href="/network">Network</a>
					<a class="quark-link" href="/info/about">About</a>
					<?php
					if (User::HasRole($user, array(User::ROLE_ADMIN)))
						echo '<a class="quark-link" href="/admin">Administration</a>';
					?>
				</div>
			</div>
			<!--<div class="quark-column fill"></div>-->
			<div class="quark-column" id="app-header-actions">
				<?php
				if (User::HasRole($user, array(User::ROLE_AUTHOR, User::ROLE_ADMIN)))
					echo '<a class="quark-button" href="/article/create">New article</a>';
				?>
			</div>
			<div class="quark-column" id="app-header-user">
				<?php
				echo $user == null
					? '
						<div class="quark-container" id="app-header-user-guest">
							<a class="quark-link" href="/user/register">Register account</a>
							<a class="quark-button" href="/user/login">Log in</a>
						</div>
					'
					: $this->UserWidget($user, 'app-header-user-authorized', true);
				?>
			</div>
		</div>
	</div>
	<!--<div class="quark-column" id="app-side">

	</div>-->
	<div class="quark-screen" id="app-main">
		<div class="quark-container">
			<div class="quark-column" id="app-main-content">
				<?php echo $this->View(); ?>
			</div>
			<div class="quark-column" id="app-main-side">
				<?php
				/**
				 * @var QuarkView|IView $child
				 */
				$child = $this->Child();

				echo $child->Side();
				?>
				<div class="quark-container" id="app-main-side-network">
					<div class="quark-column fill">
						<div class="quark-container app-section-header" id="app-main-side-network-header">
							Network
						</div>
						<div class="quark-container" id="app-main-side-network-stats">
							<div class="quark-column fill">
								<div class="quark-container content">
									Core nodes: <a class="quark-link">5</a>
								</div>
								<div class="quark-container content">
									Full nodes: <a class="quark-link">25</a>
								</div>
								<div class="quark-container content">
									Lite nodes: 150
								</div>
								<div class="quark-container content">
									Users: 350
								</div>
								<div class="quark-container content">
									Articles: 2500
								</div>
							</div>
						</div>
						<div class="quark-container" id="app-main-side-network-join">
							<a class="quark-link">How to join network?</a>
							<!--
							1. log into account on any node
							2. Installation:
							2.1 Manual
							2.1.1 download/clone both HereNounce and <agent> projects
							2.1.2 setup NginX for serving of HereNounce
							2.1.3 navigate to <agent> directory
							2.1.4 run command php ./index.php install
							2.2 Auto within Docker
							2.2.1 download docker-compose.yml
							2.2.1 setup NginX for serving of container's 80 port
							2.2.2 run docker-compose up for docker-compose.yml
							3. during installation remember unique NodeSecret (later you can get it from the application.ini of <agent> app)
							4. open you installation in browser
							5. log into your account
							6. use NodSecret to log into admin dashboard (this action auto-assign current account as local admin)
							-->
						</div>
					</div>
				</div>
			</div>
		</div>
	<!--</div>

	<div class="quark-screen" id="app-footer">-->
		<div class="quark-container" id="app-footer">
			<div class="quark-column" id="app-footer-logo">
				<a class="quark-container" href="/">
					<div class="quark-column">Here</div>
					<div class="quark-column">Nounce</div>
				</a>
			</div>
			<div class="quark-column">&copy;<?php echo date('Y'); ?></div>
			<div class="quark-column fill"></div>
			<div class="quark-column content" id="app-footer-disclaimer">
				All materials are published and maintained by corresponding authors.<br />
				Authors of HereNounce are not related with any of published articles, except those which are corresponding to them.<br />
				<br />
				Profile icons created by <a class="quark-link" href="https://www.flaticon.com/free-icons/profile" title="profile icons">Pixel perfect</a> - Flaticon<br />
				<!--Picture icons created by <a class="quark-link" href="https://www.flaticon.com/free-icons/picture" title="picture icons">Good Ware</a> - Flaticon-->
				Article poster placeholder image by <a class="quark-link" href="https://www.freepik.com/free-vector/upgrade-your-photographs-with-modern-border-frame-template_38091810.htm#page=4&query=image%20placeholder&position=44&from_view=search&track=ais">starline</a> on Freepik
			</div>
		</div>
	</div>
</body>
</html>