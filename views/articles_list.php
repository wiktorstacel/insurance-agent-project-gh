<div id="content" class="row">
    <main style="margin-bottom: 20px;">		
  	
        <?php foreach($articles as $article): ?>
            <div class="col-sm-12">
                <article>
                    <header>
                        <h3 class="title">
                            <a href="article/<?= htmlspecialchars($article['article_id'], ENT_QUOTES, 'UTF-8') ?>/<?= htmlspecialchars($article['sanitazed_title'], ENT_QUOTES, 'UTF-8') ?>"> 
                                <?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </h3>
                    </header>
                    <br />

                    <?php if($article['flag'] == 1): ?>
                        <?= $article['content_str'] ?>
                        <a style="text-decoration: none;" href="article/<?= htmlspecialchars($article['article_id'], ENT_QUOTES, 'UTF-8') ?>/<?= htmlspecialchars($article['sanitazed_title'], ENT_QUOTES, 'UTF-8') ?>">
                             Czytaj dalej
                        </a>
                    <?php else: ?>
                        <?= $article['content_str'] ?>
                    <?php endif; ?>
                
                    <br /><br />
                    <b>Autor:</b><?= htmlspecialchars($article['surname'], ENT_QUOTES, 'UTF-8')?>, <?= htmlspecialchars($article['date'], ENT_QUOTES, 'UTF-8'); ?>
                    <br /><br /><br /><br /><br /><br />
                </article>
            </div>
            <?php endforeach; ?>          
    </main>
    <?php if($this->show_motto)$this->WyswietlMotto(); ?>
</div>