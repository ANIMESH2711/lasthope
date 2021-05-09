
<!-- ============================================================== -->
<!-- Right sidebar -->
<!-- ============================================================== -->
<!-- .right-sidebar -->
<div class="right-sidebar">
	<div class="slimscrollright">
		<div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
		<div class="r-panel-body">
			<ul id="themecolors" class="m-t-20">
				<li><b>With Light sidebar</b></li>
				<li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
				<li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
				<li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
				<li><a href="javascript:void(0)" data-theme="blue" class="blue-theme">4</a></li>
				<li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
				<li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
				<li class="d-block m-t-30"><b>With Dark sidebar</b></li>
				<li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
				<li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
				<li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">9</a></li>
				<li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme working">10</a></li>
				<li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
				<li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme">12</a></li>
			</ul>
			<ul class="m-t-20 chatonline">
				<li><b>Chat option</b></li>
				<li>
					<a href="javascript:void(0)"><img src="../assets/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
				</li>
				<li>
					<a href="javascript:void(0)"><img src="../assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
				</li>
				<li>
					<a href="javascript:void(0)"><img src="../assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
				</li>
				<li>
					<a href="javascript:void(0)"><img src="../assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
				</li>
				<li>
					<a href="javascript:void(0)"><img src="../assets/images/users/5.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
				</li>
				<li>
					<a href="javascript:void(0)"><img src="../assets/images/users/6.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
				</li>
				<li>
					<a href="javascript:void(0)"><img src="../assets/images/users/7.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
				</li>
				<li>
					<a href="javascript:void(0)"><img src="../assets/images/users/8.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- ============================================================== -->
<!-- End Right sidebar -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
<footer class="footer">
	© 2021 The Question Bank
</footer>
<!-- ============================================================== -->
<!-- End footer -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->

<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?=base_url('assets/be/');?>js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?=base_url('assets/be/');?>js/waves.js"></script>
<!--Menu sidebar -->
<script src="<?=base_url('assets/be/');?>js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="<?=base_url('assets/be/');?>plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<!--Custom JavaScript -->
<script src="<?=base_url('assets/be/');?>js/custom.min.js"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<!--sparkline JavaScript -->
<script src="<?=base_url('assets/be/');?>plugins/sparkline/jquery.sparkline.min.js"></script>
<!--morris JavaScript -->
<script src="<?=base_url('assets/be/');?>plugins/raphael/raphael-min.js"></script>
<script src="<?=base_url('assets/be/');?>plugins/morrisjs/morris.min.js"></script>
<!-- Chart JS -->
<script src="<?=base_url('assets/be/');?>js/dashboard1.js"></script>
<!-- ============================================================== -->
<!-- This is data table -->
<script src="<?=base_url('assets/be/');?>/plugins/datatables/jquery.dataTables.min.js"></script>
<!-- start - This is for export functionality only -->
<script src="<?=base_url('assets/be/datatable/');?>dataTables.buttons.min.js"></script>
<script src="<?=base_url('assets/be/datatable/');?>buttons.flash.min.js"></script>
<script src="<?=base_url('assets/be/datatable/');?>jszip.min.js"></script>
<script src="<?=base_url('assets/be/datatable/');?>pdfmake.min.js"></script>
<script src="<?=base_url('assets/be/datatable/');?>vfs_fonts.js"></script>
<script src="<?=base_url('assets/be/datatable/');?>buttons.html5.min.js"></script>
<script src="<?=base_url('assets/be/datatable/');?>buttons.print.min.js"></script>
<!-- end - This is for export functionality only -->
<script>
	$(document).ready(function() {
		$('#myTable').DataTable();
		$(document).ready(function() {
			var table = $('#example').DataTable({
				"columnDefs": [{
					"visible": false,
					"targets": 2
				}],
				"order": [
					[2, 'asc']
				],
				"displayLength": 25,
				"drawCallback": function(settings) {
					var api = this.api();
					var rows = api.rows({
						page: 'current'
					}).nodes();
					var last = null;
					api.column(2, {
						page: 'current'
					}).data().each(function(group, i) {
						if (last !== group) {
							$(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
							last = group;
						}
					});
				}
			});
			// Order by the grouping
			$('#example tbody').on('click', 'tr.group', function() {
				var currentOrder = table.order()[0];
				if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
					table.order([2, 'desc']).draw();
				} else {
					table.order([2, 'asc']).draw();
				}
			});
		});
	});
	$('#example23').DataTable({
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	});
</script>

<!-- Style switcher -->
<!-- ============================================================== -->
<script src="<?=base_url('assets/be/');?>plugins/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>
