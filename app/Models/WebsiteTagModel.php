<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\WebsiteTag;

class WebsiteTagModel extends Model
{

    public $table = 'websites_tags';
    protected $db;
    protected $allowedFields = [
        "tag_id",
        "website_id"
    ];

    protected $primaryKey = 'tag_id';
    protected $useAutoIncrement = false;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $returnType = WebsiteTag::class;
    protected $useSoftDeletes = true;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function addTagToWebsite($tagId, $websiteId){
        
        $data = [
            'tag_id'  => (int) $tagId,
            'website_id' => (int) $websiteId
        ];

        return (bool) $this->db->table('websites_tags')->insert($data);
    }

    public function removeAllTagsFromWebsite($websiteId){

        return (bool) $this->db->table('websites_tags')->where('website_id', $websiteId)->delete();
    }

    public function getTagsForWebsite($websiteId){

        $found = $this->builder()
                ->select('websites_tags.*, taglist.name, taglist.class')
                ->join('taglist', 'taglist.id = websites_tags.tag_id', 'left')
                ->where('websites_tags.website_id', $websiteId)
                ->get()->getResultArray();
                
        return $found;
    }

    public function checkWebsiteTag($websiteId, $tagId){

        $found = $this->builder()
                ->select('tag_id')
                ->where('website_id', $websiteId)
                ->where('tag_id', $tagId)
                ->get()->getResultArray();
                
        return (bool) $found;
    }

}