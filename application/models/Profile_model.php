<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Profile_model extends CI_Model
{
    public $table = 'admin';
    public $id = 'idAdmin';
    public $order = array('kodeBarang' => 'asc');

    // Konstructor
    function __construct(){
        parent::__construct();
    }

    
    function getAll(){
        return $this->db->get($this->table)->result();
    }
    function getById($id){
        $this->db->from($this->table);
        $this->db->where($this->id,$id);
        $query = $this->db->get();
        return $query->row();
    }
    function getByKodeBarang($kd){
        $this->db->from($this->table);
        $this->db->where("kodeBarang",$kd);
        $query = $this->db->get();
        return $query->row();
    }
    function update($id, $data){
        $this->db->update($this->table, $data, $id);
        return $this->db->affected_rows();
    }
    function deleteById($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}