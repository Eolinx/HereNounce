<?php
/**
 * @var QuarkView|UpdateView $this
 * @var QuarkModel|Article $article
 */
use Quark\QuarkModel;
use Quark\QuarkView;

use Models\Article;

use ViewModels\Article\UpdateView;
?>
<form class="quark-container" id="app-article-update" action="/article/update" method="POST">
	<div class="quark-column">
		<div class="quark-container">
			<div class="quark-column">
				<h1>Editing article "<?php echo $article->title->Current(); ?>"</h1>
				Change the fields below and click "Save" to edit this article
			</div>
		</div>
		<div class="quark-container form-group" id="app-article-update-main">
			<div class="quark-column">
				<?php
				echo '',
					$this->Input($article, 'title', 'article.title', true),
					$this->Textarea($article, 'content', 'article.content', true),
					$this->File($article, 'cover', 'article.cover', true);
				?>
			</div>
		</div>
		<div class="quark-container">
			<div class="quark-column">
				<?php echo $this->Signature(); ?>
				<button class="quark-button" type="submit">Save</button>
			</div>
		</div>
	</div>
</form>