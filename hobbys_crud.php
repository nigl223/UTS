<?php
require 'db_connection.php';

class HobbyCRUD
{
    private $db;
    private $uploadDir = 'assets/icons/';

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($name, $icon)
    {
        $iconPath = $this->uploadFile($icon);
        if (!$iconPath) {
            return false;
        }

        try {
            $stmt = $this->db->prepare("INSERT INTO hobbys (name, icon) VALUES (?, ?)");
            $stmt->execute([$name, $iconPath]);
            return true;
        } catch (PDOException $e) {
            echo "Error creating hobby: " . $e->getMessage();
            return false;
        }
    }

    public function read()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM hobbys ORDER BY id ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error reading hobbies: " . $e->getMessage();
            return [];
        }
    }

    public function update($id, $name, $icon)
    {
        $hobby = $this->findById($id);
        if (!$hobby) {
            return false;
        }

        $iconPath = $hobby['icon'];
        if (!empty($icon['name'])) {
            $this->deleteFile($iconPath);
            $iconPath = $this->uploadFile($icon);
            if (!$iconPath) {
                return false;
            }
        }

        try {
            $stmt = $this->db->prepare("UPDATE hobbys SET name = ?, icon = ? WHERE id = ?");
            $stmt->execute([$name, $iconPath, $id]);
            return true;
        } catch (PDOException $e) {
            echo "Error updating hobby: " . $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        $hobby = $this->findById($id);
        if (!$hobby) {
            return false;
        }

        $this->deleteFile($hobby['icon']);

        try {
            $stmt = $this->db->prepare("DELETE FROM hobbys WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            echo "Error deleting hobby: " . $e->getMessage();
            return false;
        }
    }

    private function uploadFile($file)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo "File upload error: " . $file['error'];
            return false;
        }

        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $fileExt;
        $filePath = $this->uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return $filePath;
        }

        echo "Failed to move uploaded file.";
        return false;
    }

    private function deleteFile($filePath)
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    private function findById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM hobbys WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error finding hobby: " . $e->getMessage();
            return null;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $crud = new HobbyCRUD($pdo);

    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $icon = $_FILES['icon'] ?? null;

    if ($_POST['action'] === 'save') {
        if ($id) {
            $crud->update($id, $name, $icon);
        } else {
            $crud->create($name, $icon);
        }
    } elseif ($_POST['action'] === 'delete') {
        $crud->delete($id);
    }

    echo "<script> alert('Success!!'); window.location.replace('admins/admin_index.php');</script>";
    exit();
}
