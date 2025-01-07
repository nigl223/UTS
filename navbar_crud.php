<?php
require 'db_connection.php';

class NavbarCRUD
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($name, $section)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO navbar (name, section) VALUES (?, ?)");
            $stmt->execute([$name, $section]);
            return true;
        } catch (PDOException $e) {
            echo "Error creating navbar: " . $e->getMessage();
            return false;
        }
    }

    public function read()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM navbar ORDER BY id DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error reading navbar: " . $e->getMessage();
            return [];
        }
    }

    public function update($id, $name, $section)
    {
        try {
            $stmt = $this->db->prepare("UPDATE navbar SET name = ?, section = ? WHERE id = ?");
            $stmt->execute([$name, $section, $id]);
            return true;
        } catch (PDOException $e) {
            echo "Error updating navbar: " . $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM navbar WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            echo "Error deleting navbar: " . $e->getMessage();
            return false;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $crud = new NavbarCRUD($pdo);

    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $section = $_POST['section'] ?? null;

    if ($_POST['action'] === 'save') {
        if ($id) {
            $crud->update($id, $name, $section);
        } else {
            $crud->create($name, $section);
        }
    } elseif ($_POST['action'] === 'delete') {
        $crud->delete($id);
    }

    echo "<script> alert('Success!!'); window.location.replace('admins/index.php');</script>";
    exit();
}
