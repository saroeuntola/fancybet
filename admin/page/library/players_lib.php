<?php
class Player
{
    public $db;

    public function __construct()
    {
        $this->db = dbConn(); 
    }
    // Check if player with the same phone exists
    public function getPlayerByPhone($phone)
    {
        $stmt = $this->db->prepare("SELECT * FROM players WHERE phone = ?");
        $stmt->execute([$phone]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // CREATE a new player
    public function createPlayer($name, $phone, $gmail)
{
    $quotedGmail = $this->db->quote($gmail);
    // Check if player with the same gmail exists
    $result = dbSelect('players', 'id', "gmail=$quotedGmail");

    if ($result && count($result) > 0) {
        return false;
    }

    $data = [
        'name' => $name,
        'phone' => $phone,
        'gmail' => $gmail
    ];
    return dbInsert('players', $data);
}


    // READ all players
    public function getPlayers() {
    $query = "SELECT * 
              FROM players 
              ORDER BY id DESC";

    try {
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error fetching players: " . $e->getMessage());
    }
}


    // READ a specific player by ID
    public function getPlayerbyID($id)
    {
        $quotedId = $this->db->quote($id);
        $result = dbSelect('players', '*', "id=$quotedId");

        return ($result && count($result) > 0) ? $result[0] : null;
    }

    // UPDATE a player
    public function updatePlayer($id, $newName, $newPhone, $newGmail)
    {
        $player = $this->getPlayerbyID($id);
        if (!$player) {
            return false; 
        }

        $data = [
            'name' => $newName,
            'phone' => $newPhone,
            'gmail' => $newGmail
        ];
        return dbUpdate('players', $data, "id=" . $this->db->quote($id));
    }

    // DELETE a player
    public function deletePlayer($id)
    {
        $player = $this->getPlayerbyID($id);
        if (!$player) {
            return false;
        }

        return dbDelete('players', "id=" . $this->db->quote($id));
    }

public function getPlayerByGmail($gmail)
{
    try {
        $sql = "SELECT * FROM players WHERE gmail = :gmail LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':gmail', $gmail, PDO::PARAM_STR);
        $stmt->execute();
        $player = $stmt->fetch(PDO::FETCH_ASSOC);
        return $player ?: null;
    } catch (PDOException $e) {
        // You can log error here if needed
        return null;
    }
}

public function updatePlayerBalance($id, $newBalance) {
    $data = ['balance' => $newBalance];
    return dbUpdate('players', $data, "id=" . $this->db->quote($id));
}

// Get balance for a player by ID
public function getBalance($playerId) {
    $sql = "SELECT balance FROM players WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $playerId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['balance'] : 0;
}

// Update balance for a player
public function updateBalance($playerId, $newBalance) {
    $sql = "UPDATE players SET balance = :balance WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':balance', $newBalance);
    $stmt->bindParam(':id', $playerId, PDO::PARAM_INT);
    return $stmt->execute();
}

}
?>
