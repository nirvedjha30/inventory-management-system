$(document).ready(function(){
	var DOMAIN = "http://localhost/inv_project/public_html";

	addNewRow();

	$("#add").click(function(){
		addNewRow();
	})

	function addNewRow(){
		$.ajax({
			url : DOMAIN+"/includes/process.php",
			method : "POST",
			data : {getNewOrderItem:1},
			success : function(data){
				$("#invoice_item").append(data);
				var n = 0;
				$(".number").each(function(){
					$(this).html(++n);
				})
			}
		})
	}

	$("#remove").click(function(){
		$("#invoice_item").children("tr:last").remove();
		calculate(0,0);
	})

	$("#invoice_item").delegate(".pid","change",function(){
		var pid = $(this).val();
		var tr = $(this).parent().parent();
		$(".overlay").show();
		if (tr.find(".pid").val() === "") {
			alert("Please select product");
			tr.find(".tqty").val("");
			tr.find(".qty").val("");
			tr.find(".price").val("");
			tr.find(".amt").html( tr.find(".qty").val() * tr.find(".price").val() );
			calculate(0,0);
		}else{
		$.ajax({
			url : DOMAIN+"/includes/process.php",
			method : "POST",
			dataType : "json",
			data : {getPriceAndQty:1,id:pid},
			success : function(data){
				tr.find(".tqty").val(data["product_stock"]);
				tr.find(".pro_name").val(data["product_name"]);
				tr.find(".qty").val(1);
				tr.find(".price").val(data["product_price"]);
				tr.find(".amt").html( tr.find(".qty").val() * tr.find(".price").val() );
				calculate(0,0);
			}
		})
	}
	})

	$("#invoice_item").delegate(".qty","keyup",function(){
		var qty = $(this);
		var tr = $(this).parent().parent();
		if (isNaN(qty.val())) {
			alert("Please enter a valid quantity");
			qty.val(1);
			tr.find(".amt").html(qty.val() * tr.find(".price").val());
			calculate(0,0);
		}else if (qty.val() === "") {
			alert("Please enter quantity");
			qty.val(1);
			tr.find(".amt").html(qty.val() * tr.find(".price").val());
			calculate(0,0);
		}else if (qty.val() <= 0) {
			alert("Please enter a valid quantity");
			qty.val(1);
			tr.find(".amt").html(qty.val() * tr.find(".price").val());
			calculate(0,0);
		}else{
			if ((qty.val() - 0) > (tr.find(".tqty").val()-0)) {
				alert("Sorry ! This much of quantity is not available");
				qty.val(1);
				tr.find(".amt").html(qty.val() * tr.find(".price").val());
				calculate(0,0);
			}else{
				tr.find(".amt").html(qty.val() * tr.find(".price").val());
				calculate(0,0);
			}
		}

	})

	function calculate(dis,paid){
		var sub_total = 0;
		var gst = 0;
		var net_total = 0;
		var discount = dis;
		var paid_amt = paid;
		var due = 0;
		$(".amt").each(function(){
			sub_total = sub_total + ($(this).html() * 1);
		})
		gst = 0.18 * sub_total;
		net_total = gst + sub_total;
		net_total = net_total - discount;
		due = net_total - paid_amt;
		$("#gst").val(gst);
		$("#sub_total").val(sub_total);
		
		$("#discount").val(discount);
		$("#net_total").val(net_total);
		//$("#paid")
		$("#due").val(due);

	}

	$("#discount").keyup(function(){
		var discount = $(this).val();
		calculate(discount,0);
	})

	$("#paid").keyup(function(){
		var paid = $(this).val();
		var discount = $("#discount").val();
		calculate(discount,paid);
	})


	/*Order Accepting*/

	$("#order_form").click(function(){
		// var pid = $(this).val();
		// var tr = $(this).parent().parent();
		var invoice = $("#get_order_data").serialize();
		//var invoice_item = $("#invoice_item").serialize();
		if ($("#cust_name").val() === "") {
			alert("Plaese enter customer name");
		// }else if (tr.find(".pid").val() === "") {
		}else if ($("#pid").val() === "") {
			alert("Please select product");
		}else if ($("#discount").val() === "") {
			alert("Please enter discount");
		}else if (isNaN($("#discount").val()) || $("#discount").val() < 0 || $("#discount").val().match(/^-\d+$/) || $("#discount").val().match(/^0\d+$/)) {
			alert("Please enter a valid discount");
		}else if($("#net_total").val() < 0){
			alert("Please not enter discount more than Net Total Amount");
		}else if($("#paid").val() === ""){
			alert("Plaese eneter paid amount");
		}else if (isNaN($("#paid").val()) || $("#paid").val() < 0 || $("#paid").val().match(/^-\d+$/) || $("#paid").val().match(/^0\d+$/)) {
			alert("Please enter a valid paid amount");
		}else if($("#due").val() < 0 && $("#paid").val() > $("#net_total").val()){
			alert("Please not enter Paid Amount more than Net Total Amount");
		}else{
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : $("#get_order_data").serialize(),
				success : function(data){

					if (data < 0) {
						alert(data);
					}else{
						$("#get_order_data").trigger("reset");

						//if (confirm("Do u want to print invoice ?")) {
							window.location.href = DOMAIN+"/includes/invoice_bill.php?invoice_no="+data+"&"+invoice;
						//}
					}

						
						

					

				}
			});
		}
		
			
		


	});

});