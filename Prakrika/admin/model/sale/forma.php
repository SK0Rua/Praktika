<?php
class ModelSaleForma extends Model {


    public function getFormas($data = array()) {
        $sql = "SELECT forma_id, firstname, email, telephone FROM " . DB_PREFIX . "forma";

        $sort_data = array(
            'forma_id',
            'firstname',
            'email',
            'telephone'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY forma_id";
        }

        if (isset($data['forma']) && ($data['forma'] == 'DESC')) {
            $sql .= " ASC";
        } else {
            $sql .= " DESC";
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }
}
