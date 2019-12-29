
	<script src="{!!url('public/back-end/js/jquery-1.11.1.min.js')!!}"></script>
	<script src="{!!url('public/back-end/js/bootstrap.min.js')!!}"></script>
	<script src="{!!url('public/back-end/js/chart.min.js')!!}"></script>
	<script src="{!!url('public/back-end/js/chart-data.js')!!}"></script>
	<script src="{!!url('public/back-end/js/easypiechart.js')!!}"></script>
	<script src="{!!url('public/back-end/js/easypiechart-data.js')!!}"></script>
 	<script src="{!!url('public/back-end/js/bootstrap-datepicker.js')!!}"></script> 
	<script src="{!!url('public/back-end/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js')!!}"></script>
	<script src="{!!url('public/js/script.js')!!}"></script>
	<script src="{!!url('public/back-end/js/jquery.validate.min.js')!!}"></script> 
	<script>
		// $('#datepicker').datetimepicker({
		// 	  isRTL: false,
		// 	    format: 'dd.mm.yyyy hh:ii',
		// 	    autoclose:true,
		// 	    language: 'ru'
		// });
		 $(function () {
                $('#datetimepicker2').datetimepicker({
                    locale: 'ru'
                });
            });

			$(function () {
                $('#datetimepicker3').datetimepicker({
                    locale: 'ru'
                });
            });

		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
		        $(this).find('em:first').toggleClass("glyphicon-minus");      
		    }); 
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>
@include('back-end.layouts.script')
</body>

</html>
