<div class="container-fluid">
    <section class="content-header" style="">
        <?php $this->load->view('v_admin_header');?>
    </section>

    <section class="content">
        
        <div class="row">
            <?php //$this->load->view('v_admin_sidenav');?>

            <div class="col-lg-10" style=""> <!-- remove-pad -->
                
                <div class="box box-widget" style="min-height: 570px;">
                    <div class="box-header with-border">
                        <h3>Reports</h3>
                    </div>
                    <div class="box-body">
                       
                       <div class="row">
                            <div class="col-md-12">

                                <div class="box box-widget">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Daily</h4>
                                    </div>
                                    <div class="box-body">
                                        <canvas id="daily-chart" height="5" style="width: 100%;"></canvas>
                                    </div>  
                                </div>

                            </div>

                            <div class="col-md-12">
                            
                                <div class="box box-widget">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Weekly</h4>
                                    </div>
                                    <div class="box-body">
                                        <canvas id="bar-chart" height="50" style="width: 100%;"></canvas>
                                    </div>  
                                </div>

                            </div>

                            <div class="col-md-12">
                            
                                <div class="box box-widget">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Yearly</h4>
                                        <div class="box-tools">
                                            <div class="form-inline">
                                                <label>Select Year</label>
                                                <select name="report_year" class="form-control" style="width: 150px; height: 33px; padding:0.3rem;">
                                                    <?php $start_year = 2015; $current_year = date('Y');?>
                                                    <?php for($counter = $start_year ; $counter <= $current_year; $counter++):?>
                                                    <?php $selected = ($counter == $current_year)? "selected":"";?>
                                                        <option value="<?=$counter?>" <?=$selected?>><?=$counter?></option>
                                                    <?php endfor;?>    
                                                </select>
                                            </div>    
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <canvas id="yearly-chart" height="10" style="width: 100%;"></canvas>
                                    </div>  
                                </div>
                            </div>
                            
                            <div class="col-md-12">

                                <div class="box box-widget">
                                    <div class="box-header with-border">
                                        <h4>Summary Table</h4>
                                    </div>  
                                    <div class="box-body">
                                        <table class="table table-hover dt-responsive nowrap" id="admin-report-summary-table" style="">
                                            <thead>
                                                <th>Months</th>
                                                <th>Employers</th>
                                                <th>Applicants</th>
                                                <th>Job Post</th>
                                                <th>Applications</th>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                       </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<?php $this->load->view('template/profile_modal')?>
<script type="text/javascript" src="<?=base_url('assets/js/plugins/chart.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/admin/report.js')?>"></script>
<script type="text/javascript">
//https://jsfiddle.net/u5aanta8/36/
    setInterval('adddata()', 1000);

    var canvas = document.getElementById('daily-chart');
    var data = {
      labels: ["", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""],
      datasets: [{
        label: "My First dataset",
        fill: false,
        lineTension: 0.2,
        backgroundColor: "rgba(75,192,192,0.4)",
        borderColor: "rgba(75,192,192,1)",
        borderCapStyle: 'butt',
        borderDash: [],
        borderDashOffset: 0.0,
        borderWidth: 1,
        borderJoinStyle: 'miter',
        pointBorderColor: "rgba(75,192,192,1)",
        pointBackgroundColor: "#fff",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(75,192,192,1)",
        pointHoverBorderColor: "rgba(220,220,220,1)",
        pointHoverBorderWidth: 2,
        pointRadius: 0,
        pointHitRadius: 10,
        data: [null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null],
    }]
};

function adddata() {
  myLineChart.data.datasets[0].data.shift();
  myLineChart.data.labels.shift();
  myLineChart.data.datasets[0].data.push(Math.floor((Math.random() * 100) + 1));
  var ctime = new Date();
  var csecs = moment(ctime).format("s");
  if (csecs % 15 === 0) {
    var label = csecs == '0' ? moment(ctime).format("mm:ss") : moment(ctime).format(":ss");
    myLineChart.data.labels.push(label);
} else {
    myLineChart.data.labels.push('');
}

myLineChart.update();

}

var option = {
  showLines: true,
  animation: false,
  legend: {
    display: false
},
scales: {
    yAxes: [{
      ticks: {
        max: 100,
        min: 0,
        stepSize: 50
    },
    gridLines: {
        drawTicks: false
    }
}],
xAxes: [{
  gridLines: {
    display: true,
    drawTicks: false
},
ticks: {
    fontSize: 10,
    maxRotation: 0,
    autoSkip: false,
    callback: function(value) {
      if (value.toString().length > 0) {
        return value;
    } else {return null};
}
}
}]
}
};
var myLineChart = Chart.Bar(canvas, {
  data: data,
  options: option
});

</script>
