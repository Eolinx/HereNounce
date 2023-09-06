<?php
/**
 * @var QuarkView|SideView $this
 * @var QuarkModel|Article $article
 */
use Quark\QuarkModel;
use Quark\QuarkView;

use Models\Article;
use Models\User;

use ViewModels\Article\SideView;

/**
 * @var QuarkModel|User $user
 */
$user = $this->User();

if ($article->CanBeEditedBy($user))
	echo '
		<div class="quark-container" id="app-main-side-article-author">
			<div class="quark-column fill">
				<div class="quark-container app-section-header" id="app-main-side-article-author-header">
					Editing article
				</div>
				<div class="quark-container app-side-menu" id="app-main-side-article-author-sections">
					<div class="quark-column fill">
						<a class="quark-link" href="/article/update/', $article->id, '">Edit</a>
						<a class="quark-link" href="', $this->Link('/article/remove/' . $article->id), '">Delete</a>
					</div>
				</div>
			</div>
		</div>
	';