<?php

// Interfaz para archivos
interface FileInterface {
    public function open(): string;
}

// Clase concreta para los archivos antiguos (Windows 7)
class OldFile implements FileInterface {
    public function open(): string {
        return "El archivo se abre usando el formato antiguo de Windows 7.";
    }
}

// Clase concreta para los archivos modernos (Windows 10)
class ModernFile implements FileInterface {
    public function open(): string {
        return "El archivo se abre usando el formato moderno de Windows 10.";
    }
}

// Adaptador para permitir que Windows 10 acepte archivos de Windows 7
class FileAdapter implements FileInterface {
    private $oldFile;

    public function __construct(OldFile $oldFile) {
        $this->oldFile = $oldFile;
    }

    public function open(): string {
        return $this->oldFile->open() . " (convertido para Windows 10).";
    }
}

// Manejo de la solicitud
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['fileType'])) {
        if ($_POST['fileType'] === 'modern') {
            $file = new ModernFile();
            $message = $file->open();
        } elseif ($_POST['fileType'] === 'old') {
            $oldFile = new OldFile();
            $adapter = new FileAdapter($oldFile);
            $message = $adapter->open();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abrir Archivos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Abrir Archivos</h1>

    <form method="post" class="mb-3">
        <div class="form-group">
            <label for="fileType">Selecciona el tipo de archivo:</label><br>
            <button type="submit" name="fileType" value="modern" class="btn btn-primary">Archivo Moderno (Windows 10)</button>
            <button type="submit" name="fileType" value="old" class="btn btn-warning">Archivo Antiguo (Windows 7)</button>
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
