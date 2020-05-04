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
                        <div class="sk-fading-circle">
                            <div class="sk-circle1 sk-circle"></div>
                            <div class="sk-circle2 sk-circle"></div>
                            <div class="sk-circle3 sk-circle"></div>
                            <div class="sk-circle4 sk-circle"></div>
                            <div class="sk-circle5 sk-circle"></div>
                            <div class="sk-circle6 sk-circle"></div>
                            <div class="sk-circle7 sk-circle"></div>
                            <div class="sk-circle8 sk-circle"></div>
                            <div class="sk-circle9 sk-circle"></div>
                            <div class="sk-circle10 sk-circle"></div>
                            <div class="sk-circle11 sk-circle"></div>
                            <div class="sk-circle12 sk-circle"></div>
                        </div>
                <div class="col-lg-12">
                   <table id="rule" class="table table-striped table-condensed">
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
            <div class="log" style="margin: 0 auto">
               <div class="col-md-6">
               </div>
            </div>
            <div id="column-chart"></div>
        </div>
    </div>
</div>

           
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
    <script src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.form.js')?>"></script>
    <!-- Google Charts js -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
    
    
  </script>
    
<script>
  $('.sk-fading-circle').hide();
  
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
         url : "PerhitunganPincerSearch/getByDate",
         type: "POST",
         data : data,
         dataType: "JSON",
         beforeSend:function(){
                $('.sk-fading-circle').show();
            },
            complete : function(){
                $('.sk-fading-circle').hide();
            },
         success : function(data){ 
            var column_data = [
            ['Rule', 'Confidence', 'Lift Ratio', 'Support'],];
            result = [];
            let table = "";
            $('#rule tbody').empty();
            $('.log .col-md-6').empty();
            console.log(data[0][1].frequent);
            for(let i=0;i<data[1].length;i++){
                let rule_temp = [];
                let antecedent="";
                let consequent="";
                for(let j=0;j<data[1][i][0].length;j++){
                    antecedent +=data[1][i][0][j];
                    j < data[1][i][0].length-1 ? antecedent += "," : "";
                }
                for(let j=0;j<data[1][i][1].length;j++){
                    consequent +=data[1][i][1][j];
                    j < data[1][i][1].length-1 ? consequent += "," : "";
                }
              result.push(`${antecedent} => ${consequent}`);
              table += 
                `<tr>
                  <td>${i+1}</td>
                  <td>${result[i]}</td>
                  <td>${data[1][i][2]}</td>    
                  <td>${data[1][i][3]}</td>
                  <td>${data[1][i][4]}</td>
                  <td>${data[1][i][5]}</td>
                  <td>${data[1][i][6]}</td>
                </tr>`;
                rule_temp.push(`Rule ${i+1}`);
                rule_temp.push(data[1][i][4]);
                rule_temp.push(data[1][i][6]);
                rule_temp.push(data[1][i][5]);
                column_data.push(rule_temp);
            }
            let sh="";
            for(let j=0;j<data[0].length;j++){
                let gh="";
                gh += `<h4 style="text-align:center">Pass Ke : ${data[0][j].k}</h4>`
                if(data[0][j].frequent.length > 0){
                    gh += `<table class="table table-striped table-condensed">
                        <thead>
                         <tr>
                           <th>No</th>
                           <th style="text-align:center">Data Frequent Item</th>
                         </tr>
                        </thead><tbody>`

                    for(let k=0;k<data[0][j].frequent.length;k++){
                      gh += `<tr>
                              <td>${k+1}</td>
                              <td>${data[0][j].frequent[k]}</td>
                             </tr>`
                    }
                    gh += `</tbody></table>`
                }
                if(data[0][j].infrequent.length > 0){
                    gh += `<table class="table table-striped table-condensed">
                        <thead>
                         <tr>
                           <th>No</th>
                           <th style="text-align:center">InFrequent Item</th>
                         </tr>
                        </thead><tbody>`

                for(let k=0;k<data[0][j].infrequent.length;k++){
                 gh += `<tr>
                           <td>${k+1}</td>
                           <td>${data[0][j].infrequent[k]}</td>
                        </tr>`
                 }
                 gh += `</tbody></table>`
                }
                if(data[0][j].mfs.length > 0){
                    gh += `<table class="table table-striped table-condensed">
                        <thead>
                         <tr>
                           <th>No</th>
                           <th style="text-align:center">MFS</th>
                         </tr>
                        </thead><tbody>`

                for(let k=0;k<data[0][j].mfs.length;k++){
                 gh += `<tr>
                           <td>${k+1}</td>
                           <td>${data[0][j].mfs[k]}</td>
                        </tr>`
                 }
                 gh += `</tbody></table>`
                }
                if(data[0][j].mfcs.length > 0){
                    gh += `<table class="table table-striped table-condensed">
                        <thead>
                         <tr>
                           <th>No</th>
                           <th style="text-align:center">MFCS</th>
                         </tr>
                        </thead><tbody>`

                for(let k=0;k<data[0][j].mfcs.length;k++){
                 gh += `<tr>
                           <td>${k+1}</td>
                           <td>${data[0][j].mfcs[k]}</td>
                        </tr>`
                 }
                 gh += `</tbody></table>`
                }
                if(data[0][j].cdata.length > 0){
                    gh += `<table class="table table-striped table-condensed">
                        <thead>
                         <tr>
                           <th>No</th>
                           <th style="text-align:center">Data C${data[0][j].k+1}</th>
                         </tr>
                        </thead><tbody>`

                for(let k=0;k<data[0][j].cdata.length;k++){
                 gh += `<tr>
                           <td>${k+1}</td>
                           <td>${data[0][j].cdata[k]}</td>
                        </tr>`
                 }
                 gh += `</tbody></table>`
                }
                
                 sh += gh;
            }
            $('.log .col-md-6').append(sh);
            $('#rule tbody').append(table);
            google.charts.setOnLoadCallback(function() {drawChart(column_data,"Values",['#297ef6', '#e52b4c', '#32c861'])});
         }
     });
  })
   
    google.charts.load('current', {packages: ['corechart']});
    
    function drawChart(data,axislabel,colors) {
        var options = {
            fontName: 'Open Sans',
            height: 400,
            fontSize: 13,
            chartArea: {
                left: '5%',
                width: '90%',
                height: 350
            },
            tooltip: {
                textStyle: {
                    fontName: 'Open Sans',
                    fontSize: 14
                }
            },
            vAxis: {
                title: axislabel,
                titleTextStyle: {
                    fontSize: 14,
                    italic: false
                },
                gridlines:{
                    color: '#f5f5f5',
                    count: 10
                },
                minValue: 0
            },
            legend: {
                position: 'top',
                alignment: 'center',
                textStyle: {
                    fontSize: 13
                }
            },
            colors: colors
        };
      var ct = google.visualization.arrayToDataTable(data);
      // Instantiate and draw the chart.
      var chart = new google.visualization.ColumnChart(document.getElementById('column-chart'));
      chart.draw(ct, options);
    }
</script>
                