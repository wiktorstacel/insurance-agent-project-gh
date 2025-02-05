<div id="content" class="row">
    <main style="margin-bottom: 20px;">
        <div class="col-sm-12">
            <article>
                <header>
                    <h2 class="title"><?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8')?></h2>
                </header>

                <br />
                <?= htmlspecialchars($article['content'], ENT_QUOTES, 'UTF-8');?>
                <br><br>
                <b>Autor:</b> <?= htmlspecialchars($article['surname'], ENT_QUOTES, 'UTF-8')?>, 
                <?= htmlspecialchars($article['date'], ENT_QUOTES, 'UTF-8')?>, 
                wyświetleń: <?= htmlspecialchars($article['views'], ENT_QUOTES, 'UTF-8');?>
                <br /><br />

                <footer>
                    <div class="user_profile_kontakt" id="kontaktform_div<?= htmlspecialchars($article['user_id'], ENT_QUOTES, 'UTF-8')?>">
                        <br>
                        <img src="css\images\envelop2.png" width="16" height="16" alt="alt"/>
                        <button class="kontaktform_loadButt" value="<?= htmlspecialchars($article['user_id'], ENT_QUOTES, 'UTF-8')?>"> &nbspNapisz zapytanie o ofertę handlową lub spotkanie do autora...</button>
                        </div>
                            ... lub wyszukaj kontakt do doradcy w Twojej okolicy w zakładce <u>Kontakt</u>
                </footer>
            </article>
        </div>
    </main>
    <?php if($this->show_motto)$this->WyswietlMotto();?>
</div>

