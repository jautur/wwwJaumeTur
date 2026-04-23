<?php 
class CarretCompra {
    private string $usuariId;
    private array $llistaAnimals = [];

    public function __construct(string $usuariId) {
        $this->usuariId = $usuariId;
        $this->llistaAnimals = [];
    }

    public function getUsuariId(): string {
        return $this->usuariId;
    }

    public function getLlistaAnimals(): array {
        return $this->llistaAnimals;
    }

    public function setUsuariId(string $usuariId): void {
        $this->usuariId = $usuariId;
    }

    public function setLlistaAnimals(array $llistaAnimals): void {
        $this->llistaAnimals = $llistaAnimals;
    }

    public function afegirAnimal(Animal $animal): void {
        $animalExisteix = false;

        foreach ($this->llistaAnimals as $animalDelCarret) {
            if ($animalDelCarret->getId() === $animal->getId()) {
                    $cantitatActual = $animalDelCarret->getCantitat();
                    $cantitatNova = $cantitatActual + $animal->getCantitat();
                    $animalDelCarret->setCantitat($cantitatNova);
                    $animalExisteix = true;
                    break;
            }
        }

        if (!$animalExisteix) {
            $this->llistaAnimals[] = $animal;
        }
    }

    public function eliminarAnimal(int $idAnimal): void {
        foreach ($this->llistaAnimals as $key => $animal) {
            if ($animal->getId() === $idAnimal) {
                unset($this->llistaAnimals[$key]);
                break;
            }
        }
    }

    public function getAnimal(int $idAnimal): ?Animal {
        foreach ($this->llistaAnimals as $animal) {
            if ($animal->getId() === $idAnimal) {
                return $animal;
            }
        }
        return null;
    }

    public function actualitzarCantitat(int $idAnimal, int $novaCantitat): void {
        foreach ($this->llistaAnimals as $animal) {
            if ($animal->getId() === $idAnimal) {
                $animal->setCantitat($novaCantitat);
                break;
            }
        }
    }

    public function canviarQuantitatAnimal(int $idAnimal, int $novaCantitat): void {
        $this->actualitzarCantitat($idAnimal, $novaCantitat);
    }

    public function buidarCarret(): void {
        $this->llistaAnimals = [];
    }

    public function mostrarCarret(): void {
        foreach ($this->llistaAnimals as $animal) {
            echo "--- ID: " . $animal->getId(); 
            echo "--- Animal: " . $animal->getNom();
            echo "--- Nom Científic: " . $animal->getNomCientific();
            echo "--- Descripció: " . $animal->getDescripcio();   
            echo "--- Cantitat: " . $animal->getCantitat(); 
            echo "--- Donació per unitat: " . $animal->getDonacio() . "€<br>";
        }
    }


}