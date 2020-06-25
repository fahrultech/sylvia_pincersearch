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
    function getByNoTransaksi($notransaksi){
        $this->db->from('transaksi');
        $this->db->where('noInvoice',$notransaksi);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function getByNoTransaksiAndKodeBarang($notransaksi,$kodebarang){
        $this->db->from('detailtransaksi');
        $this->db->where('noInvoice',$notransaksi);
        $this->db->where('kodeBarang',$kodebarang);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function insertBarang($data){
        $barangMasuk = 0;
        $barangTidakMasuk = 0;
        foreach($data as $dat){
            if($this->getByKodeBarang($dat["kodeBarang"]) === 0){
                $this->db->insert($this->table,$dat);
                $barangMasuk++;
            }else{
                $barangTidakMasuk++;
            }
        }
        return (array("barangMasuk" => $barangMasuk, "barangTidakMasuk" => $barangTidakMasuk));
    }
    function insertBarangBatch($data){
        $this->db->insert_batch($this->table,$data);
    }
    function insertHeaderTransaksi($data){
        $trMasuk = 0;
        $trTidakMasuk = 0;
        foreach($data as $dat){
            if($this->getByNoTransaksi($dat["noInvoice"]) === 0){
                $this->db->insert('transaksi',$dat);
                $trMasuk++;
            }else{
                $trTidakMasuk++;
            }
        }
        return (array("trMasuk" => $trMasuk, "trTidakMasuk" => $trTidakMasuk));
    }
    function insertDetailTransaksi($data){
        $dtTrMasuk = 0;
        $dtTrTidakMasuk = 0;
        foreach($data as $dat){
            if($this->getByNoTransaksiAndKodeBarang($dat["noInvoice"],$dat["kodeBarang"]) === 0){
                $this->db->insert('detailtransaksi',$dat);
                $dtTrMasuk++;
            }else{
                $dtTrTidakMasuk++;
            }
        }
        return (array("dtTrMasuk" => $dtTrMasuk, "dtTrTidakMasuk" => $dtTrTidakMasuk));
    }

}