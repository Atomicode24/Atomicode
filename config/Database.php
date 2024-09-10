<?php
class Database {
    // Propiedades privadas para almacenar los detalles de conexión a la base de datos.
    private $host = "127.0.0.1"; // Dirección del host de la base de datos.
    private $db_name = "tienda_ropa2"; // Nombre de la base de datos.
    private $username = "root"; // Nombre de usuario para la conexión a la base de datos.
    private $password = ""; // Contraseña para la conexión a la base de datos.
    private $conn; // Variable para almacenar la conexión a la base de datos.

    // Método público para obtener la conexión a la base de datos.
    public function getConnection() {
        // Inicializar la conexión como nula.
        $this->conn = null;
        try {
            // Intentar establecer la conexión a la base de datos utilizando mysqli.
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        } catch (Exception $e) {
            // Capturar cualquier excepción que ocurra y mostrar un mensaje de error.
            echo "Error en la conexión: " . $e->getMessage();
        }

        // Retornar la conexión a la base de datos (puede ser nula si hubo un error).
        return $this->conn;
    }
}
?>