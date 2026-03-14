<?php

require_once __DIR__ . '/../config/database.php';

class Product {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM products ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function read() {
        return $this->getAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO products (name, description, price, category, image, stock_quantity)
            VALUES (:name, :description, :price, :category, :image, :stock_quantity)
        ");
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':stock_quantity', $data['stock_quantity'], PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    public function update($id, $data) {
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            $fields[] = "{$key} = :{$key}";
            $values[$key] = $value;
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $values['id'] = $id;
        $sql = "UPDATE products SET " . implode(', ', $fields) . " WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($values as $key => $value) {
            if ($key === 'stock_quantity') {
                $stmt->bindValue(":{$key}", (int)$value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue(":{$key}", $value);
            }
        }
        
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getCount() {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM products");
        $stmt->execute();
        return $stmt->fetch()['count'];
    }

    public function getByCategory($category) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE category = :category ORDER BY created_at DESC");
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
