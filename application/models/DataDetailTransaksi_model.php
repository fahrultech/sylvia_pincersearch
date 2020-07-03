<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class DataDetailTransaksi_model extends CI_Model
{
    public $table = 'detailtransaksi';
    public $id = 'idDetailTransaksi';
    public $order = array('noInvoice');
    public $columnOrder = array('idDetailTransaksi','tanggal','noInvoice','kodeBarang','namaBarang');
    public $columnSearch = array('noInvoice');

    // Konstructor
    function __construct(){
        parent::__construct();
    }

    function _get_datatables_query(){
        // if(isset($_POST['order'])){
        //     echo json_encode($_POST['order']);
        // }
        
        $this->db->select('idDetailTransaksi,tanggal, detailtransaksi.noInvoice, detailtransaksi.kodeBarang, namaBarang');
        $this->db->from($this->table);
        $this->db->join('barang','barang.kodeBarang = detailtransaksi.kodeBarang');
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
    function deleteByNoInvoice($noinvoice){
        $this->db->select($this->id);
        $this->db->from($this->table);
        $this->db->where('noInvoice',$noinvoice);
        $query = $this->db->get();
        if(!empty($query->result())){
            $this->db->select($this->id);
            $this->db->from($this->table);
            $this->db->where('noInvoice',$noinvoice);
            $this->db->delete($this->table);
        }
    }
    function count_all(){
        return $this->db->count_all($this->table);
    }
    function count_filtered(){
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function updateTanggalAndInvoice($id,$data){
        //echo json_encode(array($id,$data['noInvoice']));
        // $this->db->set("tanggal",$data["tanggal"]);
        // $this->db->set("noInvoice",$data["noInvoice"]);
        // $this->db->where("noInvoice",$id);
        // $this->db->update($this->table);
        $data = array(
            'tanggal' => $data["tanggal"],
            'noInvoice' => $data["noInvoice"]
        );
        $this->db->where('noInvoice',$id);
        $this->db->update($this->table,$data);
    }
}