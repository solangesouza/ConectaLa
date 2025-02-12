<?php
require_once __DIR__ . '../Database.php';
//require __DIR__ . '/db.php';

class UserController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    // 📌 Listar usuários
    public function getUsers($request, $response, $args) {
        $stmt = $this->db->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $response->withJson($users);
    }

    // 📌 Criar usuário
    public function createUser($request, $response, $args) {
        $data = $request->getParsedBody();
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        if ($stmt->execute()) {
            return $response->withJson(["message" => "Usuário criado com sucesso"], 201);
        }
        return $response->withJson(["error" => "Erro ao criar usuário"], 500);
    }

    // 📌 Atualizar usuário
    public function updateUser($request, $response, $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return $response->withJson(["message" => "Usuário atualizado com sucesso"]);
        }
        return $response->withJson(["error" => "Erro ao atualizar usuário"], 500);
    }

    // 📌 Deletar usuário
    public function deleteUser($request, $response, $args) {
        $id = $args['id'];
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return $response->withJson(["message" => "Usuário deletado com sucesso"]);
        }
        return $response->withJson(["error" => "Erro ao deletar usuário"], 500);
    }
}
?>
