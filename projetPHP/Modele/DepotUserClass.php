<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class DepotUserClass Extends Objet{
    //put your code here
    public $db,$DE_No,$Prot_No,$Is_Principal;
    public $table = 'Z_DEPOTUSER';

    function __construct($id,$db=null) {
        parent::__construct($this->table, $id,'Prot_No',$db);

    }

    public function __toString() {
        return "";
    }

    public function getDepotPrincipal($Prot_No){
        $query= "   SELECT	A.DE_No
                            ,DE_Intitule
                            ,IsPrincipal = ISNULL(D.IsPrincipal,0)
                    FROM	F_DEPOT A
                    LEFT JOIN Z_DEPOTUSER D 
                        ON A.DE_No=D.DE_No
                    WHERE	IsPrincipal = 1
                    AND     PROT_No = $Prot_No
                    GROUP BY A.DE_No
                             ,DE_Intitule
                             ,IsPrincipal";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function getDepotUser($Prot_No){
        $query = "BEGIN 
                    DECLARE @admin INT
                    DECLARE @ProtNo INT
                    SET @ProtNo = $Prot_No
                    
                    SELECT @admin = CASE WHEN PROT_Administrator=1 OR PROT_Right=1 THEN 1 ELSE 0 END FROM F_PROTECTIONCIAL WHERE PROT_No = @ProtNo 
                    
                    IF (@admin=0)
                    BEGIN 
                        SELECT	A.DE_No,DE_Intitule,ISNULL(D.IsPrincipal,0)IsPrincipal
                        FROM	F_DEPOT A
                        LEFT JOIN Z_DEPOTUSER D ON A.DE_No=D.DE_No
                        WHERE	(1 = (SELECT CASE WHEN PROT_Administrator=1 OR PROT_Right=1 THEN 1 ELSE 0 END FROM F_PROTECTIONCIAL WHERE PROT_No=@ProtNo) OR D.PROT_No =@ProtNo)
                        AND IsPrincipal = 1
                        GROUP BY A.DE_No,DE_Intitule,IsPrincipal
                    END
                    ELSE 
                    BEGIN 
                        SELECT DE_No,DE_Intitule, 1 as IsPrincipal
                        FROM F_DEPOT 
                    END 
                    END  ";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

}