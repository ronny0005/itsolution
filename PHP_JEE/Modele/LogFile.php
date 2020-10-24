<?php

class LogFile
{
    public $filename = 'log.csv';
    public $fh,$user;
    function __construct()
    {
        if (file_exists($this->filename)) {
            $this->fh = fopen($this->filename, 'a');
        } else {
            $this->fh = fopen($this->filename, 'w');
            fwrite($this->fh, 'Action;Type;DoType;DoEntete;DE_No;DoDomaine;AR_Ref;Qte;Prix;Remise;Montant;Date;User');
        }
    }

    function writeFacture($Action,$DoType,$DoEntete,$DE_No,$DoDomaine,$AR_Ref,$Qte,$Prix,$Remise,$Montant){
        $Type="";
        if($DoDomaine==0){
            if($DoType==0)
                $Type="Devis";
            if($DoType==6)
                $Type="Vente";
            if($DoType==7)
                $Type="Vente Comptabilisée";
        }
        if($DoDomaine==1){
            if($DoType==12)
                $Type="AchatPrecommande";
            if($DoType==16)
                $Type="Achat";
            if($DoType==17)
                $Type="Achat comptabilisé";
        }
        fwrite($this->fh, "\n$Action;$Type;$DoType;$DoEntete;$DE_No;$DoDomaine;$AR_Ref;$Qte;$Prix;$Remise;$Montant;".(new DateTime())->format('Y-m-d H:i:s').";{$this->user}");
        $this->close ();
    }

    function writeReglement($Montant){

        fwrite($this->fh, "\nRèglement;;;;;;;;;;$Montant;".(new DateTime())->format('Y-m-d H:i:s').";{$this->user}");
        $this->close ();
    }

    function writeStock($Type,$AR_Ref,$DE_No,$Qte,$Montant){
        fwrite($this->fh, "\n$Type;Artstock;;;$DE_No;;$AR_Ref;$Qte;;;$Montant;".(new DateTime())->format('Y-m-d H:i:s').";{$this->user}");
        $this->close ();
    }

    function close (){
        fclose($this->fh);
        chmod($this->filename, 0777);
    }

}