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
                                <div class="col-4 input-group">
                                    <input type="text" class="form-control" name="minconfidence"> 
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-percent"></i></span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Hitung</button>
                        </form>
                        <div class="row">
                <div class="col-lg-12">
                   <table class="table table-striped table-condensed">
                      <thead>
                        <tr>
                           <th>No</th>
                           <th>Rules</th>
                           <th>Support XuY</th>
                           <th>Support X</th>
                           <th>Confidence</th>
                           <th>Support Y</th>
                           <th>Lift Ratio</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                   </table>
                </div>
            </div>
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
            result = [];
            let table = "";
            for(let i=0;i<data.length;i++){
                let antecedent="";
                let consequent="";
                for(let j=0;j<data[i][0].length;j++){
                    antecedent +=data[i][0][j];
                    j < data[i][0].length-1 ? antecedent += "," : "";
                }
                for(let j=0;j<data[i][1].length;j++){
                    consequent +=data[i][1][j];
                    j < data[i][1].length-1 ? consequent += "," : "";
                }
              result.push(`${antecedent} => ${consequent}`);
              table += 
                `<tr>
                  <td>${i+1}</td>
                  <td>${result[i]}</td>
                  <td>${data[i][2]}</td>    
                  <td>${data[i][3]}</td>
                  <td>${data[i][4]}</td>
                  <td>${data[i][5]}</td>
                  <td>${data[i][6]}</td>
                </tr>`;
            }
            $('tbody').append(table);
            
         }
     })
  })
</script>
                