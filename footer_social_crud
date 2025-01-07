<?php
require 'db_connection.php';

class FooterSocialCRUD
{
    private $db;
    private $uploadDir = 'assets/icons/';

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($footer_id, $name, $link, $icon)
    {
        $iconPath = $this->uploadFile($icon);
        if (!$iconPath) {
            return false;
        }

        try {
            $stmt = $this->db->prepare("INSERT INTO footer_socials (footer_id, name, link, icon) VALUES (?, ?, ?, ?)");
            $stmt->execute([$footer_id, $name, $link, $iconPath]);
            return true;
        } catch (PDOException $e) {
            echo "Error creating footer social: " . $e->getMessage();
            return false;
        }
    }

    public function getFooterOptions()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM footers ORDER BY id");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching footer options: " . $e->getMessage();
            return [];
        }
    }

    public function readSocials()
    {
        try {
            $stmt = $this->db->prepare("
            SELECT fs.id, fs.footer_id, f.copyright AS copyright, fs.name, fs.link, fs.icon
            FROM footer_socials fs
            LEFT JOIN footers f ON fs.footer_id = f.id
            ORDER BY fs.id ASC
        ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error reading footer socials: " . $e->getMessage();
            return [];
        }
    }

    public function readSocial($footer_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM footer_socials WHERE footer_id = ? ORDER BY id ASC");
            $stmt->execute([$footer_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error reading footer socials: " . $e->getMessage();
            return [];
        }
    }

    public function update($id, $footer_id, $name, $link, $icon)
    {
        $footerSocial = $this->findById($id);
        if (!$footerSocial) {
            return false;
        }

        $iconPath = $footerSocial['icon'];
        if (!empty($icon['name'])) {
            $this->deleteFile($iconPath);
            $iconPath = $this->uploadFile($icon);
            if (!$iconPath) {
                return false;
            }
        }

        try {
            $stmt = $this->db->prepare("UPDATE footer_socials SET footer_id = ?, name = ?, link = ?, icon = ? WHERE id = ?");
            $stmt->execute([$footer_id, $name, $link, $iconPath, $id]);
            return true;
        } catch (PDOException $e) {
            echo "Error updating footer social: " . $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        $footerSocial = $this->findById($id);
        if (!$footerSocial) {
            return false;
        }

        $this->deleteFile($footerSocial['icon']);

        try {
            $stmt = $this->db->prepare("DELETE FROM footer_socials WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            echo "Error deleting footer social: " . $e->getMessage();
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
            $stmt = $this->db->prepare("SELECT * FROM footer_socials WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error finding footer social: " . $e->getMessage();
            return null;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $crud = new FooterSocialCRUD($pdo);

    $id = $_POST['id'] ?? null;
    $footer_id = $_POST['footer_id'] ?? null;
    $name = $_POST['name'] ?? null;
    $link = $_POST['link'] ?? null;
    $icon = $_FILES['icon'] ?? null;

    if ($_POST['action'] === 'save') {
        if ($id) {
            $crud->update($id, $footer_id, $name, $link, $icon);
        } else {
            $crud->create($footer_id, $name, $link, $icon);
        }
    } elseif ($_POST['action'] === 'delete') {
        $crud->delete($id);
    }

    echo "<script> alert('Success!'); window.location.replace('admins/index.php');</script>";
    exit();
}
