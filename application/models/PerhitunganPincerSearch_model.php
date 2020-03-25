<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class PerhitunganPincerSearch_model extends CI_Model
{
    // Konstructor
    function __construct(){
        parent::__construct();
    }
    function getAll(){
        return $this->db->get('barang')->result();
    }
    function getDetailTransactionByDate($tglawal, $tglakhir){
        $this->db->select('noInvoice,kodeBarang');
        $this->db->from('detailtransaksi');
        $this->db->where('tanggal >=',$tglawal);
        $this->db->where('tanggal <=',$tglakhir);
        $detailTransaksiByDate = $this->db->get()->result();
        return $detailTransaksiByDate;
    }
    function get_datatables(){
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered(){
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function getById($id){
        $this->db->from($this->table);
        $this->db->where($this->id,$id);
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