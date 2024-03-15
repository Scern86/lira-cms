<div class="wrapper">
    <h1>Articles</h1>
    <br>
    <?php
    if(!empty($this->articles)){
        foreach($this->articles as $article){?>
            <article>
                <h2><a href="<?=$article['url'];?>"><?=$article['title'];?></a></h2>
            </article>
            <br>
        <?php }
    }
    ?>
</div>