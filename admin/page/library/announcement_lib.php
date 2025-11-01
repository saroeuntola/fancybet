<?php
class Announcement
{
    private $db;

    public function __construct()
    {
        $this->db = dbConn(); 
    }

    // CREATE a new announcement (EN + BN)
    public function createAnnouncement($message, $message_bn = null, $link = null)
    {
        $data = [
            'message'    => $message,     // English
            'message_bn' => $message_bn,  // Bengali
            'link'       => $link,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return dbInsert('announcements', $data);
    }

    // READ all announcements (with language filter)
    public function getAnnouncements($lang = 'en')
    {
        // Validate language
        $lang = in_array($lang, ['en', 'bn']) ? $lang : 'en';

        // Select language-specific field
        $message_field = $lang === 'en' ? 'message' : 'message_bn';

        $query = "SELECT id, $message_field AS message, link, created_at, updated_at
                  FROM announcements
                  ORDER BY created_at DESC";

        try {
            $stmt = $this->db->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching announcements: " . $e->getMessage());
            return [];
        }
    }

    // READ a specific announcement by ID (with language filter)
    public function getAnnouncementByID($id, $lang = 'en')
    {
        $lang = in_array($lang, ['en', 'bn']) ? $lang : 'en';
        $message_field = $lang === 'en' ? 'message' : 'message_bn';

        $query = "SELECT id, $message_field AS message, link, created_at, updated_at
                  FROM announcements
                  WHERE id = " . $this->db->quote($id);

        try {
            $stmt = $this->db->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $e) {
            error_log("Error fetching announcement by ID: " . $e->getMessage());
            return null;
        }
    }

    // UPDATE an announcement (EN + BN)
    public function updateAnnouncement($id, $message, $message_bn = null, $link = null)
    {
        // Ensure announcement exists
        if (!$this->getAnnouncementByID($id)) {
            return false;
        }

        $data = [
            'message'    => $message,
            'message_bn' => $message_bn,
            'link'       => $link,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return dbUpdate('announcements', $data, "id=" . $this->db->quote($id));
    }

    // DELETE an announcement
    public function deleteAnnouncement($id)
    {
        // Ensure announcement exists
        if (!$this->getAnnouncementByID($id)) {
            return false;
        }

        return dbDelete('announcements', "id=" . $this->db->quote($id));
    }
}
?>
