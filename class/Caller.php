<?php
class   Caller {
	
	private $dbh;
	
	public function __construct($host,$username,$pass,$db,$port=3306)	{		
		$this->dbh = new PDO("mysql:host=".$host.";port=".$port.";dbname=".$db,$username,$pass);				
		$this->dbh->exec("SET CHARACTER SET utf8");
	} 

	public function readAll() {				
		$sth = $this->dbh->prepare("SELECT * FROM caller");
		$sth->execute();
		return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
	}

	public function view_readAll() {				
		$sth = $this->dbh->prepare("SELECT * FROM v_caller");
		$sth->execute();
		return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
	}

	public function read($obj) {
		$sth = $this->dbh->prepare("SELECT * FROM caller WHERE id=?");
		$sth->execute(array($obj->id));		
		return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
		
	}

	public function create($obj) {		
		$sth = $this->dbh->prepare("INSERT INTO caller (id,nom,prenom,tel,email,rang,experiance,region,pays,profil,ID_type_prestataire,ID_diplome,ID_ville,ID_langue,ID_categorie,ID_sous_categorie,ID_utilisateur,ID_statut,ID_disponibilite,date_creation) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
		$sth->execute(array($obj->id,$obj->nom,$obj->prenom,$obj->tel,$obj->email,$obj->rang,$obj->experiance,$obj->region,$obj->pays,$obj->profil,$obj->ID_type_prestataire,$obj->ID_diplome,$obj->ID_ville,$obj->ID_langue,$obj->ID_categorie,$obj->ID_sous_categorie,$obj->ID_utilisateur,$obj->ID_statut,$obj->ID_disponibilite,$obj->date_creation));	
		//$sth->execute(array($obj->dlRate, $obj->ulRate, $obj->time, $obj->cpe_id));		
		return json_encode($this->dbh->lastInsertId());
	}

	public function update($obj) {		
		$sth = $this->dbh->prepare("UPDATE caller SET id = IF(? = NULL, id , ?), nom = IF(? = NULL, nom , ?), prenom = IF(? = NULL, prenom , ?), tel = IF(? = NULL, tel , ?), email = IF(? = NULL, email , ?), rang = IF(? = NULL, rang , ?), experiance = IF(? = NULL, experiance , ?), region = IF(? = NULL, region , ?), pays = IF(? = NULL, pays , ?), profil = IF(? = NULL, profil , ?), ID_type_prestataire = IF(? = NULL, ID_type_prestataire , ?), ID_diplome = IF(? = NULL, ID_diplome , ?), ID_ville = IF(? = NULL, ID_ville , ?), ID_langue = IF(? = NULL, ID_langue , ?), ID_categorie = IF(? = NULL, ID_categorie , ?), ID_sous_categorie = IF(? = NULL, ID_sous_categorie , ?), ID_utilisateur = IF(? = NULL, ID_utilisateur , ?), ID_statut = IF(? = NULL, ID_statut , ?), ID_disponibilite = IF(? = NULL, ID_disponibilite , ?), cv_link = IF(? = NULL, cv_link , ?), ref_link = IF(? = NULL, ref_link , ?), date_creation = IF(? = NULL, date_creation , ?) WHERE id=?");
		$sth->execute(array($obj->id,$obj->id,$obj->nom,$obj->nom,$obj->prenom,$obj->prenom,$obj->tel,$obj->tel,$obj->email,$obj->email,$obj->rang,$obj->rang,$obj->experiance,$obj->experiance,$obj->region,$obj->region,$obj->pays,$obj->pays,$obj->profil,$obj->profil,$obj->ID_type_prestataire,$obj->ID_type_prestataire,$obj->ID_diplome,$obj->ID_diplome,$obj->ID_ville,$obj->ID_ville,$obj->ID_langue,$obj->ID_langue,$obj->ID_categorie,$obj->ID_categorie,$obj->ID_sous_categorie,$obj->ID_sous_categorie,$obj->ID_utilisateur,$obj->ID_utilisateur,$obj->ID_statut,$obj->ID_statut,$obj->ID_disponibilite,$obj->ID_disponibilite, $obj->cv_link,$obj->cv_link, $obj->ref_link,$obj->ref_link, $obj->date_creation,$obj->date_creation,$obj->id));
		return json_encode(1);
	}
	
	public function delete($obj) {				
		$sth = $this->dbh->prepare("DELETE FROM caller WHERE id=?");
		$sth->execute(array($obj->id));
		return json_encode(1);
	}
}
?>