<?php

Class Database{
 
	private $server = "mysql:host=localhost;dbname=ecomm";
	private $username = "root";
	private $password = "";
	private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
	protected $conn;
 	
	public function open(){
 		try{
 			$this->conn = new PDO($this->server, $this->username, $this->password, $this->options);
 			return $this->conn;
 		}
 		catch (PDOException $e){
 			echo "il y a un probleme dans la connection: " . $e->getMessage();
 		}
 
    }
 
	public function close(){
   		$this->conn = null;
 	}
 
}

$pdo = new Database();

function envoyer_msg($exp, $dest, $sujet, $contenu){
    $cn=getConnection();
    $dest=get_id_byEmail($dest);
    $req=$cn->exec("INSERT INTO message VALUES('','$exp','$dest','$sujet','$contenu' NOW())"); 
} 
    function get_id_byEmail($email){
        $cn=getConnection(); 
        $req=$cn->query("SELECT id FROM users WHERE login='$email'");
        $resultat=$req->fetchObject();
        return $resultat->idcompte; 
    }

    function get_mail_byid($id){
        $cn=getConnection(); 
        $req=$cn->query("SELECT idMessage, sujet, contenu, expeditaire, dateenvoi, nom, prenom
        FROM message, utilisateur, compte
        WHERE utilisateur .idutilisateur=compte.idutilisateur
        AND compte.idcompte=mnessage.expeditaire
        AND expeditaire='$id'; ");
        $messageEnv=array(); 
        while($resultat=$req->fetchObject()){
            $messageEnv[]=$resultat;
        }
        return $messageEnv; 
    }

    function get_mailrecus_byid($id){
        $cn=getConnection(); 
        $req=$cn->query("SELECT idMessage, sujet, contenu, expeditaire, dateenvoi, nom, prenom
        FROM message, utilisateur, compte
        WHERE utilisateur .idutilisateur=compte.idutilisateur
        AND compte.idcompte=mnessage.expeditaire
        AND expeditaire='$id'; ");
        $messageEnv=array(); 
        while($resultat=$req->fetchObject()){
            $messageEnv[]=$resultat;
        }
        return $messageEnv; 
    }
 
?>