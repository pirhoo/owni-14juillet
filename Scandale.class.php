<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Scandale
 *
 * @author pirhoo
 */
class Scandale {

    private $ministre;
    private $description_FR;
    private $date;
    private $lien;
    private $position;
    private $imgCasserole;
    private $posCasserole;
    
    public function Scandale($ministre = "", $description_FR = "", $date = "", $lien = "", $position = "", $imgCasserole = "", $posCasserole = "") {
        $this->ministre = $ministre;
        $this->description_FR = $description_FR;
        $this->date = $date;
        $this->lien = $lien;
        $this->position = $position;
        $this->imgCasserole = $imgCasserole;
        $this->posCasserole = $posCasserole;
    }

    public function json() {
        $json = "{'ministre' : '".htmlspecialchars($this->ministre, ENT_QUOTES)."', \n";;
        $json .= "'description' : '".htmlspecialchars($this->description_FR, ENT_QUOTES)."', \n";
        $json .= "'date' : '".htmlspecialchars($this->date, ENT_QUOTES)."', \n";
        $json .= "'lien' : '".htmlspecialchars($this->lien, ENT_QUOTES)."', \n";
        $json .= "'position' : '".htmlspecialchars($this->position, ENT_QUOTES)."', \n";
        $json .= "'imgCasserole' : '".htmlspecialchars($this->imgCasserole, ENT_QUOTES)."', \n";
        $json .= "'posCasserole' : '".htmlspecialchars($this->posCasserole, ENT_QUOTES)."' }";

        return $json;
    }

    public function getMinistre() {
        return $this->ministre;
    }

    public function setMinistre($ministre) {
        $this->ministre = $ministre;
    }

    public function getDescription_FR() {
        return $this->description_FR;
    }

    public function setDescription_FR($description_FR) {
        $this->description_FR = $description_FR;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getLien() {
        return $this->lien;
    }

    public function setLien($lien) {
        $this->lien = $lien;
    }


}
?>
