<?php
/**
 * @var QuarkView|IndexView $this
 * @var QuarkModel|Article $top
 * @var QuarkCollection|Article[] $featured
 * @var QuarkCollection|Article[] $feed
 */
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;

use Models\Article;

use ViewModels\IndexView;
?>
<div class="quark-container" id="app-index">
	<div class="quark-column">
		<?php
		if ($top != null)
			echo '
				<div class="quark-container" id="app-index-top">
					<div class="quark-container app-article-item large" style="background-image: url(', $top->cover->URL(), ');">
						<div class="quark-column">
							<a class="quark-container quark-link app-article-item-title">
								<!-- https://loremflickr.com/cache/resized/65535_52433126604_0a10060ffa_c_720_320_nofilter.jpg -->
								', $top->title->Current(), '
							</a>
							<div class="quark-container app-article-item-summary">
								', $top->Summary(), '
							</div>
							<div class="quark-container app-article-item-meta">
								<div class="quark-column fa fa-globe app-article-item-meta-item">
									HereNounce Root
								</div>
								<div class="quark-column fa fa-user app-article-item-meta-item">John Doe</div>
								<div class="quark-column fa fa-calendar-plus-o app-article-item-meta-item">
									', $top->date_created->Format('d.m.Y H:i'), '
								</div>
							</div>
						</div>
					</div>
				</div>
			';
		?>
		<div class="quark-container" id="app-index-featured">
			<div class="quark-column fill">
				<div class="quark-container app-section-header">
					Featured
				</div>
				<div class="quark-container">
					<?php
					foreach ($featured as $article)
						echo '
							<div class="quark-column app-article-item small" style="background-image: url(', $article->cover->URL(), ');">
								<a class="quark-container quark-link app-article-item-title">
									', $article->title->Current(), '
								</a>
								<div class="quark-container app-article-item-meta">
									<div class="quark-column app-article-item-meta-internal">
										<div class="quark-container fa fa-globe app-article-item-meta-item">
											HereNounce Root
										</div>
										<div class="quark-container fa fa-user app-article-item-meta-item">
											John Doe
										</div>
										<div class="quark-container fa fa-calendar-plus-o app-article-item-meta-item">
											', $article->date_created->Format('d.m.Y H:i'), '
										</div>
									</div>
								</div>
							</div>
						';
					?>
				</div>
			</div>
		</div>
		<div class="quark-container" id="app-index-feed">
			<div class="quark-column fill">
				<div class="quark-container app-section-header">
					Feed
				</div>
				<div class="quark-container">
					<div class="quark-column fill">
						<?php
						foreach ($feed as $article)
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
			</div>
		</div>
	</div>
</div>