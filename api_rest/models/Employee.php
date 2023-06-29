<?php
class Employee {
    // Connexion
    private $connexion;
    private $table = "employee";

    // object properties
    public $id;
    public $name;
    public $email;
    public $age;
    public $designation;
    public $created;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    /**
     * Lecture des employees
     *
     * @return void
     */
    public function lire(){
        // On écrit la requête
        $sql = "SELECT * FROM " . $this->table;

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    /**
     * Créer un employee
     *
     * @return void
     */
    public function creer(){

        // Ecriture de la requête SQL en y insérant le name de la table
        $sql = "INSERT INTO " . $this->table . " SET name=:name, age=:age, email=:email, id=:id, designation=:designation, crated=:created";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->age=htmlspecialchars(strip_tags($this->age));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->designation=htmlspecialchars(strip_tags($this->designation));
        $this->created=htmlspecialchars(strip_tags($this->created));

        // Ajout des données protégées
        $query->bindParam(":name", $this->name);
        $query->bindParam(":age", $this->age);
        $query->bindParam(":email", $this->email);
        $query->bindParam(":id", $this->id);
        $query->bindParam(":designation", $this->designation);
        $query->bindParam(":created", $this->created);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }

    /**
     * Lire un employee
     *
     * @return void
     */
    public function lireUn(){
        // On écrit la requête
        $sql = "SELECT * FROM Employee";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On attache l'id
        $query->bindParam(1, $this->id);

        // On exécute la requête
        $query->execute();

        // on récupère la ligne
        $row = $query->fetch(PDO::FETCH_ASSOC);

        // On hydrate l'objet
        $this->name = $row['name'];
        $this->age = $row['age'];
        $this->email = $row['email'];
        $this->id = $row['id'];
        $this->designation = $row['designation'];
        $this->created = $row['created'];
    }

    /**
     * Supprimer un employee
     *
     * @return void
     */
    public function supprimer(){
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE id = ?";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On sécurise les données
        $this->id=htmlspecialchars(strip_tags($this->id));

        // On attache l'id
        $query->bindParam(1, $this->id);

        // On exécute la requête
        if($query->execute()){
            return true;
        }
        
        return false;
    }

    /**
     * Mettre à jour un employee
     *
     * @return void
     */
    public function modifier(){
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET name = :name, age = :age, email = :email, id = :id, designation = :designation, created = :created WHERE id = :id";
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        
        // On sécurise les données
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->age=htmlspecialchars(strip_tags($this->age));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->designation=htmlspecialchars(strip_tags($this->designation));
        $this->created=htmlspecialchars(strip_tags($this->created));

        // On attache les variables
        $query->bindParam(':name', $this->name);
        $query->bindParam(':age', $this->age);
        $query->bindParam(':email', $this->email);
        $query->bindParam(':id', $this->id);
        $query->bindParam(':designation', $this->designation);
        $query->bindParam(':created', $this->created);

        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }

}