<?php
/**
 * @var QuarkView|IndexView $this
 * @var QuarkModel|Article $article
 * @var QuarkCollection|ArticleComment[] $comments
 * @var string $act
 */
use Quark\QuarkCollection;
use Quark\QuarkModel;
use Quark\QuarkView;

use Models\Article;
use Models\ArticleComment;
use Models\User;

use ViewModels\Article\IndexView;

/**
 * @var QuarkModel|User $user_created
 */
$user_created = $article->user_created->Retrieve();

/**
 * @var QuarkModel|User $user_updated
 */
$user_updated = $article->user_updated->Retrieve();

/**
 * @var QuarkModel|ArticleComment $comment_model
 */
$comment_model = new QuarkModel(new ArticleComment());

$ratio_total = $article->Ratio();
$ratio_total_lt = $ratio_total < 0 ? ' lt' : '';
$ratio_total_gt = $ratio_total > 0 ? ' gt' : '';
?>
<div class="quark-container" id="app-article-index">
	<div class="quark-column fill">
		<div class="quark-container" id="app-article-index-cover" style="background-image: url(<?php echo $article->cover->URL(); ?>);"></div>
		<div class="quark-container">
			<h1><?php echo htmlspecialchars($article->title->Current()); ?></h1>
		</div>
		<?php echo $this->StatusAct('article', $act); ?>
		<div class="quark-container content">
			<?php echo str_replace("\n", '<br />', str_replace("\r\n", "\n", htmlspecialchars($article->content->Current()))); ?>
		</div>
		<div class="quark-container" id="app-article-index-meta">
			<div class="quark-column app-article-index-meta-item">
				<div class="quark-column">
					<div class="quark-container app-article-index-meta-item-label">Author</div>
					<div class="quark-container app-article-index-meta-item-content">
						<div class="quark-column">
							<div class="quark-container content">
								Created by <b><?php echo htmlspecialchars($user_created->name); ?></b>
							</div>
							<div class="quark-container content">
								Updated by <b><?php echo htmlspecialchars($user_updated->name); ?></b>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="quark-column app-article-index-meta-item">
				<div class="quark-column">
					<div class="quark-container app-article-index-meta-item-label">Origin</div>
					<div class="quark-container app-article-index-meta-item-content">
						<a class="quark-link"><?php echo $article->origin; ?></a>
					</div>
				</div>
			</div>
			<div class="quark-column app-article-index-meta-item">
				<div class="quark-column">
					<div class="quark-container app-article-index-meta-item-label">Dates</div>
					<div class="quark-container app-article-index-meta-item-content">
						<div class="quark-column">
							<div class="quark-container content">
								Created: <?php echo $article->date_created->Format('<b>d.m.Y</b> H:i'); ?>
							</div>
							<div class="quark-container content">
								Updated: <?php echo $article->date_updated->Format('<b>d.m.Y</b> H:i'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="quark-column fill"></div>
			<div class="quark-column app-article-index-meta-item" id="app-article-index-ratio">
				<div class="quark-column">
					<div class="quark-container app-article-index-meta-item-label">Ratio</div>
					<div class="quark-container app-article-index-meta-item-content">
						<div class="quark-column<?php echo $ratio_total_lt, $ratio_total_gt; ?>" id="app-article-index-ratio-total" title="Total ratio">
							<?php echo $ratio_total; ?>
						</div>
						<div class="quark-column">
							<div class="quark-container" id="app-article-index-ratio-user" title="Ratio by users"><?php echo $article->ratio_user; ?></div>
							<div class="quark-container" id="app-article-index-ratio-ai" title="Ratio by AI"><?php echo $article->ratio_ai; ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="quark-container" id="app-article-index-comments">
			<div class="quark-column fill">
				<div class="quark-container app-section-header">
					Comments
				</div>
				<div class="quark-container">
					<?php
					if (sizeof($comments) == 0)
						echo '<div class="quark-status info">There are no any comments yet</div>';

					echo '
						<div class="quark-column fill" id="app-article-index-comments-list">
					';

					foreach ($comments as $comment)
						echo '
							<div class="quark-container app-article-comment">
								<div class="quark-column app-article-comment-author">
									', $this->UserWidget($comment->user_created->Retrieve()), '
								</div>
								<div class="quark-column">
									<div class="quark-container app-article-comment-date">
										', $comment->date_created->Format('d.m.Y H:i'), '
									</div>
									<div class="quark-container app-article-comment-content">
									', $comment->comment->Current(), '</div>
								</div>
							</div>
						';

					echo '
						</div>
					';
					?>
				</div>
				<form class="quark-container" id="app-article-index-comment" action="/article/comment/create/<?php echo $article->id; ?>" method="POST">
					<div class="quark-column fill">
						<div class="quark-container"></div>
						<div class="quark-container">
							<?php
							echo '',
							$this->Textarea($comment_model, 'comment', 'article_comment.comment', true);
							?>
						</div>
						<div class="quark-container" id="app-article-index-comment-footer">
							<div class="quark-column">
								<div class="quark-container">
									<?php echo $this->Signature(); ?>
									<button class="quark-button" type="submit">Add comment</button>
								</div>
							</div>
							<div class="quark-column fill"></div>
							<div class="quark-column" id="app-article-index-comment-actions">
								<div class="quark-container">
									<input type="hidden" name="article_ratio_action" />
									<a class="quark-button fa fa-chevron-down" data-article-ratio="down"></a>
									<a class="quark-button fa fa-chevron-up" data-article-ratio="up"></a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>