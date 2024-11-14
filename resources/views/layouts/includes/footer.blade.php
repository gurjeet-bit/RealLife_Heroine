        </div>
        @yield('customModals')


        <script src="{{ asset('js/jquery-3.5.0.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('js/moment.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables/datatables.min.js') }}"></script>
        <script src="https://unpkg.com/apexcharts@3.31.0/dist/apexcharts.min.js"></script>
        <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
        <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
        <script src="{{ asset('js/admin.js') }}"></script>
        @yield('customScripts')


        <script>
                $("#headr_notifications").click(function() {
                        $('#remove_dot').remove();
                        fetch("{{ url('/notifications') }}")
                                .then(response => () => {

                                })
                                .catch(err => console.log(err))
                });
        </script>

        </body>

        </html>