<!doctype html>
<html lang="<?= $this->lexicon->currentLang->code; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport"
          content="width=device-width, shrink-to-fit=no, initial-scale=1.0, maximum-scale=2.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/favicon.ico">
    <title><?=$this->title;?></title>
    <?=implode('',$this->headersLinks);?>
</head>
<body>
    <header>
        <a class="logo" href="/">
            LiraCMS
        </a>
        <div class="menu-block">
            <nav class="menu">
                <a class="item" href="/">Home</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="wrapper">
            <?=$this->content;?>
        </div>
    </main>
    <footer>
        <div class="wrapper">
            <div class="right">
                <div class="copyright">
                    © 2024 SCERN
                </div>
            </div>
        </div>
    </footer>
    <?=implode('',$this->bodysLinks);?>
</body>
</html>