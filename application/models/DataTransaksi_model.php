<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class DataTransaksi_model extends CI_Model
{
    public $table = 'transaksi';
    public $id = 'idTransaksi';
    public $order = array('tanggal' => 'asc');
    public $columnOrder = array('tanggal,noInvoice');
    public $columnSearch = array('noInvoice');

    // Konstructor
    function __construct(){
        parent::__construct();
    }

    function _get_datatables_query(){
        $this->db->select('idTransaksi, noInvoice, tanggal');
        $this->db->from($this->table);
        $i = 0;
        foreach($this->columnSearch as $item){
            if($_POST['search']['value']){
                if($i===0){
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }else{
                    $this->db->or_like($item, $POST['search']['value']);
                }
                if(count($this->columnSearch) - 1 == $i)
                $this->db->group_end();
            }
            $i++;
        }
        if(isset($_POST['order'])){
            $this->db->order_by($this->columnOrder[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function getAll(){
        return $this->db->get($this->table)->result();
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
    function count_all(){
        return $this->db->count_all($this->table);
    }
    function getById($id){
        $this->db->from($this->table);
        $this->db->where($this->id,$id);
        $query = $this->db->get();
        return $query->row();
    }
    function getInvoiceNo($id){
        $this->db->select('noInvoice');
        $this->db->from($this->table);
        $this->db->where($this->id,$id);
        $query = $this->db->get();
        return $query->result();
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