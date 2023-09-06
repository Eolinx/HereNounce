<?php
/**
 * @var QuarkView|ListView $this
 * @var QuarkCollection|Article[] $articles
 */
use Quark\QuarkCollection;
use Quark\QuarkView;

use Models\Article;

use ViewModels\Article\ListView;
?>
<div class="quark-container" id="app-article-list">
	<?php
	if (sizeof($articles) == 0)
		echo '<div class="quark-status">There are no any articles yet</div>';
	?>
	<div class="quark-column">
		<?php
		foreach ($articles as $article)
			echo '
				<div class="quark-container app-article-item medium">
					<div class="quark-column app-article-item-cover" style="background-image: url(', $article->cover->URL(), ');"></div>
					<div class="quark-column">
						<a class="quark-container quark-link app-article-item-title" href="/article/', $article->id, '">
							', $article->title->Current(), '
						</a>
						<div class="quark-container app-article-item-summary">
							', $article->Summary(), '
						</div>
						<div class="quark-container app-article-item-meta">
							<div class="quark-column fa fa-globe app-article-item-meta-item">
								', $article->origin, '
							</div>
							<div class="quark-column fa fa-user app-article-item-meta-item">John Doe</div>
							<div class="quark-column fa fa-calendar-plus-o app-article-item-meta-item">', $article->date_created->Format('d.m.Y H:i'), '</div>
						</div>
					</div>
				</div>
			';
		?>
	</div>
</div>