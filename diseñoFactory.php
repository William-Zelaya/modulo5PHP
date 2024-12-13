<?php
// Interfaz para los personajes
interface Character {
    public function attack(): string;
    public function speed(): string;
}

// Clase concreta para el personaje "Esqueleto"
class Skeleton implements Character {
    public function attack(): string {
        return "El Esqueleto ataca con flechas.";
    }

    public function speed(): string {
        return "El Esqueleto tiene una velocidad media.";
    }
}

// Clase concreta para el personaje "Zombi"
class Zombie implements Character {
    public function attack(): string {
        return "El Zombi ataca con golpes fuertes.";
    }

    public function speed(): string {
        return "El Zombi tiene una velocidad lenta.";
    }
}

// Clase Factory para la creación de personajes
class CharacterFactory {
    public static function createCharacter(string $level): Character {
        switch (strtolower($level)) {
            case 'facil':
                return new Skeleton();
            case 'dificil':
                return new Zombie();
            default:
                throw new Exception("Nivel de juego no válido. Usa 'facil' o 'dificil'.");
        }
    }
}

// Manejo de la solicitud
$character = null;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $level = $_POST['level'];
        $character = CharacterFactory::createCharacter($level);
        $message = $character->attack() . "<br>" . $character->speed();
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Personajes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Selecciona un Personaje</h1>
    
    <form method="post">
        <div class="form-group">
            <button type="submit" name="level" value="facil" class="btn btn-primary">Fácil</button>
            <button type="submit" name="level" value="dificil" class="btn btn-danger">Difícil</button>
        </div>
    </form>

    <?php if ($message): ?>
        <div class="alert alert-info mt-3">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
