<?php
namespace application\models;

use system\basic\BaseModel;

class Leptaden extends BaseModel
{
    public function getContent()
    {
		$rows = $this->db->fetchAll($this->db->getQueryBuilder()->from('content'));
		$content = array();
		if ($rows) {
			foreach ($rows as $row) {
				$content[$row['section']] = array(
                                                'alias' => $row['alias'],
                                                'text' => $row['text'],
                                                'title' => $row['title'],
                                            );
			}
		}
		return $content;
    }
}