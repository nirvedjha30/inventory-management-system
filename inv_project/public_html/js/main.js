$(document).ready(function(){
	var DOMAIN = "http://localhost/inv_project/public_html";
	$("#register_form").on("submit",function(){
		var status = false;
		var name = $("#username");
		var email = $("#email");
		var pass1 = $("#password1");
		var pass2 = $("#password2");
		var type = $("#usertype");
		//Mail ID Regular Expression (Example -> nirvedj2023@gmail.com)
		var e_patt = new RegExp(/^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9_-]+(\.[a-z0-9_-]+)*(\.[a-z]{2,3})$/);
			if(name.val() == "" || name.val().length < 6 || name.val().length > 20){
				name.addClass("border-danger");
				$("#u_error").html("<span class='text-danger'>Please enter name and name must be between 6 and 20 character.</span>");
				status = false;
			}else{
				name.removeClass("border-danger");
				$("#u_error").html("");
				status = true;
			}
			if (email.val() == ""){
				email.addClass("border-danger");
				$("#e_error").html("<span class='text-danger'>Please enter email address.</span>");
				status = false;
			}else{
				if(!e_patt.test(email.val())){
					email.addClass("border-danger");
					$("#e_error").html("<span class='text-danger'>Please enter valid email address.</span>");
					status = false;
				}else{
					email.removeClass("border-danger");
					$("#e_error").html("");
					status = true;
				}
			}
			if(pass1.val() == "" || pass1.val().length < 9){
				pass1.addClass("border-danger");
				$("#p1_error").html("<span class='text-danger'>Please enter more than 8 character password.</span>");
				status = false;
			}else{
				pass1.removeClass("border-danger");
				$("#p1_error").html("");
				status = true;
			}
			if(pass2.val() == "" || pass2.val().length < 9){
				pass2.addClass("border-danger");
				$("#p2_error").html("<span class='text-danger'>Please enter more than 8 character password.</span>");
				status = false;
			}else{
				pass2.removeClass("border-danger");
				$("#p2_error").html("");
				status = true;
			}
			if(type.val() == ""){
				type.addClass("border-danger");
				$("#t_error").html("<span class='text-danger'>Please select user type.</span>");
				status = false;
			}else{
				type.removeClass("border-danger");
				$("#t_error").html("");
				status = true;
			}
			if (pass1.val() != pass2.val()){
				pass2.addClass("border-danger");
				$("#p2_error").html("<span class='text-danger'>Password is not matched.</span>");
				status = false;
			}
		if (!(name.val() == "" || name.val().length < 6 || name.val().length > 20) && !(email.val() == "") && !(!e_patt.test(email.val())) && !(pass1.val() == "" || pass1.val().length < 9) && !(pass2.val() == "" || pass2.val().length < 9) && !(type.val() == "") && !(pass1.val() != pass2.val()) && status == true){
			if ((pass1.val() == pass2.val()) && status == true) {	
					name.removeClass("border-danger");
					$("#u_error").html("");
					email.removeClass("border-danger");
					$("#e_error").html("");
					pass1.removeClass("border-danger");
					$("#p1_error").html("");
					pass2.removeClass("border-danger");
					$("#p2_error").html("");
					type.removeClass("border-danger");
					$("#t_error").html("");
					$(".overlay").show();
					$.ajax({
						url : DOMAIN+"/includes/process.php",
						method : "POST",
						data : $("#register_form").serialize(),
						success : function(data){
							if (data == "EMAIL_ALREADY_EXISTS") {
								$(".overlay").hide();
								alert("It seems like your email is already used.");
							}else if(data == "SOME_ERROR"){
								$(".overlay").hide();
								alert("Something Wrong");
							}else{
								$(".overlay").hide();
								window.location.href = encodeURI(DOMAIN+"/index.php?msg=Check your mail to activate your account "+email.val());
							}
						}
					})
					status = true;	
			}else{
				pass2.addClass("border-danger");
				$("#p2_error").html("<span class='text-danger'>Password is not matched.</span>");
				status = false;
			}
		}	
	})

	//For Login Part
	$("#form_login").on("submit",function(){
		var email = $("#log_email");
		var pass = $("#log_password");
		var status = false;
		//Mail ID Regular Expression (Example -> nirvedj2023@gmail.com)
		var e_patt = new RegExp(/^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9_-]+(\.[a-z0-9_-]+)*(\.[a-z]{2,3})$/);
		if (email.val() == "") {
			email.addClass("border-danger");
			$("#e_error").html("<span class='text-danger'>Please enter email address.</span>");
			status = false;
		}else{
			if(!e_patt.test(email.val())){
				email.addClass("border-danger");
				$("#e_error").html("<span class='text-danger'>Please enter valid email address.</span>");
				status = false;
			}else{
				email.removeClass("border-danger");
				$("#e_error").html("");
				status = true;
			}
		}
		if (pass.val() == "") {
			pass.addClass("border-danger");
			$("#p_error").html("<span class='text-danger'>Please enter password.</span>");
			status = false;
		}else{
			pass.removeClass("border-danger");
			$("#p_error").html("");
			status = true;
		}
		if (!(email.val() == "") && !(!e_patt.test(email.val())) && !(pass.val() == "") && status == true) {
			$(".overlay").show();
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : $("#form_login").serialize(),
				success : function(data){
					if (data == "NOT_REGISTERD") {
						$(".overlay").hide();
						email.addClass("border-danger");
						$("#e_error").html("<span class='text-danger'>It seems like you are not registered.</span>");
					}else if(data == "ACCOUNT_NOT_ACTIVATE"){
						$(".overlay").hide();
						window.location.href = encodeURI(DOMAIN+"/index.php?msg=Your account is not activate..! Please Check your mail to activate your account "+email.val());
					}else if(data == "PASSWORD_NOT_MATCHED"){
						$(".overlay").hide();
						pass.addClass("border-danger");
						$("#p_error").html("<span class='text-danger'>Please enter correct password.</span>");
						status = false;
					}else{
						$(".overlay").hide();
						console.log(data);
						window.location.href = DOMAIN+"/dashboard.php";
					}
				}
			})
		}
	})


	//Recover User Account (Email Send Verify Form)
	$("#recover_account_form").on("submit",function(){
		var status = false;
		var email = $("#recover_email");
		//Mail ID Regular Expression (Example -> nirvedj2023@gmail.com)
		var e_patt = new RegExp(/^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9_-]+(\.[a-z0-9_-]+)*(\.[a-z]{2,3})$/);
			if (email.val() == ""){
				email.addClass("border-danger");
				$("#recover_e_error").html("<span class='text-danger'>Please enter email address.</span>");
				status = false;
			}else{
				if(!e_patt.test(email.val())){
					email.addClass("border-danger");
					$("#recover_e_error").html("<span class='text-danger'>Please enter valid email address.</span>");
					status = false;
				}else{
					email.removeClass("border-danger");
					$("#recover_e_error").html("");
					status = true;
				}
			}
		if (!(email.val() == "") && !(!e_patt.test(email.val())) && status == true){
					email.removeClass("border-danger");
					$("#recover_e_error").html("");
					$(".overlay").show();
					$.ajax({
						url : DOMAIN+"/includes/process.php",
						method : "POST",
						data : $("#recover_account_form").serialize(),
						success : function(data){
							if (data == "NOT_REGISTERD") {
								$(".overlay").hide();
								email.addClass("border-danger");
								$("#recover_e_error").html("<span class='text-danger'>It seems like you are not registered.</span>");
							}else if(data == "SOME_ERROR"){
								$(".overlay").hide();
								alert("Something Wrong");
							}else if(data == "EMAIL_VERIFY"){
								$(".overlay").hide();
								window.location.href = encodeURI(DOMAIN+"/index.php?msg=Check your mail to reset your Account Password "+email.val());
							}else{
								$(".overlay").hide();
								alert(data);
							}
						}
					})
					status = true;
		}	
	})


	//Reset User Account Password
	$("#reset_password_form").on("submit",function(){
		var status = false;
		var pass1 = $("#reset_password1");
		var pass2 = $("#reset_password2");
			if(pass1.val() == "" || pass1.val().length < 9){
				pass1.addClass("border-danger");
				$("#reset_p1_error").html("<span class='text-danger'>Please enter more than 8 character password.</span>");
				status = false;
			}else{
				pass1.removeClass("border-danger");
				$("#reset_p1_error").html("");
				status = true;
			}
			if(pass2.val() == "" || pass2.val().length < 9){
				pass2.addClass("border-danger");
				$("#reset_p2_error").html("<span class='text-danger'>Please enter more than 8 character password.</span>");
				status = false;
			}else{
				pass2.removeClass("border-danger");
				$("#reset_p2_error").html("");
				status = true;
			}
			if (pass1.val() != pass2.val()){
				pass2.addClass("border-danger");
				$("#reset_p2_error").html("<span class='text-danger'>Password is not matched.</span>");
				status = false;
			}
			if ($("#reset_token").val() == ""){
				alert("Token Not Found");
				status = false;
			}
		if (!(pass1.val() == "" || pass1.val().length < 9) && !(pass2.val() == "" || pass2.val().length < 9) && !(pass1.val() != pass2.val()) && !($("#reset_token").val() == "") && status == true){
			if ((pass1.val() == pass2.val()) && status == true) {
					pass1.removeClass("border-danger");
					$("#reset_p1_error").html("");
					pass2.removeClass("border-danger");
					$("#reset_p2_error").html("");
					$(".overlay").show();
					$.ajax({
						url : DOMAIN+"/includes/process.php",
						method : "POST",
						data : $("#reset_password_form").serialize(),
						success : function(data){
							if(data == "TOKEN_NOT_FOUND"){
								$(".overlay").hide();
								alert("Token Not Found");
							}else if(data == "SOME_ERROR"){
								$(".overlay").hide();
								alert("Something Wrong");
							}else if(data == "PASSWORD_UPDATED"){
								$(".overlay").hide();
								window.location.href = encodeURI(DOMAIN+"/index.php?msg=Your Account Password has been Change Successfully..! happy Now you can login.");
							}else{
								$(".overlay").hide();
								alert(data);
							}
						}
					})
					status = true;	
			}else{
				pass2.addClass("border-danger");
				$("#reset_p2_error").html("<span class='text-danger'>Password is not matched.</span>");
				status = false;
			}
		}	
	})



	//For Logout Part
	$("#log_out").click(function(){
		if (confirm("Are you sure ? You want to logout..!")) {
			window.location.href = DOMAIN+"/logout.php";
		}
	})

	//For Delete Profile Part
	$("#delete_profile_form").on("submit",function(){
		var status = false;
		if ($("#dlog_password").val() == "") {
			$("#dlog_password").addClass("border-danger");
			$("#delp_error").html("<span class='text-danger'>Please enter password.</span>");
			status = false;
		}else{
			$("#dlog_password").removeClass("border-danger");
			$("#delp_error").html("");
			status = true;
		}
		if (!($("#dlog_password").val() == "") && status == true) {
		if (confirm("Are you sure ? You want to delete..!")) {
			$(".overlay").show();
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : $("#delete_profile_form").serialize(),
				success : function(data){
					if(data == "PASSWORD_NOT_MATCHED"){
						$(".overlay").hide();
						$("#dlog_password").addClass("border-danger");
						$("#delp_error").html("<span class='text-danger'>Please enter correct password.</span>");
						status = false;
					}else if(data == "SOME_ERROR"){
				 		$(".overlay").hide();
				 		alert("Something Wrong");
				 	}else if (data == "EMAIL_VERIFY") {
						$(".overlay").hide();
						window.location.href = encodeURI(DOMAIN+"/profile.php?msg=Check your mail to Permanently DELETE your account "+$("#dlog_email").val());
						manageUserid(1);
					}else{
						$(".overlay").hide();
						alert(data);
					}					
				}
			})
		}
		}
	})

	//For Update Profile Part
	$("#update_profile_form").on("submit",function(){
		var status = false;
		//Mail ID Regular Expression (Example -> nirvedj2023@gmail.com)
		var u_e_patt = new RegExp(/^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9_-]+(\.[a-z0-9_-]+)*(\.[a-z]{2,3})$/);
			if($("#update_username").val() == "" || $("#update_username").val().length < 6 || $("#update_username").val().length > 20){
				$("#update_username").addClass("border-danger");
				$("#update_u_error").html("<span class='text-danger'>Please enter name and name must be between 6 and 20 character.</span>");
				status = false;
			}else{
				$("#update_username").removeClass("border-danger");
				$("#update_u_error").html("");
				status = true;
			}
			if ($("#update_email").val() == "") {
				$("#update_email").addClass("border-danger");
				$("#update_e_error").html("<span class='text-danger'>Please enter email address.</span>");
				status = false;
			}else{
				if(!u_e_patt.test($("#update_email").val())){
					$("#update_email").addClass("border-danger");
					$("#update_e_error").html("<span class='text-danger'>Please enter valid email address.</span>");
					status = false;
				}else{
					$("#update_email").removeClass("border-danger");
					$("#update_e_error").html("");
					status = true;
				}
			}
			if($("#update_usertype").val() == ""){
				$("#update_usertype").addClass("border-danger");
				$("#update_t_error").html("<span class='text-danger'>Please select user type.</span>");
				status = false;
			}else{
				$("#update_usertype").removeClass("border-danger");
				$("#update_t_error").html("");
				status = true;
			}
			if (!($("#update_username").val() == "" || $("#update_username").val().length < 6 || $("#update_username").val().length > 20) && !($("#update_email").val() == "") && !(!u_e_patt.test($("#update_email").val())) && !($("#update_usertype").val() == "") && status == true) {
				 $(".overlay").show();
				 $.ajax({
				 	url : DOMAIN+"/includes/process.php",
				 	method : "POST",
				 	data : $("#update_profile_form").serialize(),
				 	success : function(data){
				 		if (data == "EMAIL_ALREADY_EXISTS") {
				 			$(".overlay").hide();
				 			alert("It seems like your email is already used.");
				 		}else if(data == "SOME_ERROR"){
				 			$(".overlay").hide();
				 			alert("Something Wrong");
				 		}else if(data == "EMAIL_CHANGE"){
				 			$(".overlay").hide();
				 			alert("Profile Update Successfully..! happy");
				 			window.location.href = encodeURI(DOMAIN+"/index.php?msg=Check your mail to activate your account "+$("#update_email").val());
				 		}else{
				 			$(".overlay").hide();
				 			alert("Profile Update Successfully..! happy");
							window.location.href = "";
				 		}
				 	}
				 })
			}
	})


	//PROFILE PASSWORD CHANGE
	$("#change_profile_password_form").on("submit",function(){
		var status = false;
		if ($("#current_password").val() == ""){
			$("#current_password").addClass("border-danger");
			$("#currentp_error").html("<span class='text-danger'>Please enter password.</span>");
			status = false;
		}else{
			$("#current_password").removeClass("border-danger");
			$("#currentp_error").html("");
			status = true;
		}
		if($("#update_password1").val() == "" || $("#update_password1").val().length < 9){
			$("#update_password1").addClass("border-danger");
			$("#update_p1_error").html("<span class='text-danger'>Please enter more than 8 character password.</span>");
			status = false;
		}else{
			$("#update_password1").removeClass("border-danger");
			$("#update_p1_error").html("");
			status = true;
		}
		if($("#update_password2").val() == "" || $("#update_password2").val().length < 9){
			$("#update_password2").addClass("border-danger");
			$("#update_p2_error").html("<span class='text-danger'>Please enter more than 8 character password.</span>");
			status = false;
		}else{
			$("#update_password2").removeClass("border-danger");
			$("#update_p2_error").html("");
			status = true;
		}
		if ($("#update_password1").val() != $("#update_password2").val()){
			$("#update_password2").addClass("border-danger");
			$("#update_p2_error").html("<span class='text-danger'>Password is not matched.</span>");
			status = false;
		}
		if (!($("#current_password").val() == "") && !($("#update_password1").val() == "" || $("#update_password1").val().length < 9) && !($("#update_password2").val() == "" || $("#update_password2").val().length < 9) && !($("#update_password1").val() != $("#update_password2").val()) && status == true){
			if (($("#update_password1").val() == $("#update_password2").val()) && status == true) {
					$("#current_password").removeClass("border-danger");
					$("#currentp_error").html("");
					$("#update_password1").removeClass("border-danger");
					$("#update_p1_error").html("");
					$("#update_password2").removeClass("border-danger");
					$("#update_p2_error").html("");
					$(".overlay").show();
					$.ajax({
						url : DOMAIN+"/includes/process.php",
						method : "POST",
						data : $("#change_profile_password_form").serialize(),
						success : function(data){
							if(data == "PASSWORD_NOT_MATCHED"){
								$(".overlay").hide();
								$("#current_password").addClass("border-danger");
								$("#currentp_error").html("<span class='text-danger'>Please enter correct password.</span>");
								status = false;
							}else if (data == "SOME_ERROR") {
								$(".overlay").hide();
								alert("Something Wrong");
							}else{
								$(".overlay").hide();
								window.location.href = encodeURI(DOMAIN+"/index.php?msg=Your Account Password has been Change Successfully..! happy Now you can login.");
							}					
						}
					})
					status = true;	
			}else{
				$("#update_password2").addClass("border-danger");
				$("#update_p2_error").html("<span class='text-danger'>Password is not matched.</span>");
				status = false;
			}
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

	//Add Category
	$("#category_form").on("submit",function(){
		if ($("#category_name").val() == "") {
			$("#category_name").addClass("border-danger");
			$("#cat_error").html("<span class='text-danger'>Please Enter Category Name</span>");
		}else{
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data  : $("#category_form").serialize(),
				success : function(data){
					if (data == "CATEGORY_ALREADY_EXISTS") {
						alert("Category is already exists.");
					}else if (data == "CATEGORY_ADDED") {
						$("#category_name").removeClass("border-danger");
						$("#cat_error").html("<span class='text-success'>New Category Added Successfully..!</span>");
						$("#category_name").val("");
						fetch_category();
					}else{
						alert(data);
					}
				}
			})
		}
	})


	//Add Brand
	$("#brand_form").on("submit",function(){
		if ($("#brand_name").val() == "") {
			$("#brand_name").addClass("border-danger");
			$("#brand_error").html("<span class='text-danger'>Please Enter Brand Name</span>");
		}else{
			$.ajax({
				url : DOMAIN+"/includes/process.php",
				method : "POST",
				data : $("#brand_form").serialize(),
				success : function(data){
					if (data == "BRAND_ALREADY_EXISTS") {
						alert("Brand is already exists.");
					}else if (data == "BRAND_ADDED") {
						$("#brand_name").removeClass("border-danger");
						$("#brand_error").html("<span class='text-success'>New Brand Added Successfully..!</span>");
						$("#brand_name").val("");
						fetch_brand();
					}else{
						alert(data);
					}
						
				}
			})
		}
	})

	//add product
	$("#product_form").on("submit",function(){
			$.ajax({
					url : DOMAIN+"/includes/process.php",
					method : "POST",
					data : $("#product_form").serialize(),
					success : function(data){
						if (data == "PRODUCT_ALREADY_EXISTS") {
							alert("Product is already exists.");
						}else if (data == "NEW_PRODUCT_ADDED") {
							alert("New Product Added Successfully..!");
							$("#product_name").val("");
							$("#select_cat").val("");
							$("#select_brand").val("");
							$("#product_price").val("");
							$("#product_qty").val("");

						}else{
							console.log(data);
							alert(data);
						}
						
					}
				})
	})



})