<!-- Main content -->
<div class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                <h3 class="card-title">Statistics Overview</h3>
                </div>
                <div class="card-body">
                <!-- /.d-flex -->
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                    <p class="text-info text-xl">
                    <i class="ion ion-ios-cart-outline"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                        <i class="ion ion-android-arrow-<?= $sales_rate < 0 ? "down" : "up" ?> text-info"></i> <?= number_format(abs($sales_rate), 2) ?>%
                    </span>
                    <span class="text-muted">SALES RATE</span>
                    </p>
                </div>
                <!-- /.d-flex -->
                <div class="d-flex justify-content-between align-items-center mb-0">
                    <p class="text-warning text-xl">
                    <i class="ion ion-ios-people-outline"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                        <i class="ion ion-android-arrow-<?= $customers_rate < 0 ? "down" : "up" ?> text-warning"></i> <?= number_format(abs($customers_rate), 2) ?>%
                    </span>
                    <span class="text-muted">REGISTRATION RATE</span>
                    </p>
                </div>
                <!-- /.d-flex -->
                </div>
            </div>
            <!-- /.card -->

            <div class="card">
                <div class="card-header border-0">
                <h3 class="card-title">Menu</h3>
                </div>
                <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                    <tr>
                    <th>Menu</th>
                    <th>Price</th>
                    <th>Sales</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($menu_list as $menu) { ?>
                    <tr>
                      <td>
                          <img src="<?= $menu->image ? base_url("resources/menu/".$menu->id."/".$menu->image) : base_url("resources/no-image.jpg"); ?>" alt="<?= $menu->name ?>" class="img-circle img-size-32 mr-2">
                          <?= $menu->name ?>
                      </td>
                      <td><?= number_format($menu->price)?> đ</td>
                      <td>
                          <small class="text-success mr-1">
                          <i class="fas fa-arrow-up"></i>
                          12%
                          </small>
                          12,000 Sold
                      </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-md-6 -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Sales</h3>
                </div>
                </div>
                <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                    <span class="text-bold text-lg"><?= number_format($chart_data_total_this_month) ?>đ</span>
                    <span>Sales Over Time</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-<?= $total_rate < 0 ? "danger" : "success"?>">
                        <i class="fas fa-arrow-<?= $total_rate < 0 ? "down" : "up"?>"></i> <?= number_format(abs($total_rate), 2) ?>%
                    </span>
                    <span class="text-muted">Since last month</span>
                    </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                    <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This year
                    </span>
                </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->

<script>
/* global Chart:false */

document.addEventListener("DOMContentLoaded", function (event) {

$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  var $salesChart = $('#sales-chart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: <?= json_encode($chart_title) ?>,
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: <?= json_encode($chart_data_this_year) ?>
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  });
});

});
</script>