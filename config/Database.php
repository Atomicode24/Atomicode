<?php
class Database {
    private $host = "localhost"; 
    private $db_name = "bd_fastbuy"; 
    private $username = "root"; 
    private $password = ""; 
    private $conn; 
    
    // Método para obtener la conexión
    public function getConnection() {
        $this->conn = null;
        
        // Usamos el bloque try-catch para capturar posibles excepciones
        try {
            // Crear una nueva conexión a la base de datos
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

            // Verificar si hubo errores en la conexión
            if ($this->conn->connect_error) {
                throw new Exception("Error de conexión: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            // Mostrar el error en caso de fallo
            echo "Error en la conexión: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>
