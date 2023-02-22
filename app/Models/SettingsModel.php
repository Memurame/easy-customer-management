<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table            = 'settings';
    protected $db;
    protected $allowedFields        = [
        "key",
        "value"
    ];

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function write($k, $v)
    {
        $key = $this->db->table($this->table)->getWhere(['key' => $k]);
        if($key->getResultArray()){
            $this->db->table($this->table)->update(['value' => $v], array(
                "key" => $k,
            ));
        } else {
            $this->db->table($this->table)->insert([
                'key' => $k,
                'value' => $v
            ]);
        }
        return $this->db->insertID();
    }

    public function read($k)
    {
        $key = $this->db->table($this->table)->getWhere(['key' => $k]);
        return $key->getFirstRow()->value;
    }
}