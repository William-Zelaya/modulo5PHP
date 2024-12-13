<?php

// Interfaz para los personajes
interface Character {
    public function getDescription(): string;
    public function attack(): string;
    public function speed(): string;
}

// Clase concreta para el personaje "Guerrero"
class Warrior implements Character {
    public function getDescription(): string {
        return "Guerrero básico";
    }

    public function attack(): string {
        return "Ataca con fuerza bruta.";
    }

    public function speed(): string {
        return "Velocidad media.";
    }
}

// Clase concreta para el personaje "Mago"
class Mage implements Character {
    public function getDescription(): string {
        return "Mago básico";
    }

    public function attack(): string {
        return "Ataca con hechizos mágicos.";
    }

    public function speed(): string {
        return "Velocidad baja.";
    }
}

// Clase decoradora abstracta
abstract class WeaponDecorator implements Character {
    protected $character;

    public function __construct(Character $character) {
        $this->character = $character;
    }

    public function getDescription(): string {
        return $this->character->getDescription();
    }

    public function attack(): string {
        return $this->character->attack();
    }

    public function speed(): string {
        return $this->character->speed();
    }
}

// Decorador concreto para añadir una espada
class SwordDecorator extends WeaponDecorator {
    public function getDescription(): string {
        return $this->character->getDescription() . " con una espada";
    }

    public function attack(): string {
        return $this->character->attack() . " usando una espada";
    }
}

// Decorador concreto para añadir un arco
class BowDecorator extends WeaponDecorator {
    public function getDescription(): string {
        return $this->character->getDescription() . " con un arco";
    }

    public function attack(): string {
        return $this->character->attack() . " usando un arco";
    }
}

// Decorador concreto para añadir una varita mágica
class WandDecorator extends WeaponDecorator {
    public function getDescription(): string {
        return $this->character->getDescription() . " con una varita mágica";
    }

    public function attack(): string {
        return $this->character->attack() . " usando una varita mágica";
    }
}

// Ejemplo de uso
$characters = [];

// Crear personajes básicos
$warrior = new Warrior();
$mage = new Mage();

// Añadir armas a los personajes
$armedWarrior = new SwordDecorator($warrior);
$archerWarrior = new BowDecorator($warrior);
$armedMage = new WandDecorator($mage);

// Agregar personajes a la lista
$characters[] = $warrior;
$characters[] = $armedWarrior;
$characters[] = $archerWarrior;
$characters[] = $mage;
$characters[] = $armedMage;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personajes del Juego</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Descripción de Personajes</h1>

    <?php foreach ($characters as $character): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?php echo $character->getDescription(); ?></h5>
                <p class="card-text"><strong>Ataque:</strong> <?php echo $character->attack(); ?></p>
                <p class="card-text"><strong>Velocidad:</strong> <?php echo $character->speed(); ?></p>
            </div>
        </div>
    <?php endforeach; ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
