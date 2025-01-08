<?php
require 'db_connection.php';

class FooterCRUD
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($copyright)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO footers (copyright) VALUES (?)");
            $stmt->execute([$copyright]);
            return true;
        } catch (PDOException $e) {
            echo "Error creating footer: " . $e->getMessage();
            return false;
        }
    }

    public function read()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM footers ORDER BY id DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error reading footers: " . $e->getMessage();
            return [];
        }
    }

    public function update($id, $copyright)
    {
        try {
            $stmt = $this->db->prepare("UPDATE footers SET copyright = ? WHERE id = ?");
            $stmt->execute([$copyright, $id]);
            return true;
        } catch (PDOException $e) {
            echo "Error updating footer: " . $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM footers WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            echo "Error deleting footer: " . $e->getMessage();
            return false;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $crud = new FooterCRUD($pdo);

    $id = $_POST['id'] ?? null;
    $copyright = $_POST['copyright'] ?? null;

    if ($_POST['action'] === 'save') {
        if ($id) {
            $crud->update($id, $copyright);
        } else {
            $crud->create($copyright);
        }
    } elseif ($_POST['action'] === 'delete') {
        $crud->delete($id);
    }

    echo "<script> alert('Success!'); window.location.replace('admins/admin_index.php');</script>";
    exit();
}
