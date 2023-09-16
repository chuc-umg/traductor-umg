<?php
class M_usuarios
{
    private $conn; // Variable para almacenar la conexión

    public function __construct()
    {
        // Datos de conexión (puedes cambiar estos valores por los tuyos)
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $database = 'traductor';

        // Establecer conexión
        $this->conn = new mysqli($host, $user, $password, $database);

        if ($this->conn->connect_error) {
            die('Error de conexión: ' . $this->conn->connect_error);
        }
    }

    public function agregar()
    {
        $palabraQuiche = $_POST['word_quiche'];
        $traduccionEspañol = $_POST['word_es'];
        $estatus = 0;
        $usuario = 1;
        $sql = "INSERT INTO quichepalabrasfrases (PalabraFraseQuiche, TraduccionEspañol, estatus, UsuarioID) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die('Error al preparar el statement: ' . $this->conn->error);
        }
        $stmt->bind_param('ssii', $palabraQuiche, $traduccionEspañol, $estatus, $usuario);
        if (!$stmt->execute()) {

            echo 'jajaja';
        } else {
            echo "Listo";
        }
        $stmt->close();
    }
    public function ver()
    {
        echo 'jajajja';
    }
    public function traductor()
    {
        $palabra = $_POST['palabra'];
        $ip = $_POST['ip'];
        $ciudad = $_POST['ciudad'];
        $region = $_POST['region'];
        $usuario = 1;
        $sql = "INSERT INTO traductor.consultas (UsuarioID, TextoConsulta, IP , ciudad, region) VALUES (?,?,?,?,?);";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('issss', $usuario, $palabra, $ip, $ciudad, $region);
        if (!$stmt->execute()) {
        } else {
        }
        $stmt->close();
        if ($_POST['idioma'] == '1') {
            $palabraBusqueda = $palabra;
            $sql = "SELECT TraduccionEspañol FROM quichepalabrasfrases WHERE PalabraFraseQuiche LIKE ? and estatus = 1";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                die('Error al preparar el statement: ' . $this->conn->error);
            }
            $stmt->bind_param('s', $palabraBusqueda);
            if (!$stmt->execute()) {
                die('Error al ejecutar el statement: ' . $stmt->error);
            }
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $traducido = $result->fetch_assoc();
                echo $traducido['TraduccionEspañol'];
            } else {
                echo 'No se encontró la palabra';
                $sql = "INSERT INTO traductor.noencontradas (PalabraFrase) VALUES (?);";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param('s',$palabra);
                if (!$stmt->execute()) {
                } else {
                }
            }
            $stmt->close();
        } else {
            $palabraBusqueda = "%" . $palabra . "%";
            $sql = "SELECT PalabraFraseQuiche FROM quichepalabrasfrases WHERE TraduccionEspañol LIKE ? and estatus = 1";
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                die('Error al preparar el statement: ' . $this->conn->error);
            }
            $stmt->bind_param('s', $palabraBusqueda);
            if (!$stmt->execute()) {
                die('Error al ejecutar el statement: ' . $stmt->error);
            }
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $traducido = $result->fetch_assoc();
                echo $traducido['PalabraFraseQuiche'];
            } else {
                echo 'No se encontró la palabra';
                $sql = "INSERT INTO traductor.noencontradas (PalabraFrase) VALUES (?);";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param('s',$palabra);
                if (!$stmt->execute()) {
                } else {
                }
            }
            $stmt->close();
        }
    }
}
