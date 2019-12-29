<script>
function myLoginCart() {
// 	alertify.set('notifier','position', 'top-center');
// alertify.success('Vui lòng đăng nhập để yêu thích');
swal("Vui lòng đăng nhập!");
}

// document.getElementById('b1').onclick = function(){
// 	swal("Vui lòng đăng nhập!");
// };
</script>

<script>	
	$.ajaxSetup({
	  headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  }
	});
	var clicks = {!!Cart::count();!!};
	function addToCart(id){
		clicks += 1;
		document.getElementById("clicks").innerHTML = clicks;
		$.ajax({
		    type: "GET",
		    url: "gio-hang/addcart/"+id,
		    dataType: "json",
		    data: { id: id }
		  })
		  .done(function(data) {
		  	$("#divid").load(" #divid > *");
		     //var ob = JSON.parse(JSON.strigify)
		     $('#counter').html(data['added']);
		     swal("Thêm giỏ hàng thành công!", "Vui lòng kiểm tra giỏ hàng!", "success");
		  });
			}
</script>

