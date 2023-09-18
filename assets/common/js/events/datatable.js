jQuery(document).ready(function() {

	var applicant_list_table= jQuery(".applicant_list_table .select-table").DataTable({
		 "pageLength": 50,
		 "aaSorting": [],
		  "scrollX": true,
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
                target: 1,
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
      var categoryIndex = 1;
      jQuery("#filterTable th").each(function (i) {
        if ($($(this)).html() == "Department") {
          categoryIndex = i; return false;
        }
      });
	jQuery(".applicant_list_table .dataTables_filter").append(jQuery("#schedule_bydept"));
      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          var selectedItem = jQuery('#departmentFilter').val()
          var category = data[categoryIndex];
          if (selectedItem === "" || category.includes(selectedItem)) {
            return true;
          }
          return false;
        }
      );

      jQuery("#departmentFilter").change(function (e) {
        applicant_list_table.draw();
      });

      applicant_list_table.draw();
       // Handle click on "Select all" control
	   $('#rows-select-all').on('click', function(){
		  // Get all rows with search applied
		  var rows = applicant_list_table.rows({ 'search': 'applied' }).nodes();
		  $('input[type="checkbox"]', rows).prop('checked', this.checked);
	   });  
	   
	   $('.schedule_bydept').on('click', function(){
		  // Get all rows with search applied
		  var rows = applicant_list_table.rows({ 'search': 'applied' }).nodes();
		  var allchecked=$('input[type="checkbox"]:checked', rows);
		  var schedule=jQuery("#scheduleFilter").val();
		  if(allchecked.length==0){
			  Swal.fire(
				  'Issue found',
				  'Please select atleast 1 applicant!',
				  'error'
				);
			  return false;
		  } 
		  if(schedule==""){
			  Swal.fire(
				  'Issue found',
				  'Please choose any one schedule!',
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
			var action=el.attr("data-action");
			
			if(schedule!=""){
				jQuery.ajax({
				method:'POST',  
				url : action,
				data : {id:uev_id,schedule:schedule,multiple_users:true },
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
			}else{
				Swal.fire(
				   'Schedule Status',
				  "You have not assigned any schedule to this candidate",
				  'error'
				);
				jQuery("#loading").hide();

			}
			
		 
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