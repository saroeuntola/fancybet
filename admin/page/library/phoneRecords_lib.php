<?php
class phoneRecords
{
    private $db;

    public function __construct()
    {
        // dbConn() should return a PDO instance
        $this->db = dbConn();
    }

    // CREATE a new phone record
    public function create($phone)
    {
        $sql = "INSERT INTO phone_records (phone) VALUES (:phone)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':phone' => $phone
        ]);
    }

    // READ all phone records
    public function getAll()
    {
        $sql = "SELECT * FROM phone_records";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ a specific phone record by ID
    public function getById($id)
    {
        $sql = "SELECT * FROM phone_records WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE a phone record
    public function update($id, $phone)
    {
        $sql = "UPDATE phone_records SET phone = :phone WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':phone' => $phone,
            ':id' => $id
        ]);
    }

    // DELETE a phone record
    public function delete($id)
    {
        $sql = "DELETE FROM phone_records WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
