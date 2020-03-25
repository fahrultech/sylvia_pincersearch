<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title float-left">Perhitungan PincerSearch</h4>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item active">PincerSearch</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <form class="form-horizontal" action="" autocomplete="off">
                            <div class="form-group row">
                                <label for="tglawal" class="col-form-label col-2">Tanggal Awal</label>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="tglawal">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tglakhir" class="col-form-label col-2">Tanggal Akhir</label>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="tglakhir">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="minsupport" class="col-form-label col-2">Min Support</label>
                                <div class="col-4 input-group">
                                    <input type="text" class="form-control" name="minsupport">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-percent"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="minconfidence" class="col-form-label col-2">Min Confidence</label>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="minconfidence">
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Hitung</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
<script>
  document.querySelector('form').addEventListener('submit', e => {
     e.preventDefault();
     let support = [];
     let itemPair = [];
     let dataTransaksiArray = [];
     let tempDB = [];
     let MFCS = [];
     let infrequent = [];

     const data = {
         "tglawal" : moment(document.querySelector('[name="tglawal"]').value).format("YYYY-MM-DD"),
         "tglakhir" : moment(document.querySelector('[name="tglakhir"]').value).format("YYYY-MM-DD"),
         "minsupport" : document.querySelector('[name="minsupport"]').value,
         "minconfidence" : document.querySelector('[name="minconfidence"]').value
     }
     $.ajax({
         url : "perhitunganpincersearch/getbydate",
         type: "POST",
         data : data,
         dataType: "JSON",
         success : function(data){
             const datatransaksi = data.datatransaksi;
             const databarang = data.databarang;
             console.log(data);
             for(let i=0;i<datatransaksi.length;i++){
                 const isFind = dataTransaksiArray.find(dt => dt.noInvoice === datatransaksi[i].noInvoice);
                 tempDB.push(datatransaksi[i].kodeBarang);
                 
                 if(!isFind){
                    const obj = {
                        noInvoice : datatransaksi[i].noInvoice,
                        items : [datatransaksi[i].kodeBarang]
                    }
                    dataTransaksiArray.push(obj);
                 }else{
                     for(let j=0;j<dataTransaksiArray.length;j++){
                         if(datatransaksi[i].noInvoice === dataTransaksiArray[j].noInvoice){
                             dataTransaksiArray[j].items.push(datatransaksi[i].kodeBarang);
                         }
                     }
                 }
             }
             MFCS = [...new Set(tempDB)];
             databarang.forEach(db => {
                let count = 0;
                datatransaksi.forEach(dt => {
                   if(db.kodeBarang === dt.kodeBarang){
                       count++;
                   }
                });
                const obj = {
                    kodeBarang : db.kodeBarang,
                    jumlah : count
                }
                if(count > 3){
                  support.push(obj);
                }
             });
             for(let i=0;i<support.length-1;i++){
                 dt = [];
                 dt.push(support[i].kodeBarang);
                 dt.push(support[i+1].kodeBarang);
                 itemPair.push({"item" : dt,"support":0});
             }
             Array.prototype.contains = function(array) {
                return array.every(function(item) {
                    return this.indexOf(item) !== -1;
                }, this);
             }
             itemPair.forEach((ip,index) => {
                dataTransaksiArray.forEach(dta => {
                    if(dta.items.contains(ip.item)){
                        itemPair[index].support++;
                    }
                })
              })
             console.log(`Jumlah Transaksi : ${datatransaksi.length}`)
             support.sort();
             console.log(dataTransaksiArray);
             console.log(support);
             console.log(itemPair);
         }
     })
  })
</script>
                