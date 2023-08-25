jQuery(document).ready(function() {

	var applicant_list_table= jQuery(".applicant_list_table table").DataTable({
		 "pageLength": 50,
		 "aaSorting": [],
		 "ordering": false,
		 'lengthMenu': [
             [1,5, 25, 50, 100, 200, 500, -1],
            [1,5, 25, 50, 100, 200, 500, 'All']
        ],
      'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
             return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
         }
       }, {
                target: 2,
                visible: false,
            }]
		
	});
       // Handle click on "Select all" control
   $('#rows-select-all').on('click', function(){
      // Get all rows with search applied
      var rows = applicant_list_table.rows({ 'search': 'applied' }).nodes();
      // Check/uncheck checkboxes for all rows in the table
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });
        var categoryIndex = 2;
      jQuery("#filterTable th").each(function (i) {
        if ($($(this)).html() == "Status") {
          categoryIndex = i; return false;
        }
      });
	jQuery(".applicant_list_table .dataTables_filter").append(jQuery("#loi_pdfbtn"));
      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          var selectedItem = jQuery('#sortbyStatus').val()
          var category = data[categoryIndex];
          if (selectedItem === "" || category.includes(selectedItem)) {
            return true;
          }
          return false;
        }
      );


      applicant_list_table.draw();
       // Handle click on "Select all" control
	   $('#rows-select-all').on('click', function(){
		  // Get all rows with search applied
		  var rows = applicant_list_table.rows({ 'search': 'applied' }).nodes();
		  $('input[type="checkbox"]', rows).prop('checked', this.checked);
	   });  
	   jQuery("#sortbyStatus").change(function (e) {
        applicant_list_table.draw();
      });
	   $('.loi_pdfbtn .send_applicant_notify').on('click', function(e){
		   e.preventDefault();
		   var rows = applicant_list_table.rows({ 'search': 'applied' }).nodes();
		  var allchecked=$('input[type="checkbox"]:checked', rows);
		  var att_status=jQuery("#sortbyStatus").val();
		  if(allchecked.length==0){
			  Swal.fire(
				  'Issue found',
				  'Please select atleast 1 applicant!',
				  'error'
				);
			  return false;
		  } 
		  if($(this).hasClass("send_applicant_notify") && att_status!="3"){
			  Swal.fire(
				  'Issue found',
				  'Please choose selected applicant option!',
				  'error'
				);
			  return false;
		  }
		  jQuery("#loading").show();
			var el = jQuery(this);
			
			var uev_id=[];
			jQuery(allchecked).each(function(i) {
				var cvalue = jQuery(this).val();
				uev_id.push(cvalue);
			});
			var action=el.attr("href");
			
			
				jQuery.ajax({
				method:'POST',  
				url : action,
				data : {uev_id:uev_id,att_status:att_status,multiple_users:true },
				dataType: 'JSON',
				success: function(data){
					jQuery("#loading").hide();
					if(data.success==false){
						Swal.fire(
						  'Issue found',
						  data.message,
						  'error'
						);
					}else{
						
					
					Swal.fire(
					  'Schedule Status',
					  data.message,
					  'success'
					);
					}
				}  
				});
		
			 
		 
	   });

	   // Handle click on checkbox to set state of "Select all" control
	   $('.applicant_list_table tbody').on('change', 'input[type="checkbox"]', function(){
		  if(!this.checked){
			 var el = $('#rows-select-all').get(0);
			 if(el && el.checked && ('indeterminate' in el)){
				el.indeterminate = true;
			 }
		  }
	   }); 
	   
});