        </div>
        <!-- Delete Modal -->
        <div class="modal fade modalCss" tabindex="-1" id="deletemodal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <i class="far fa-times-circle"></i>
                        <p>Are you sure you want to delete this records? This process cannot be undone</p>
                        <div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.5.0.min.js"></script>
        <script src="{{ asset('js/popper.min.js"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="{{ asset('plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="{{ asset('js/moment.min.js"></script>
        <script src="{{ asset('js/bootstrap-datetimepicker.min.js"></script>
        <script src="{{ asset('plugins/datatables/datatables.min.js') }}"></script>
        <script src="https://unpkg.com/apexcharts@3.31.0/dist/apexcharts.min.js"></script>
        <script src="{{ asset('js/admin.js') }}"></script>
        @yield('customScripts')
        <script>
            /* Sales Revenue */
            var options = {
                series: [{
                    name: "SALES",
                    data: [10, 41, 35, 51, 49, 62, 69, 91, 148],
                    colors: '#0E48B4'
                }],
                chart: {
                    height: 400,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight',
                    colors: '#0E48B4'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                }
            };
            var chart = new ApexCharts(document.querySelector("#sales"), options);
            chart.render();

            /* Product Services */
            var options = {
                series: [{
                    name: 'Product',
                    data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
                }, {
                    name: 'Services',
                    data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
                }, ],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],

                },
                yaxis: {
                    title: {
                        text: 'Product/Services'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "$ " + val + " Sales"
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#productservices"), options);
            chart.render();
        </script>
        </body>

        </html>