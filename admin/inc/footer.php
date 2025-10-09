<script>
$(document).ready(function() {
	var body = $("body");
	var popup = "<div class='popup'></div>";
	var btnPermission =
		"<a class='btn-permission' style='width: 30px;text-align: center;float: right;  cursor: pointer'> <i class='fas fa-user-cog'></i> </a>";
	var tblData = $("#tblData");
	var dataTbl = $("#data-table");
	var uid = "";
	var s = 0;
	var e = $('.num2').val();
	var curPage = $('.current_page');
	var totalPage = $('.total_page');
	var totalData = $('.total_data');
	var btnEdit = "<input type='button' value='Edit' id='txt-edit-id' class='btnEdit'>";
	// Determine current active navigation option
	var currentNavOption = $('.navigation .menu ul li.active').data('opt');
	// Initialize these variables globally
	var searchOpt = 0;
	var searchVal = "";
	var searchField = "";

	var formDate = "";
	var endDate = "";
	var position = "";
	var searchTerm = "";
	var role = $('.navigation .menu ul li.active').data('role') || 1;

	// Function to handle button visibility based on role
	function handleButtonVisibility(role) {
		var addButton = $('.search-bar .btn-dark');
		var search = $('#attendanceForm');
		var reportSearch = $('#reportForm');
		if(role == 2){ // If user role is not admin (role 2 = read-only)
			reportSearch.hide();
			addButton.hide();
			search.hide();
		} else {
			reportSearch.show();
			addButton.show();
			search.show();
		}
	}

	// Initial button visibility check on page load
	handleButtonVisibility(role);

	$('.menu ul li').click(function() {
		var eThis 				= $(this);
		role 							= eThis.data('role');
		currentNavOption 	= eThis.data('opt');
		
		// Handle button visibility when menu changes
		handleButtonVisibility(role);
	});
	// Initial load of employees
	switch (currentNavOption) {
		case 0: get_dashboard();break;
		case 1: get_attendance();break;
		case 2: get_empoyee();break;
		case 3: get_leave();break;
		case 4: get_report(formDate, endDate, position, searchTerm);break;
		case 5: get_user();	break;
		case 6: get_user_app(); break;
		default:
			console.log("Unknown navigation option");
	}
	
	// Add popup to body
	$(".btn-dark").click(function() {
		var formUrl = (currentNavOption === 5) ?
			"form/form-user.php" :
			"form/form-add.php";
		if (currentNavOption === 6) {
			formUrl = "form/form-user-app.php";
		} 
		body.append(popup);
		$(".popup").load(formUrl, function(responseTxt, statusTxt, xhr) {
			if (statusTxt == "error") {
				alert("Error: " + xhr.status + ": " + xhr.statusText);
			}
		});

		// Close popup 
		body.on('click', '.btn.btn-danger', function() {
			$(".popup").remove();
		});
	});

	// save button when we click
	body.on('click', '.btn.btn-primary', function(e) {
		e.preventDefault(); // Prevent form submission if it's a submit button
		var eThis = $(this);
		switch (currentNavOption) {
			case 2: // Employee
				save_employee(eThis);
				break;
			case 5:
				save_user();
				break;
			case 6:
				save_user_app();
				break;
			default:
				console.log("Unknown navigation option");
		}
	});

	body.on('change', '#txt-file', function() {
		var eThis = $(this);
		var Parent = eThis.parents('.container'); // Get the closest container
		var frm = eThis.closest('form.upl');
		var formData = new FormData(frm[0]); // Create FormData object from the form
		var imgBox = Parent.find('.img-box');
		var photo = Parent.find('#txt-photo');

		$.ajax({
			url: 'action/upl-img.php',
			type: 'post',
			data: formData,
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {},
			success: function(data) {
				imgBox.css({
					"background-image": "url(img/image/" + data.imgName + ")"
				});
				photo.val(data.imgName);
			}
		})
	});

	function save_employee(eThis) {
		var Parent = eThis.parents('.container'); // Get the closest container

		var name_kh = Parent.find('#name-kh');
		var name_eng = Parent.find('#name-eng');
		var email = Parent.find('#txt-email');
		var position = Parent.find('#txt-position');
		var manager = Parent.find('#txt-manager');
		var branch = Parent.find('#txt-branch');
		var join_date = Parent.find('#join-date');
		var phone = Parent.find('#txt-phone');
		var address = Parent.find('#address');
		var photo = Parent.find('#txt-file');

		var form = eThis.closest('form.upl'); // Changed from .dpl to .upl to match your form class
		var formData = new FormData(form[0]);

		// Show loading state
		$.ajax({
			url: 'action/save_employee.php',
			type: 'POST',
			data: formData,
			contentType: false,
			cache: false,
			processData: false,
			// dataType: "json",
			beforeSend: function() {
				eThis.html("<i class='fas fa-spinner fa-spin'></i> Saving...");
				eThis.prop('disabled', true); // Disable the button to prevent multiple clicks
			},
			success: function(data) {
				$(".popup").remove();
				// Optional: reload the page to see changes
				location.reload();


			},
			error: function(xhr) {
				alert("Error saving: " + xhr.statusText);
			},
			complete: function() {
				// Reset button state even if there was an error
				$('.btn-primary').html("Save").prop('disabled', false);
				return;
			}
		});
	}

	// Replace the dummy save_user() with real logic
	function save_user() {
		var form = $('form.upl'); // Match user form
		var formData = new FormData(form[0]);

		$.ajax({
			url: 'action/save_user.php',
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false,
			cache: false,
			beforeSend: function() {
				$('.btn-primary').html("<i class='fas fa-spinner fa-spin'></i> Saving...").prop('disabled', true);
			},
			success: function() {
				$(".popup").remove();
				location.reload();
			},
			error: function(xhr) {
				alert("Error: " + xhr.statusText);
			},
			complete: function() {
				$('.btn-primary').html("Save").prop('disabled', false);
			}
		});
	}
	// Function to get user application data
	function save_user_app() {
    var form = $('form.upl');
    var formData = form.serialize(); // Use serialize() instead of FormData
    
    $.ajax({
        url: 'api/create_user.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        beforeSend: function() {
            $('.btn-primary').html("<i class='fas fa-spinner fa-spin'></i> Saving...").prop('disabled', true);
        },
        success: function(response) {
            if(response.status === 'success') {
                $(".popup").remove();
                location.reload();
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function(xhr) {
            try {
                var response = JSON.parse(xhr.responseText);
                alert("Error: " + response.message);
            } catch(e) {
                alert("Error: " + xhr.statusText);
            }
        },
        complete: function() {
            $('.btn-primary').html("Save").prop('disabled', false);
        }
    });
	}
	// Function to get dashboard data
	function get_dashboard() {
		var th = "<thead class='table-secondary'>" +
			" <tr > " +
			"<th scope='col'>ID</th>" +
			"<th scope='col'>Name Kh</th>" +
			"<th scope='col'>Name Eng</th>" +
			"<th scope='col'>Phone</th>" +
			"<th scope='col'>Department</th>" +
			"<th scope='col'>Branch</th>" +
			"</tr> </thead>";
		tblData.empty().append(th);
		

		$.ajax({
			url: 'action/get-dashboard.php',
			type: 'post',
			data: {
				id: 1
			},
			cache: false,
			dataType: "json",
			success: function(data) {
				console.log("Received data:", data);

				var num = data.length;
				var txt = "";
				for (var i = 0; i < num; i++) {
					txt += "<tbody> " +
						"<tr>" +
						"<td>" + data[i].id + "</td>" +
						"<td>" + data[i].name_kh + "</td>" +
						"<td>" + data[i].name_eng + "</td>" +
						"<td>" + data[i].phone + "</td>" +
						"<td>" + data[i].position + "</td>" +
						"<td>" + data[i].branch + "</td>" +
						"</tr></tbody>";
				}
				tblData.append(txt);
			}
		});
	}

	function get_attendance(formDate, endDate, position, searchTerm) {
		var dataTable = $("#data-table");
		var th = "<thead class='table-secondary'>" +
			"<tr>" +
			"<th scope='col'>ID</th>" +
			"<th scope='col'>Name</th>" +
			"<th scope='col'>Date</th>" +
			"<th scope='col'>Check In 1</th>" +
			"<th scope='col'>Check Out 1</th>" +
			"<th scope='col'>Check In 2</th>" +
			"<th scope='col'>Check Out 2</th>" +
			"<th scope='col'>Note</th>" +
			"</tr>" +
			"</thead>";

		dataTable.empty().append(th);

		// Get search parameters
		var formDate = $("#txt-from-date").val();
		var endDate = $("#txt-end-date").val();
		var position = $("#txt-position").val();
		var searchTerm = $("#txt-search").val();

		$.ajax({
			url: "action/get_attendance.php",
			type: "POST",
			data: {
				search_opt: searchOpt,
				from_date: formDate,
				end_date: endDate,
				position: position,
				search_term: searchTerm,
				s: s,
				e: e
			},
			dataType: "json",
			beforeSend: function() {
				$("#btn-search-report").html("<i class='fas fa-spinner fa-spin'></i> Searching...");
				$("#btn-search-report").prop('disabled', true);
			},
			success: function(data) {
				var tbody = "<tbody>";
				if (data.length > 0) {
					$.each(data, function(index, item) {
						tbody += "<tr>" +
							"<td>" + (item.employee_id || '') + "</td>" +
							"<td>" + (item.name_eng || '') + "</td>" +
							"<td>" + (item.attendance_date || '') + "</td>" +
							"<td>" + (item.check_in_1 || '-') + "</td>" +
							"<td>" + (item.check_out_1 || '-') + "</td>" +
							"<td>" + (item.check_in_2 || '-') + "</td>" +
							"<td>" + (item.check_out_2 || '-') + "</td>" +
							"<td>" + (item.note || '') + "</td>" +
							"</tr>";
					});
				} else {
					tbody += "<tr><td colspan='8' class='text-center'>No records found</td></tr>";
				}
				tbody += "</tbody>";
				totalData.text(data[0].total);
				totalPage.text(Math.ceil(data[0].total / e));
				dataTable.append(tbody);
			},
			error: function(xhr, status, error) {
				console.error("AJAX Error:", status, error);
				dataTable.append(
					"<tbody><tr><td colspan='8' class='text-center text-danger'>Error loading data</td></tr></tbody>"
				);
			},
			complete: function() {
				$("#btn-search-report").html("Search");
				$("#btn-search-report").prop('disabled', false);
			}
		});
	}
	// Function to get employee data
	function get_empoyee() {
    var th = "<thead class='table-secondary'>" +
        " <tr> " +
        "<th scope='col'>ID</th>" +
        "<th scope='col'>Name Kh</th>" +
        "<th scope='col'>Name Eng</th>" +
        "<th scope='col'>Phone</th>" +
        "<th scope='col'>Branch</th>" +
        "<th scope='col'>Manager</th>" +
        "<th scope='col'>Join Date</th>" +
        "<th scope='col'>Status</th>";

        if (role != 2) {
					th += "<th scope='col'>Action</th>";
				}
		th += "</tr> </thead>";
    tblData.empty(); // Clear the table before appending new data
    tblData.append(th);
    
		$.ajax({
			url: 'action/get_employee.php',
			type: 'post',
			data: {
					search_opt: searchOpt,
					searchVal: searchVal,
					searchField: searchField
			},
			cache: false,
			dataType: "json",
			success: function(data) {
				console.log("Received data:", data);

				var num = data.length;
				var txt = "";
				for (var i = 0; i < num; i++) {
					txt += "<tbody> " +
							"<tr>" +
							"<td>" + data[i].id + "</td>" +
							"<td>" + data[i].name_kh + "</td>" +
							"<td>" + data[i].name_eng + "</td>" +
							"<td>" + data[i].phone + "</td>" +
							"<td>" + data[i].branch + "</td>" +
							"<td>" + data[i].manager + "</td>" +
							"<td>" + data[i].join_date + "</td>" +
							"<td>" + (data[i].status == 1 ? "Active" : "Inactive") + "</td>";

							if(role != 2) {
								txt += "<td>" + btnEdit + "</td>";
							}
					
					txt += "</tr></tbody>";
				}
				tblData.append(txt)
			}
		});
	}

	function get_leave() {
		var dataTable = $("#data-table");
		var th = "<thead class='table-secondary'>" +
			"<tr>" +
			"<th scope='col'>ID</th>" +
			"<th scope='col'>Name</th>" +
			"<th scope='col'>Leave Type</th>" +
			"<th scope='col'>Start Date</th>" +
			"<th scope='col'>End Date</th>" +
			"<th scope='col'>Days</th>" +
			"<th scope='col'>Reason</th>" +
			"<th scope='col'>Status </th>" +
			"</tr>" +
			"</thead>";
		dataTable.empty().append(th);

		$.ajax({
			url: "action/get_leave.php",
			type: "POST",
			data: {
				from_date: formDate,
				end_date: endDate,
				position: position,
				search_term: searchTerm
			},
			dataType: "json",
			beforeSend: function() {
				$("#btn-search-report").html("<i class='fas fa-spinner fa-spin'></i> Searching...");
				$("#btn-search-report").prop('disabled', true);
			},
			success: function(data) {
				var txt = "";
				if (data.length === 0) {
					txt = "<tr><td colspan='9' class='text-center'>No data found.</td></tr>";
				} else {
					for (var i = 0; i < data.length; i++) {
						txt += "<tbody><tr>" +
							"<td>" + data[i].employee_id + "</td>" +
							"<td>" + data[i].name_eng + "</td>" +
							"<td>" + data[i].attendance_date + "</td>" +
							"<td>" + data[i].check_in_1 + "</td>" +
							"<td>" + data[i].check_out_1 + "</td>" +
							"<td>" + data[i].check_in_2 + "</td>" +
							"<td>" + data[i].check_out_2 + "</td>" +
							"<td>" + data[i].note + "</td>" +
							"</tr></tbody>";
					}
				}
				dataTable.append(txt); // Append tbody with content
			},
			error: function() {
				dataTable.append(
					"<tbody><tr><td colspan='9' class='text-center text-danger'> No Data. </td></tr></tbody>"
				);
			},
			complete: function() {
				$("#btn-search-report").html("Search");
				$("#btn-search-report").prop('disabled', false);
			}
		});
	}

	function get_report(formDate, endDate, position, searchTerm) {
		var dataTable = $("#data-table");
		var th =
			"<thead class='table-secondary'>" +
			"<tr>" +
			"<th scope='col'>ID</th>" +
			"<th scope='col'>Name KH</th>" +
			"<th scope='col'>Name ENG</th>" +
			"<th scope='col'>Attendance Date</th>" +
			"<th scope='col'>Check In 1</th>" +
			"<th scope='col'>Check Out 1</th>" +
			"<th scope='col'>Check In 2</th>" +
			"<th scope='col'>Check Out 2</th>" +
			"<th scope='col'>Note</th>" +
			"</tr>" +
			"</thead>";
		dataTable.empty(); // Clear the table before appending new data
		dataTable.append(th); // Append the header to the table

		$.ajax({
			url: "action/report.php",
			type: "POST",
			data: {
				from_date: formDate,
				end_date: endDate,
				position: position,
				search_term: searchTerm
			},
			dataType: "json",
			beforeSend: function() {
				$("#btn-search-report").html("<i class='fas fa-spinner fa-spin'></i> Searching...");
				$("#btn-search-report").prop('disabled', true);
			},
			success: function(data) {
				var txt = "";
				if (data.length === 0) {
					txt = "<tr><td colspan='9' class='text-center'>No data found.</td></tr>";
				} else {
					for (var i = 0; i < data.length; i++) {
						txt += "<tbody><tr>" +
							"<td>" + data[i].employee_id + "</td>" +
							"<td>" + data[i].name_kh + "</td>" +
							"<td>" + data[i].name_eng + "</td>" +
							"<td>" + data[i].attendance_date + "</td>" +
							"<td>" + data[i].check_in_1 + "</td>" +
							"<td>" + data[i].check_out_1 + "</td>" +
							"<td>" + data[i].check_in_2 + "</td>" +
							"<td>" + data[i].check_out_2 + "</td>" +
							"<td>" + data[i].note + "</td>" +
							"</tr></tbody>";
					}
				}
				dataTable.append(txt); // Append tbody with content
			},
			error: function() {
				dataTable.append(
					"<tbody><tr><td colspan='9' class='text-center text-danger'> No Data. </td></tr></tbody>"
				);
			},
			complete: function() {
				$("#btn-search-report").html("Search");
				$("#btn-search-report").prop('disabled', false);
			}
		});
	}

	function get_user() {
		var th = "<thead class='table-secondary'>" +
			" <tr > " +
			"<th scope='col'>ID</th>" +
			"<th scope='col'>Username</th>" +
			"<th scope='col'>Email</th>" +
			"<th scope='col'>Type</th>" +
			"<th scope='col'>IP</th>" +
			"<th scope='col'>Status</th>";
			if (role != 2) {
					th += "<th scope='col' width=50>Action</th>";
				}
		th += "</tr> </thead>";
		tblData.empty(); // Clear the table before appending new data
		tblData.append(th);

		// Debug info
		console.log("Sending to PHP:", {
			searchVal: searchVal,
			searchField: searchField
		});
		$.ajax({
			url: 'action/get_user.php',
			type: 'post',
			data: {
				search_opt: searchOpt,
				searchVal: searchVal,
				searchField: searchField
			},
			cache: false,
			dataType: "json",
			success: function(data) {
				console.log("Received data:", data);

				var num = data.length;
				var txt = "";
				for (var i = 0; i < num; i++) {
					txt += "<tbody> " +
						"<tr>" +
						"<td>" + data[i].id + "</td>" +
						"<td class= 'u-box-name'>" + data[i].username;
						if (role != 2) {
                    txt += btnPermission;
                }
            txt += "</td>" +
						"<td>" + data[i].u_email + "</td>" +
						"<td>" + (data[i].u_type == 1 ? "Admin" : "User") + "</td>" +
						"<td>" + data[i].u_ip + "</td>" +
						"<td>" + (data[i].status == 1 ? "Active" : "Inactive") + "</td>" ;
						if(role != 2) {
							txt += "<td>" + btnEdit + "</td>";
						}
					txt += "</tr></tbody>";
				}
				tblData.append(txt);
			}
		});
	}
	function get_user_app() {
			var th = "<thead class='table-secondary'>" +
			" <tr > " +
			"<th scope='col'>ID</th>" +
			"<th scope='col'>Employee ID</th>" +
			"<th scope='col'>Username</th>" +
			"<th scope='col'>Email</th>" +
			"<th scope='col'>Role</th>" +
			"<th scope='col'>Status</th>"+
			"<th scope='col'>Action</th>"+
			"</thead>";
		tblData.empty(); // Clear the table before appending new data
		tblData.append(th);
		// Debug info
		console.log("Sending to PHP:", {
			searchVal: searchVal,
			searchField: searchField
		});
		$.ajax({
			url: 'api/get_user.php',
			type: 'post',
			data: {
				search_opt: searchOpt,
				searchVal: searchVal,
				searchField: searchField
			},
			cache: false,
			dataType: "json",
			success: function(data) {
				console.log("Received data:", data);

				var num = data.length;
				var txt = "";
				for (var i = 0; i < num; i++) {
					txt += "<tbody> " +
						"<tr>" +
						"<td>" + data[i].id + "</td>" +
						"<td>" + data[i].employee_id + "</td>" +
						"<td>" + data[i].username +
						"<td>" + data[i].email + "</td>" +
						"<td>" + (data[i].role == 1 ? "Employee" : "Admin") + "</td>" +
						"<td>" + (data[i].status == 1 ? "Active" : "Inactive") + "</td>" ;
						if(role != 2) {
							txt += "<td>" + btnEdit + "</td>";
						}
					txt += "</tr></tbody>";
				}
				tblData.append(txt);
			}
		});
	}

	function get_edit_employee(id) {
		$.ajax({
			url: 'action/get_edit_employee.php',
			type: 'post',
			data: {
				id: id
			},
			dataType: 'json',
			success: function(data) {
				// Populate form fields with employee data
				$('.upl #name-kh').val(data.name_kh);
				$('.upl #name-eng').val(data.name_eng);
				$('.upl #txt-email').val(data.email);
				$('.upl #txt-position').val(data.position);
				$('.upl #txt-manager').val(data.manager);
				$('.upl #txt-branch').val(data.branch);
				$('.upl #join-date').val(data.join_date);
				$('.upl #txt-phone').val(data.phone);
				$('.upl #address').val(data.address);
				$('.upl #txt-photo').val(data.photo);
				$('.upl #txt-gender').val(data.gender);
				$('.upl #txt-status').val(data.status);
				// Set the image if photo exists
				if (data.photo) {
					$('.img-box').css({
						"background-image": "url(img/image/" + data.photo + ")"
					});
				}
				// Add hidden field for edit mode
				$('.upl').append('<input type="hidden" name="id" value="' + data.id + '">');

			}
		});
		body.on('click', '.btn.btn-danger', function() {
			$(".popup").remove();
		});
	}

	function get_edit_user(id) {
		$.ajax({
			url: 'action/get_edit_user.php',
			type: 'post',
			data: {
				id: id
			},
			dataType: 'json',
			success: function(data) {
				// Populate form fields with user data
				$('.upl #txt-id').val(data.id);
				$('.upl #txt-username').val(data.username);
				$('.upl #txt-email').val(data.u_email);
				$('.upl #txt-password').val(data.password);
				$('.upl #txt-user-type').val(data.u_type);
				$('.upl #txt-ip').val(data.u_ip);
				$('.upl #txt-status').val(data.status);
			}
		});
		body.on('click', '.btn.btn-danger', function() {
			$(".popup").remove();
		});
	}

	function get_edit_user_app(id) {
		alert("Edit User Application is not implemented yet.");
	}

	body.on("click", ".btn-permission", function() {
		var eThis = $(this);
		uid = eThis.parents("tr").find('td:eq(0)').text(); // Declare uid with var
		body.append(popup);

		$(".popup").load("form/form-permission.php", function(responseTxt, statusTxt, xhr) {
			if (statusTxt == "success") {
				body.find('.btn .btn-secondary h6').text("User Permission");
				$.ajax({
					url: 'action/get-user-permission.php',
					type: 'post',
					data: {
						'uid': uid
					},
					cache: false,
					dataType: "json",
					success: function(data) {
						for (var i = 0; i < data.length; i++) {
							body.find("table#tblPermission tr").each(function() {
							var currentMid = $(this).find('th:eq(0) span').text();
							if (currentMid == data[i].mid) {
								$(this).find('td select').val(data[i].aid);
								console.log("Set value for mid", data[i].mid, "to", data[i].aid);
							}
						});
						}
					}
				});
				body.on('click', '.btn.btn-danger', function() {
			$(".popup").remove();
		});
			}
		});
	});


	body.on("change", 'table#tblPermission tr td select', function() {
		var eThis = $(this);
		var Parent = eThis.parents("tr");
		var mid = Parent.find('th:eq(0) span').text();
		var actionID = eThis.val(); 

		$.ajax({
			url: 'action/set-permission.php',
			type: 'post',
			data: {
				'uid': uid,
				'mid': mid,
				'aid': actionID
			},
			dataType: "json",
			success: function(data) {}
		});

		
	})

	// Edit button click handler
	body.on('click', '.btnEdit', function() {
		var Parent = $(this).parents('tr');
		var id = Parent.find('td:eq(0)').text();
		var formUrl = (currentNavOption === 5) ?
			"form/form-user.php" :
			"form/form-add.php";
		if (currentNavOption === 6) {
			formUrl = "form/form-user-app.php";
		}
		body.append(popup);
		$(".popup").load(formUrl, function(responseTxt, statusTxt, xhr) {
			if (statusTxt == "success") {
				get_edit_employee(id); // Call the function to populate the form with employee data
				if (currentNavOption === 5) {
					get_edit_user(id); // Call the function to populate the form with user data
				}
				else if (currentNavOption === 6) {
					get_edit_user_app(id); // Call the function to populate the form with user application data
				}
			}
			if (statusTxt == "error") {
				alert("Error: " + xhr.status + ": " + xhr.statusText);
			}
		});
	});
	// Report search button click handler
	$("#btn-search-report").click(function() {
		// Get values from the form fields
		var formDate = $("#txt-from-date").val();
		var endDate = $("#txt-end-date").val();
		var position = $("#txt-position").val();
		var searchTerm = $("#txt-search").val();
		var searchOpt = 1;

		// Validate input fields
		if (!formDate || !endDate || !position || !searchTerm) {
			alert("Please fill in From Date, End Date, Position, and Search Term.");
			return;
		}
		// Debug info
		console.log("Search Parameters:", {
			formDate: formDate,
			endDate: endDate,
			position: position,
			searchTerm: searchTerm
		});

		// Reset pagination variables
		s = 0;
		curPage.text(1);
		// Call the appropriate function based on the current navigation option
		switch (currentNavOption) {
			case 1: // Attendance
				get_attendance(formDate, endDate, position, searchTerm);
				break;
			case 3: // Leave (if implemented)
				get_leave();
				break;
			case 4: // Report
				get_report(formDate, endDate, position, searchTerm);
				break;
				// case 5:
				//   get_user();
				//   break;
			default:
				console.log("Unknown navigation option");
		}
	});

	$('#btn-search').click(function() {
		searchOpt = 1;
		searchVal = $('#txt-search-val').val();
		searchField = $('#txt-search-field').val();
		if (searchVal == '0') {
			return;
		} else if (searchField == ' ') {
			return;
		}
		switch (currentNavOption) {
			case 2: // Employee
				get_empoyee();
				break;
			case 5: // User
				get_user();
				break;
			case 6: // User Application
				get_user_app();
				break;
			default:
				console.log("Unknown navigation option");
		}
	});
	// //filter data
	$('.row-page').on('change', 'ul li .num2', function() {
		e = $(this).val();
		s = 0;
		curPage.text(1);
		get_attendance(formDate, endDate, position, searchTerm);

	})

	//next data
	$('.btn-next').click(function() {
		if (parseInt(curPage.text()) == parseInt(totalPage.text())) {
			return;
		}
		s = parseInt(s) + parseInt(e);
		curPage.text(parseInt(curPage.text()) + 1);
		get_attendance(formDate, endDate, position, searchTerm);
	});

	$('.btn-back').click(function() {
		if (parseInt(curPage.text()) == 1) {
			return;
		}
		s = parseInt(s) - parseInt(e);
		curPage.text(parseInt(curPage.text()) - 1);
		get_attendance(formDate, endDate, position, searchTerm);
	});
});
</script>