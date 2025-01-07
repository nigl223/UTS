<?php
require 'db_connection.php';

class SectionCRUD
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createItem($section_id, $label, $value)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO section_items (section_id, label, value) VALUES (?, ?, ?)");
            $stmt->execute([$section_id, $label, $value]);
        } catch (PDOException $e) {
            echo "Error creating section item: " . $e->getMessage();
        }
    }

    public function getNavbarOptions()
    {
        try {
            $stmt = $this->pdo->query("SELECT id, name FROM navbar ORDER BY name");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching navbar options: " . $e->getMessage();
            return [];
        }
    }

    public function read()
    {
        try {
            $stmt = $this->pdo->query("SELECT si.id, si.label, si.value, n.name AS section_name, n.id AS id_navbar
                                       FROM section_items si 
                                       JOIN navbar n ON si.section_id = n.id 
                                       ORDER BY si.id ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error reading section items: " . $e->getMessage();
            return [];
        }
    }

    public function readItems($section_id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM section_items WHERE section_id = :section_id");
            $stmt->execute(['section_id' => $section_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error reading section items: " . $e->getMessage();
            return [];
        }
    }

    public function updateItem($id, $section_id, $label, $value)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE section_items SET section_id = ?, label = ?, value = ? WHERE id = ?");
            $stmt->execute([$section_id, $label, $value, $id]);
        } catch (PDOException $e) {
            echo "Error updating section item: " . $e->getMessage();
        }
    }

    public function deleteItem($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM section_items WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo "Error deleting section item: " . $e->getMessage();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sectionCRUD = new SectionCRUD($pdo);

    $id = $_POST['id'] ?? null;
    $section_id = $_POST['section_id'] ?? null;
    $label = $_POST['label'] ?? null;
    $value = $_POST['value'] ?? null;

    if ($_POST['action'] === 'save') {
        if ($id) {
            $sectionCRUD->updateItem($id, $section_id, $label, $value);
        } else {
            $sectionCRUD->createItem($section_id, $label, $value);
        }
    } elseif ($_POST['action'] === 'delete') {
        $sectionCRUD->deleteItem($id);
    }

    echo "<script>alert('Success!!'); window.location = 'admins/index.php';</script>";
    exit;
}
