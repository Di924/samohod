<?php

namespace lib;

use PDO;

class Db
{
    public $db;

    public function __construct() {
        $config = require_once("../config/db.php");
        $this->db = new PDO($config['dsn'], $config['username'], $config['password']);
    }

    public function query($sql, $params = []) // По логике должно быть приватным. Вроде бы.
    {
        $stmt = $this->db->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
        }

        $stmt->execute();

        return $stmt;
    }

    public function row($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
}

?>