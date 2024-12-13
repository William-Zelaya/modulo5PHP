<?php

// Interfaz para las estrategias de salida
interface OutputStrategy {
    public function output(string $message): void;
}

// Clase concreta para la salida en consola
class ConsoleOutput implements OutputStrategy {
    public function output(string $message): void {
        echo "Consola: " . $message . "<br>";
    }
}

// Clase concreta para la salida en formato JSON
class JsonOutput implements OutputStrategy {
    public function output(string $message): void {
        echo json_encode(["message" => $message]) . "<br>";
    }
}

// Clase concreta para la salida en archivo TXT
class FileOutput implements OutputStrategy {
    private $filename;

    public function __construct(string $filename) {
        $this->filename = $filename;
    }

    public function output(string $message): void {
        file_put_contents($this->filename, $message . PHP_EOL, FILE_APPEND);
        echo "Archivo: Mensaje guardado en " . $this->filename . "<br>";
    }
}

// Clase que utiliza la estrategia de salida
class MessageSender {
    private $outputStrategy;

    public function __construct(OutputStrategy $outputStrategy) {
        $this->outputStrategy = $outputStrategy;
    }

    public function setOutputStrategy(OutputStrategy $outputStrategy): void {
        $this->outputStrategy = $outputStrategy;
    }

    public function sendMessage(string $message): void {
        $this->outputStrategy->output($message);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salida de Mensajes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Enviar Mensajes</h1>

    <form method="post">
        <div class="form-group">
            <label for="message">Mensaje:</label>
            <input type="text" class="form-control" id="message" name="message" required>
        </div>
        <div class="form-group">
            <label for="outputType">Tipo de Salida:</label>
            <select class="form-control" id="outputType" name="outputType" required>
                <option value="console">Consola</option>
                <option value="json">JSON</option>
                <option value="file">Archivo TXT</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $message = $_POST['message'];
        $outputType = $_POST['outputType'];

        // Crear la estrategia adecuada según la selección del usuario
        switch ($outputType) {
            case 'console':
                $strategy = new ConsoleOutput();
                break;
            case 'json':
                $strategy = new JsonOutput();
                break;
            case 'file':
                $strategy = new FileOutput('messages.txt');
                break;
            default:
                throw new Exception("Tipo de salida no válido.");
        }

        // Enviar el mensaje usando la estrategia seleccionada
        $messageSender = new MessageSender($strategy);
        $messageSender->sendMessage($message);
    }
    ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
