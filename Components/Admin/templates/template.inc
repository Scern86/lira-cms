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

    </header>
    <main>
        <?=$this->content;?>
    </main>
    <footer>

    </footer>
    <?=implode('',$this->bodysLinks);?>
</body>
</html>