<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="fr-FR">
<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="./theme/style.css" media="screen"/>
    <?php

        if($_GET['lang'] == "en") :
            define("DOC_LANG", "en");
            define("DOC_TITLE", "Une République Obcène");
            define("DOC_URL", "http://owni.fr/2010/07/14/the-french-governments-last-supper");
        else :
            define("DOC_LANG", "fr");
            define("DOC_TITLE", "Une République Obcène");
            define("DOC_URL", "http://owni.fr/2010/07/14/la-republique-obcene/");
        endif;

    ?>
    <title><?php echo DOC_TITLE; ?></title>
    
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
          google.load("jquery", "1.4.2");
    </script>

    <script type="text/javascript">
        function getEmbed() {
            $(".mini-embed").hide();
            $(".inputEmbed").show();
            $(':input:eq(0)', '.inputEmbed').select();
        }

        function dropEmbed() {
            $(".mini-embed").show();
            $(".inputEmbed").hide();
        }
    </script>

    <?php if(DOC_LANG == "en") : ?>
        <style type="text/css">
            #workspace {
                background-image: url("./theme/images/elysee_en.png");
            }
        </style>
    <?php endif; ?>
</head>
<body>
    <div id="workspace">
        <div class="view">
            <p class="ministre">&nbsp;<br />&nbsp;</p>
            <?php if(DOC_LANG == "fr") : ?>
                <p class="description">Survolez un ministre...</p>
                <p class="navigation">
                    <span  class="prec" ><img src="./theme/images/precedent.png" alt="prec"/>précédent</span>
                    <span  class="suiv" >suivant<img src="./theme/images/suivant.png" alt="suiv" /></span>
                </p>
            <?php elseif(DOC_LANG == "en"): ?>
                <p class="description">Move the mouse hover the ministers...</p>
                <p class="navigation">
                    <span  class="prec" ><img src="./theme/images/precedent.png" alt="prec"/>previous</span>
                    <span  class="suiv" >next<img src="./theme/images/suivant.png" alt="suiv" /></span>
                </p>
            <?php endif; ?>
            <p class="source">&nbsp;</p>
        </div>
        <div id="footer">
            <a href="http://owni.fr" target="_blank"><img src="./theme/images/owni.png" alt="Owni" /></a>
            <br />
            <div class="clear">
                <span class="share inputEmbed" style="display:none" >
                    <?php if(DOC_LANG == "fr") : ?>
                        <input value='<script type="text/javascript" src="http://app.owni.fr/14juillet/embed.js"></script>' />
                        <span onclick="dropEmbed();">Fermer</span>
                    <?php elseif(DOC_LANG == "en"): ?>
                        <input value='<script type="text/javascript" src="http://app.owni.fr/14juillet/embed-en.js"></script>' />
                        <span onclick="dropEmbed();">Close</span>
                    <?php endif; ?>
                </span>
                
                <?php if(DOC_LANG == "fr") : ?>
                    <a class="share mini-embed bg-white " href="#" onclick="getEmbed()">
                        &lt;intégrer&gt;
                    </a>
                <?php elseif(DOC_LANG == "en"): ?>
                    <a class="share mini-embed bg-white " href="#" onclick="getEmbed()">
                        &lt;embed&gt;
                    </a>
                <?php endif; ?>
                <a class="share mini-share-mail bg-white" target="_blank" href='http://www.addtoany.com/email?linkurl=<?php echo  rawurlencode(DOC_URL);  ?>&linkname=<?php echo   rawurlencode("http://owni.fr/2010/07/14/la-republique-obcene/");  ?>&t=<?php echo rawurldecode(DOC_TITLE); ?>'>
                    <img alt="share mail" src="./theme/images/mini-email.png" /> email
                </a>
                <a class="share mini-share-facebook" target="_blank" href="http://www.facebook.com/share.php?u=<?php echo  rawurlencode(DOC_URL);  ?>&t=<?php echo rawurldecode(DOC_TITLE); ?>">
                    <img alt="facebook"  src="./theme/images/mini-share-facebook.png" />
                </a>

                <span class="share twitter bg-white">
                    <iframe width="90" scrolling="no" height="20" frameborder="0" src="http://api.tweetmeme.com/button.js?url=<?php echo rawurlencode(DOC_URL); ?>&amp;style=compact&amp;hashtags=owni"></iframe>
                </span>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="./scandale.js"></script>
    <script type="text/javascript">
        initScandale( $("#workspace"), "<?php echo DOC_LANG; ?>" );
    </script>
</body>
</html>
