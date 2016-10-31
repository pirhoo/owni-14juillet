var canChange = true;
// variable globale: tableau de Scandale
var scandales = new Array();
var ministreActif = -1;
var page = 0;

function Scandale(ministre, description, date, lien, position, imgCasserole, posCasserole) {

    this.index = null;
    this.ministre = ministre;
    this.description = description;
    this.date = date;
    this.lien = lien;
    this.position = position;
    this.imgCasserole = imgCasserole;
    this.posCasserole = posCasserole;

    this.append = function (workspace, index) {

        this.index = index;
    
        // le "togglers" contient l'ensemble des toggler(s)'
        if( $(".togglers", workspace).length == 0 )
             // on le créé dans le workspace s'il n'existe pas déjà
             $(workspace).html("<div class='togglers'></div>" + $(workspace).html() );
         
        // ce contener ne doit pas prendre de place
        $(".togglers", workspace).css({
            height:0,
            width:0
        });
        
        // on insère le toggler dans le togglers...

        $(".togglers", workspace).append("<div id='scandale_"+index+"' class='toggleScandale'><img class='casserole' src='" + this.imgCasserole + "' /></div>");

        // on place le toggler sur le worspace
        var x=this.position.split("x")[0]+"px";
        var y=this.position.split("x")[1]+"px";

        $("#scandale_"+index).css({
            left:x,
            top:y
        });


        // on place la casserole relativement au toggler
        x=this.posCasserole.split("x")[0]+"px";
        y=this.posCasserole.split("x")[1]+"px";

        $(".casserole","#scandale_"+index).css({
            left:x,
            top:y
        });
    }
}

function initScandale(workspace, lang) {
    
    $.ajax({
            url: "./xhr/getGooSpreadsheet.php?lang="+lang,
            success: function(json) {
                // évalue la chaine reçu comme un objet JSON
                json = eval('('+ json +')');

                // pour chaque item du tableau, le convertie en objet Scandale
                for(var i in json.scandales)
                    scandales.push( new Scandale( json.scandales[i].ministre,
                                                  json.scandales[i].description,
                                                  json.scandales[i].date,
                                                  json.scandales[i].lien,
                                                  json.scandales[i].position,
                                                  json.scandales[i].imgCasserole,
                                                  json.scandales[i].posCasserole) );

                // on place et dessinne les scandales sur le workspace
                for(var i in scandales)
                    scandales[i].append(workspace, i);

                
                // on met les évent
                $(".toggleScandale").mousemove(function () {
                    if( ! $(this).hasClass("visible") ) {
                        if(canChange) {
                            canChange = false;
                            $(this).addClass("visible");
                            $(".casserole").stop().hide(0);
                            $(".casserole:eq(0)", $(this)).stop().fadeIn(200)

                            // si un ministre à plusieurs scandales, c'est forcément le dernier qui serra afficher au dessus des autres
                            // par conséquent c'est aussi lui qui déclenchera l'événement au survol de la sourie
                            ministreActif = $(this).attr("id").replace("scandale_", "");
                            page = 0;
                            showScandale(); // page 0, la première page
                        }
                    }
                });

                $(".toggleScandale").mouseleave(function () {
                        if( $(this).hasClass("visible") ) {

                            $(this).removeClass("visible");
                            if(!canChange)
                                setTimeout(function () { canChange = true; } , 200);
                        }
                });


                $(".suiv", ".navigation").click(function () {
                    page ++;
                    showScandale();
                });
                
                $(".prec", ".navigation").click(function () {
                    page --;
                    showScandale();
                });

            }
    });
}


function showScandale() {
    
    // change déjà le nom du ministre dans le viewer
    $(".ministre", ".view").html( scandales[ministreActif].ministre.replace(' ', '<br /><span class="nom">') + "</span>" );

    // ce tableau va contenir tous les scandales du ministre
    var ministreScandales = new Array();
    for(var i in scandales)
        if(scandales[ministreActif].ministre == scandales[i].ministre)
            ministreScandales.push( scandales[i] );

    $(".description", ".view").html(ministreScandales[page].description);
    $(".source", ".view").html("<a href='"+ministreScandales[page].lien+"' target='_blank'>Source</a>");

    // on cache préalablement tous les boutons de navigation
    $("span", ".navigation").hide();

    // Si il y a plus d'une page
    if(ministreScandales.length > 1) {
        // Et qu'on est sur la première, il y a seulement le bouton suivant
        if(page == 0)
            $(".suiv", ".navigation").show();
        // si la page demandée est inférieur au nombre total de page, il y a un bouton suivant
        // si il on demande une page après la première, il y a un bouton précédent
        else if(page < ministreScandales.length-1) {
            $(".prec", ".navigation").show();
            $(".suiv", ".navigation").show();
        // le dernier scénario possible est celui de la dernière page, il y a seulement un bouton précédent
        } else
            $(".prec", ".navigation").show();
    }
    
}