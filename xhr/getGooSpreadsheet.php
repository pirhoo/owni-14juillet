<?php
        // ce script retourne un objet JSON
        @header('Content-Type: text/html; charset=UTF-8');

        if(isset($_GET['debug'])) {
            ini_set('display_errors', 1);
            ini_set('log_errors', 1);
            error_reporting(E_ALL);
        }

        if($_GET['lang'] == "en")
            define("DOC_LANG", "en");
        else
            define("DOC_LANG", "fr");

     	define("USER_MAIL", "ownidj@gmail.com");
		define("USER_PWD",'eaufroide');
        define("NB_COLL", 7);

        define("DIR_CACHE", "cache/");


        if(DOC_LANG == "fr") 
            define("DOC_NAME", "Scandales ministres");
        elseif(DOC_LANG == "en")
            define("DOC_NAME", "Scandales ministres - en");

        // le doc date de moins d'une demie heure
        $diff = time() - getlastmod(DIR_CACHE.DOC_NAME.".json");
        if(file_exists(DIR_CACHE.DOC_NAME.".json") && $diff <= 60*60):
            // utilise le fichier mis en cache
            echo file_get_contents(DIR_CACHE.DOC_NAME.".json");
        else:
            
            chdir("../");
            require_once './Scandale.class.php';
            require_once './Zend/Loader.php';

            /* Load the Zend Gdata classes. */
            Zend_Loader::loadClass('Zend_Gdata_AuthSub');
            Zend_Loader::loadClass('Zend_Gdata_Gbase');
            Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
            Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

            // on se connecte (authentification) au service google doc
            $service = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;
            $client = Zend_Gdata_ClientLogin::getHttpClient(USER_MAIL, USER_PWD, $service);

            // on récupère la liste de mes documents
            $spreadsheetService = new Zend_Gdata_Spreadsheets($client);
            $feed = $spreadsheetService->getSpreadsheetFeed();

            // récupère la clef du document dans la liste de mes documents
            foreach($feed->entries as $entry)
                if ($entry->title->text == DOC_NAME)
                    $spreadsheetsKey = basename($entry->id);

            // création du coument à partir de cette clef
            // on reçoit toute les cellules du tableau dans un flux
            $query = new Zend_Gdata_Spreadsheets_CellQuery();
            $query->setSpreadsheetKey($spreadsheetsKey);
            $cellFeed = $spreadsheetService->getCellFeed($query);

            // on interprête ce flux pour le classer dans un Array d'objets Scandale
            $scandales = Array();
            foreach($cellFeed as $cellEntery){

                switch ( $cellEntery->cell->getColumn() ){

                    case(1):
                        $ministre = $cellEntery->cell->getText();
                        break;
                    case(2):
                        $description_FR = $cellEntery->cell->getText();
                        break;
                    case(3):
                        $date = $cellEntery->cell->getText();
                        break;
                    case(4):
                        $lien = $cellEntery->cell->getText();
                        break;
                    case(5):
                        $position = $cellEntery->cell->getText();
                        break;
                    case(6):
                        $imgCasserole = $cellEntery->cell->getText();
                        break;
                    case(7):
                        $posCasserole = $cellEntery->cell->getText();
                        break;
                }

                // à chaque fois qu'on arrive à la 4 ème Colonne, on a tous les attributs, on créait le scandale
                // on saute la première ligne
                if($cellEntery->cell->getColumn() == NB_COLL && $cellEntery->cell->getRow() > 1)
                        $scandales[] = new Scandale($ministre, $description_FR, $date, $lien, $position, $imgCasserole, $posCasserole);
            }


            $file  = '{"generated" : '.time(). ', '."\n";
            $file .= '"doc" : "'.DOC_NAME. '", '."\n";
            $file .= ' "scandales" : [';
            // parcours du tableau contenant tous les scandales
            /* @var $scand Scandale */
            $i = 0; foreach($scandales as $scand) {

                if($i>0)
                    $file .= ','."\n";
                // encode chaque Scandale au format json
                $file .= $scand->json();
                $i ++;
            }
            // affiche le fichier 
            echo $file .= ']}';
            // enregistre le fichier
            file_put_contents("xhr/".DIR_CACHE.DOC_NAME.".json", $file);
        endif;

?>