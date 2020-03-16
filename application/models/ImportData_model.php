<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class ImportData_model extends CI_Model
{
    public $table = 'barang';
    public $id = 'idBarang';
    
    function __construct(){
        parent::__construct();
    }
    
    function getByKodeBarang($kodeBarang){
        $this->db->from($this->table);
        $this->db->where('kodeBarang', $kodeBarang);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function insertBarang($data){
        foreach($data as $dat){
            if($this->getByKodeBarang($dat["kodeBarang"]) === 0){
                $this->db->insert($this->table,$dat);
            }
        }
    }
    function insertBarangBatch($data){
        $this->db->insert_batch($this->table,$data);
    }
    function insertHeaderTransaksi($data){
        $this->db->insert_batch('transaksi',$data);
    }
    function insertDetailTransaksi($data){
        $this->db->insert_batch('detailtransaksi',$data);
    }

}