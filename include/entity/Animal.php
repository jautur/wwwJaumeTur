<?php 
class Animal {
    private int $id;
    private string $nom;
    private string $nomCientific;
    private int $cantitat;
    private int $donacio;
    private string $descripcio;
    private string $image;

    public function __construct(int $id, string $nom, string $nomCientific, int $cantitat, int $donacio, string $descripcio, string $image) {
        $this->id = $id;
        $this->nom = $nom;
        $this->nomCientific = $nomCientific;
        $this->cantitat = $cantitat;
        $this->donacio = $donacio;
        $this->descripcio = $descripcio;
        $this->image = $image;
    }

    public function getId() {
        return $this->id;
    }
    public function getNom() {
        return $this->nom;
    }
    public function getNomCientific() {
        return $this->nomCientific;
    }
    public function getCantitat() {
        return $this->cantitat;
    }
    public function getDonacio() {
        return $this->donacio;
    }
    public function getDescripcio() {
        return $this->descripcio;
    }
    public function getImage() {
        return $this->image;
    }

    public function setId(int $id) {
        $this->id = $id;
    }
    public function setNom(string $nom) {
        $this->nom = $nom;
    }
    public function setNomCientific(string $nomCientific) {
        $this->nomCientific = $nomCientific;
    }
    public function setCantitat(int $cantitat) {
        $this->cantitat = $cantitat;
    }
    public function setDonacio(int $donacio) {
        $this->donacio = $donacio;
    }
    public function setDescripcio(string $descripcio) {
        $this->descripcio = $descripcio;
    }
    public function setImage(string $image) {
        $this->image = $image;
    }

}