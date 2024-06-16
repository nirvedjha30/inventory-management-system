$(document).ready(function(){
	var DOMAIN = "http://localhost/inv_project/public_html";
	//----------Category----------
	//Mange Category
	manageCategory(1);
	function manageCategory(pn){
		$.ajax({
			url : DOMAIN+"/includes/process.php",
			method : "POST",
			data : {manageCategory:1,pageno:pn},
			success : function(data){
				$("#get_category").html(data);		
			}
		})
	}

	$("body").delegate(".page-link","click",function(){
		var pn = $(this).attr("pn");
		manageCategory(pn);
	})

	//Deleted Category
	$("body").delegate(".del_cat","click",function(){
		var did = $(this).attr("did");
		if (confirm("Are you sure ? You want to delete..!")) {
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {deleteCategory:1,id:did},
				success : function(data){
					if (data == "DEPENDENT_CATEGORY") {
						alert("Sorry ! this Category is dependent on other sub categories.");
					}else if(data == "CATEGORY_DELETED"){
						alert("Category Deleted Successfully..! happy");
						window.location.href = "";
						manageCategory(1);
					}else if(data == "DELETED"){
						alert("Deleted Successfully..!");
						window.location.href = "";
					}else{
						alert("Sorry ! this Category is dependent on product.");
						window.location.href = "";
					}
						
				}
			})
		}
	})


	//Active Category
	$("body").delegate(".active_cat","click",function(){
		var activeid = $(this).attr("activeid");
		if (confirm("Are you sure ? You want to active..!")) {
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {activeCategory:1,id:activeid},
				success : function(data){
					if(data == "ACTIVATED"){
						alert("Category Activated Successfully..! happy");
						window.location.href = "";
						manageCategory(1);
					}else{
						alert("Sorry ! this Category is not activated.");
						window.location.href = "";
					}
						
				}
			})
		}
	})


	//Deactive Category
	$("body").delegate(".deactive_cat","click",function(){
		var deactiveid = $(this).attr("deactiveid");
		if (confirm("Are you sure ? You want to deactive..!")) {
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {deactiveCategory:1,id:deactiveid},
				success : function(data){
					if (data == "DEPENDENT_CATEGORY") {
						alert("Sorry ! this Category is dependent on other sub categories.");
					}else if(data == "CATEGORY_DEACTIVATED"){
						alert("Category Deactivated Successfully..! happy");
						window.location.href = "";
						manageCategory(1);
					}else if(data == "DEPENDENT_PRODUCT") {
						alert("Sorry ! this Category is dependent on product.");
						window.location.href = "";
					}
						
				}
			})
		}
	})


	//Fetch category
	fetch_category();
	function fetch_category(){
		$.ajax({
			url : DOMAIN+"/includes/process.php",
			method : "POST",
			data : {getCategory:1},
			success : function(data){
				var root = "<option value='0'>Root</option>";
				var choose = "<option value=''>Choose Category</option>";
				$("#parent_cat").html(root+data);
				$("#select_cat").html(choose+data);
			}
		})
	}

	


	//Update Category
	$("body").delegate(".edit_cat","click",function(){
		var eid = $(this).attr("eid");
		$.ajax({
			url : DOMAIN+"/includes/process.php",
			method : "POST",
			dataType : "json",
			data : {updateCategory:1,id:eid},
			success : function(data){
				console.log(data);
				$("#cid").val(data["cid"]);
				$("#update_category").val(data["category_name"]);
				$("#parent_cat").val(data["parent_cat"]);
			}
		})
	})

	$("#update_category_form").on("submit",function(){
		if ($("#update_category").val() == "") {
			$("#update_category").addClass("border-danger");
			$("#cat_error").html("<span class='text-danger'>Please Enter Category Name</span>");
		}else{
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data  : $("#update_category_form").serialize(),
				success : function(data){
					if (data == "ALREADY_EXISTS") {
						alert("Category is already exists.");
					}else if (data == "UPDATED") {
						alert("Category Update Successfully..! happy");
						window.location.href = "";
					}else{
						alert(data);
					}
				}
			})
		}
	})


	//----------Brand-------------
	//Manage Brand
	manageBrand(1);
	function manageBrand(pn){
		$.ajax({
			url : DOMAIN+"/includes/process.php",
			method : "POST",
			data : {manageBrand:1,pageno:pn},
			success : function(data){
				$("#get_brand").html(data);		
			}
		})
	}

	$("body").delegate(".page-link","click",function(){
		var pn = $(this).attr("pn");
		manageBrand(pn);
	})

	$("body").delegate(".del_brand","click",function(){
		var did = $(this).attr("did");
		if (confirm("Are you sure ? You want to delete..!")) {
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {deleteBrand:1,id:did},
				success : function(data){
					if (data == "DELETED") {
						alert("Brand Deleted Successfully..! happy");
						window.location.href = "";
						manageBrand(1);
					}else{
						alert("Sorry ! this Brand is dependent on product.");
						window.location.href = "";
					}
						
				}
			})
		}
	})

	//Active Brand
	$("body").delegate(".active_brand","click",function(){
		var activeid = $(this).attr("activeid");
		if (confirm("Are you sure ? You want to active..!")) {
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {activeBrand:1,id:activeid},
				success : function(data){
					if(data == "ACTIVATED"){
						alert("Brand Activated Successfully..! happy");
						window.location.href = "";
						manageBrand(1);
					}else{
						alert("Sorry ! this Brand is not activated.");
						window.location.href = "";
					}
						
				}
			})
		}
	})


	//Deactive Brand
	$("body").delegate(".deactive_brand","click",function(){
		var deactiveid = $(this).attr("deactiveid");
		if (confirm("Are you sure ? You want to deactive..!")) {
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {deactiveBrand:1,id:deactiveid},
				success : function(data){
					if(data == "BRAND_DEACTIVATED"){
						alert("Brand Deactivated Successfully..! happy");
						window.location.href = "";
						manageBrand(1);
					}else if(data == "DEPENDENT_PRODUCT") {
						alert("Sorry ! this Brand is dependent on product.");
						window.location.href = "";
					}
						
				}
			})
		}
	})


	//Fetch Brand
	fetch_brand();
	function fetch_brand(){
		$.ajax({
			url : DOMAIN+"/includes/process.php",
			method : "POST",
			data : {getBrand:1},
			success : function(data){
				var choose = "<option value=''>Choose Brand</option>";
				$("#select_brand").html(choose+data);
			}
		})
	}

	//Update Brand
	$("body").delegate(".edit_brand","click",function(){
		var eid = $(this).attr("eid");
		$.ajax({
			url : DOMAIN+"/includes/process.php",
			method : "POST",
			dataType : "json",
			data : {updateBrand:1,id:eid},
			success : function(data){
				console.log(data);
				$("#bid").val(data["bid"]);
				$("#update_brand").val(data["brand_name"]);
			}
		})
	})

	$("#update_brand_form").on("submit",function(){
		if ($("#update_brand").val() == "") {
			$("#update_brand").addClass("border-danger");
			$("#brand_error").html("<span class='text-danger'>Please Enter Brand Name</span>");
		}else{
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data  : $("#update_brand_form").serialize(),
				success : function(data){
					if (data == "ALREADY_EXISTS") {
						alert("Brand is already exists.");
					}else if (data == "UPDATED") {
						alert("Brand Update Successfully..! happy");
						window.location.href = "";
					}else{
						alert(data);
					}
				}
			})
		}
	})


	//---------------------Products-----------------
	manageProduct(1);
	function manageProduct(pn){
		$.ajax({
			url : DOMAIN+"/includes/process.php",
			method : "POST",
			data : {manageProduct:1,pageno:pn},
			success : function(data){
				$("#get_product").html(data);		
			}
		})
	}

	$("body").delegate(".page-link","click",function(){
		var pn = $(this).attr("pn");
		manageProduct(pn);
	})

	//Delete Product
	$("body").delegate(".del_product","click",function(){
		var did = $(this).attr("did");
		if (confirm("Are you sure ? You want to delete..!")) {
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {deleteProduct:1,id:did},
				success : function(data){
					if (data == "DELETED") {
						alert("Product Deleted Successfully..! happy");
						window.location.href = "";
						manageProduct(1);
					}else{
						alert(data);
					}
						
				}
			})
		}
	})

	//Active Product
	$("body").delegate(".active_product","click",function(){
		var activeid = $(this).attr("activeid");
		if (confirm("Are you sure ? You want to active..!")) {
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {activeProduct:1,id:activeid},
				success : function(data){
					if(data == "ACTIVATED"){
						alert("Product Activated Successfully..! happy");
						window.location.href = "";
						manageProduct(1);
					}else{
						alert("Sorry ! this Product is not activated.");
						window.location.href = "";
					}
						
				}
			})
		}
	})


	//Deactive Product
	$("body").delegate(".deactive_product","click",function(){
		var deactiveid = $(this).attr("deactiveid");
		if (confirm("Are you sure ? You want to deactive..!")) {
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {deactiveProduct:1,id:deactiveid},
				success : function(data){
					if(data == "PRODUCT_DEACTIVATED"){
						alert("Product Deactivated Successfully..! happy");
						window.location.href = "";
						manageProduct(1);
					}
						
				}
			})
		}
	})


	//Fetch product
	$("body").delegate(".edit_product","click",function(){
		var eid = $(this).attr("eid");
		$.ajax({
			url : DOMAIN+"/includes/process.php",
			method : "POST",
			dataType : "json",
			data : {updateProduct:1,id:eid},
			success : function(data){
				console.log(data);
				$("#pid").val(data["pid"]);
				$("#update_product").val(data["product_name"]);
				$("#select_cat").val(data["cid"]);
				$("#select_brand").val(data["bid"]);
				$("#product_price").val(data["product_price"]);
				$("#product_qty").val(data["product_stock"]);

			}
		})
	})

	//Update product
	$("#update_product_form").on("submit",function(){
		$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : $("#update_product_form").serialize(),
				success : function(data){
					if (data == "ALREADY_EXISTS") {
						alert("Product is already exists.");
					}else if (data == "UPDATED") {
						alert("Product Update Successfully..! happy");
						window.location.href = "";
					}else{
						alert(data);
					}
				}
			})
	})

	//---------------------Manage_Orders-----------------
	manageOrder(1);
	function manageOrder(pn){
		$.ajax({
			url : DOMAIN+"/includes/process.php",
			method : "POST",
			data : {manageOrder:1,pageno:pn},
			success : function(data){
				$("#get_order").html(data);		
			}
		})
	}

	$("body").delegate(".page-link","click",function(){
		var pn = $(this).attr("pn");
		manageOrder(pn);
	})

	$("body").delegate(".del_order","click",function(){
		var did = $(this).attr("did");
		if (confirm("Are you sure ? You want to delete..!")) {
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : {deleteOrder:1,id:did},
				success : function(data){
					if (data == "DELETED") {
						alert("Order Deleted Successfully..! happy");
						manageOrder(1);
					}else{
						alert(data);
					}
						
				}
			})
		}
	})


	
})