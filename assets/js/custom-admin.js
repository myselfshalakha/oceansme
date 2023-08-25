jQuery(document).ready(function() {
	
	// Token for any ajax
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
	
	//Any delete icon action button and remove itemee by ajax
     jQuery(document).on('click','.delete_record',function(){
		
        var el = jQuery(this);
        var id=jQuery(this).attr("data-id");
        var action=jQuery(this).attr("data-action");
        Swal.fire({
          title: 'Are you sure?',
		  text: "Do you really want to delete this? You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes!'
        }).then((result) => {
              if (result.value) {  
				jQuery("#loading").show();			  
                jQuery.ajax({
                    method:'POST',  
                    url : action,
                    data : {id:id },
                    dataType: 'JSON',
                    success: function(data){
						jQuery("#loading").hide();
                        if(data.success === true){
                           Swal.fire(
							  'Deleted!',
							  data.message,
							  'success'
							);
							setTimeout(function(){
								
							location.reload();
								
							},2500);
                        }else{
							Swal.fire(
							  'Issue found!',
							  data.message,
							  'error'
							);
						}
						
                      /*   Messenger.options = {
                            extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
                            theme: 'flat'
                        }
                        Messenger().post({
                            message: data.message,
                            type: 'success',
                            showCloseButton: true
                        }); */
                    }   
                });
              } else{
				jQuery("#loading").hide();
			  }
        });
    });
	
	//Send Csv to Agency
     jQuery(document).on('click','.send_csv_agency',function(){
		
        var el = jQuery(this);
        var id=el.attr("data-id");
        var action=el.attr("data-action");
          jQuery("#loading").show();			  
		jQuery.ajax({
			method:'POST',  
			url : action,
			data : {id:id },
			dataType: 'JSON',
			success: function(data){
				jQuery("#loading").hide();
				if(data.success === true){
				   Swal.fire(
					  data.message,
					  '',
					  'success'
					);
					
				}else{
					Swal.fire(
					  'Issue found!',
					  data.message,
					  'error'
					);
				}
				
			}   
		});
      
    });
	
	//Any applicant request to recheck application
     jQuery(document).on('click','.request_to_recheck',function(){
        var el = jQuery(this);
        var id=jQuery(this).attr("data-id");
        var request=jQuery(this).attr("data-request");
        var action=jQuery(this).attr("data-action");
              
			jQuery.ajax({
				method:'POST',  
				url : action,
				data : {id:id , requestStatus:request },
				dataType: 'JSON',
				success: function(data){
					 Swal.fire(
							  'Deleted!',
							  data.message,
							  'success'
							);
					/* Messenger.options = {
						extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
						theme: 'flat'
					}
					Messenger().post({
						message: data.message,
						type: 'success',
						showCloseButton: true
					}); */
						setTimeout(function(){
								
							location.reload();
								
							},2500);
				}   
			});
              
    });
	
	//change Status of events from the list
	jQuery(document).on('click','.change_status',function(){
        var el = jQuery(this);
        var id=jQuery(this).attr("data-id");
        var action=jQuery(this).attr("data-action");
        var evStatus=jQuery(this).siblings(".applicanteventStatus").val();
        jQuery(".evMessage").val("Email Message content...");
        jQuery(".evStatus").val(evStatus).change();
        jQuery("#save__applicant_status").attr("data-id",id);
    });
	
	//change interviewer of applicants 
	jQuery(document).on('click','.change_interviewer',function(){
        var el = jQuery(this);
        var id=jQuery(this).attr("data-id");
        var action=jQuery(this).attr("data-action");
        var interviewer=jQuery(this).siblings(".applicantInterViewerSelect").val();
		jQuery.ajax({
			method:'POST',  
			url : action,
			data : {id:id,interviewer:interviewer },
			dataType: 'JSON',
			success: function(data){
				Swal.fire(
					  'Succeed',
					  data.message,
					  'success'
					);
				/* Messenger.options = {
					extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
					theme: 'flat'
				}
				Messenger().post({
					message: data.message,
					type: 'success',
					showCloseButton: true
				}); */
			}   
		});
    });
	
	//change Status of events from the popup
	jQuery(document).on('click','#save__applicant_status',function(){
        var el = jQuery(this);
        var id=jQuery(this).attr("data-id");
        var action=jQuery(this).attr("data-action");
        var evStatus=jQuery(".evStatus").val();
        var evContent=jQuery(".evMessage").val();
		jQuery.ajax({
			method:'POST',  
			url : action,
			data : {id:id,status:evStatus,content:evContent },
			dataType: 'JSON',
			success: function(data){
				Swal.fire(
					  'Succeed',
					  data.message,
					  'success'
					);
				if(data.success === true){
					setTimeout(function(){
								
							location.reload();
								
							},2500);
				}
				/* Messenger.options = {
					extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
					theme: 'flat'
				}
				Messenger().post({
					message: data.message,
					type: 'success',
					showCloseButton: true
				}); */
			}   
		});
    });
	
	//change Status of attending applicant from the popup
	jQuery(document).on('click','#save__attending_status',function(){
        var el = jQuery(this);
        var id=jQuery(this).attr("data-id");
        var action=jQuery(this).attr("data-action");
        var evStatus=jQuery(".applicanteventStatus").val();
		jQuery.ajax({
			method:'POST',  
			url : action,
			data : {id:id,status:evStatus },
			dataType: 'JSON',
			success: function(data){
				Swal.fire(
					  'Succeed',
					  data.message,
					  'success'
					);
				if(data.success === true){
					setTimeout(function(){
								
							location.reload();
								
							},2500);
				}
				/* Messenger.options = {
					extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
					theme: 'flat'
				}
				Messenger().post({
					message: data.message,
					type: 'success',
					showCloseButton: true
				}); */
			}   
		});
    });
	
	//change final salary
	jQuery(document).on('click','#save__salary',function(){
        var el = jQuery(this);
        var id=jQuery(this).attr("data-id");
        var action=jQuery(this).attr("data-action");
        var salary=jQuery(".salary_final").val();
		jQuery.ajax({
			method:'POST',  
			url : action,
			data : {id:id,salary:salary },
			dataType: 'JSON',
			success: function(data){
				Swal.fire(
					  'Succeed',
					  data.message,
					  'success'
					);
				if(data.success === true){
					setTimeout(function(){
								
							location.reload();
								
							},2500);
				}
				/* Messenger.options = {
					extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
					theme: 'flat'
				}
				Messenger().post({
					message: data.message,
					type: 'success',
					showCloseButton: true
				}); */
			}   
		});
    });
	
	//send event notify to candidate  by hr
	jQuery(document).on('click','#send_applicant_notify',function(){
        var el = jQuery(this);
        var id=jQuery(this).attr("data-id");
        var action=jQuery(this).attr("data-action");
        var thisForm=jQuery(this).closest("form");
        var ev_notify_message=jQuery(".notify_message",thisForm).val();
        var ev_notify_attach=jQuery(".notify_attach",thisForm);
		var fileExtension = ['pdf', 'doc', 'docx'];
		var errorMessage="";
        if ($.inArray(ev_notify_attach.val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            errorMessage="Only formats are allowed : "+fileExtension.join(', ');
        }else if(ev_notify_message==""){
			errorMessage="Type Some Message for Applicant...";
		}
		if(errorMessage!=""){
			Swal.fire(
					  'Issue found',
					  errorMessage,
					  'error'
					);
			/* Messenger.options = {
					extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
					theme: 'flat'
				}
				Messenger().post({
					message: errorMessage,
					type: 'error',
					showCloseButton: true
				}); */
				return;
		}
		var ev_attach = ev_notify_attach.prop('files')[0];   

        var formData=new FormData();
        formData.append('id', id);
        formData.append('ev_attach', ev_attach);
        formData.append('ev_notify_message', ev_notify_message);
        
		jQuery.ajax({
			method:'POST',
            dataType:'JSON',
		   contentType: false,
		   cache: false,
		   processData: false,	
			url : action,
            data: formData,
			success: function(data){
				Swal.fire(
					  'Succeed',
					  data.message,
					  'success'
					);
				/* Messenger.options = {
					extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
					theme: 'flat'
				}
				Messenger().post({
					message: data.message,
					type: 'success',
					showCloseButton: true
				}); */
			}   
		});
    });
	
	//send event notify to candidate  single page
	jQuery(document).on('click','#send_event_notify',function(){
        var el = jQuery(this);
        var id=jQuery(this).attr("data-id");
        var action=jQuery(this).attr("data-action");
        var thisForm=jQuery(this).closest("form");
        var ev_notify_message=jQuery(".notify_message",thisForm).val();
		jQuery.ajax({
			method:'POST',  
			url : action,
			data : {id:id,message:ev_notify_message },
			dataType: 'JSON',
			success: function(data){
			if(data.success==true){
				
							Swal.fire(
								  'Succeed',
								  data.message,
								  'success'
								);
			}else{
				Swal.fire(
								  'Issue found',
								  data.message,
								  'error'
								);
			}
				/* Messenger.options = {
					extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
					theme: 'flat'
				}
				Messenger().post({
					message: data.message,
					type: 'success',
					showCloseButton: true
				}); */
			}   
		});
    });
	
		//send event notify to candidate  list page
	jQuery(".applicant_email_modal_link").on("click",function(e){
		e.preventDefault();
		var dataID= jQuery(this).attr("data-id");
		jQuery("#send_event_notify").attr("data-id",dataID);
		jQuery('#applicant_email_modal textarea').val("");
		jQuery('#applicant_email_modal').modal("show");
		return false;
	});
	
	
	//Event Start and End Date field date picker
	if($( "#start_date" ).length){
		 $( "#start_date" ).datepicker();
		 $("#start_date").datepicker('setDate',$("#start_date").val());
		 $("#start_date").datepicker('setStartDate',$("#start_date").val());
		$("#start_date").datepicker('setEndDate',$("#end_date").val());
		$('#start_date').datepicker().on('changeDate', function(ev){
			$('#end_date').datepicker('setStartDate', new Date($(this).val()));
			$('#schedule_date').datepicker('setStartDate', new Date($(this).val()));
			$(this).datepicker('hide');
		}); 
	}
	if($( "#end_date" ).length){
		$( "#end_date" ).datepicker();
		 $("#end_date").datepicker('setDate',$("#end_date").val());
		$("#end_date").datepicker('setStartDate',$("#start_date").val());

	
		$('#end_date').datepicker().on('changeDate', function(ev){
			$('#start_date').datepicker('setEndDate', new Date($(this).val()));
			$('#schedule_date').datepicker('setEndDate', new Date($(this).val()));
			$(this).datepicker('hide');
		}); 
	}
	if($( "#schedule_date" ).length){
		$( "#schedule_date" ).datepicker();
		  $("#schedule_date").datepicker('setDate',new Date($("#schedule_date").val()));
		$("#schedule_date").datepicker('setStartDate',$("#schedule_date").attr("data-start"));
		$("#schedule_date").datepicker('setEndDate',$("#schedule_date").attr("data-end"));
		$('#schedule_date').datepicker().on('changeDate', function(ev){
			$(this).datepicker('hide');
		});  
	}
	if($( "#schedule_time" ).length){
		$( "#schedule_time" ).daterangepicker({
			timePicker : true,
            singleDatePicker:true,
             timePicker24Hour : false,
            timePickerIncrement : 1,
            // timePickerSeconds : true,
            locale: {
                format: 'hh:mm A'
            }
        }).on('show.daterangepicker', function(ev, picker) {
             picker.container.find(".calendar-table").hide();
        })
		
	}
	
	
	
	//Birthdate of user profile
	if($( "#birthdate" ).length){
		  $( "#birthdate" ).datepicker({
			 changeMonth : true,
				changeYear : true,
				 endDate: '-1d'
		 });
		$("#birthdate").datepicker('setDate',$("#birthdate").val());
		$('#birthdate').datepicker().on('changeDate', function(ev){
			$(this).datepicker('hide');
		}); 
	}
	//Admin sidebar active menu
	var current = location.pathname;
     var sidebar = $('.sidebar');
    $('.nav li a', sidebar).each(function(){
        var $this = $(this);
        // if the current path is like this link, make it active
        if($this.attr('href').indexOf(current) !== -1){
            $this.closest(".nav_item_main").addClass('active');
            $this.closest(".collapse").addClass('active');
            $this.closest(".collapse").addClass('show');
        }
    })
	
	//Event Jobs, restrictedCountries, and evaluator multiple seletcor
	if($("#ev_departments").length){
		$("#ev_departments").select2({placeholder: "Choose any one option..."});
		
		 $('#ev_departments').on('change', function(e) {
			 var action=$(this).attr('data-action');
			 var departments=$(this).val();
			 var selectedPosts=$('#ev_post').val();
			 var selectedEvaluators=$('#ev_evaluator').val();
			if(departments.length!=0){
				
				jQuery.ajax({
					method:'POST',  
					url : action,
					data : {departments:departments,posts:selectedPosts,evaluators:selectedEvaluators },
					dataType: 'JSON',
					success: function(data){
						$("#ev_post").html("");
						$("#ev_evaluator").html("");
						$("#ev_post").html(data.post);
						$("#ev_evaluator").html(data.evaluator);
						
					}   
				});
			}else{
				$("#ev_post").html("");
				$("#ev_evaluator").html("");
			}
			//console.log('Selecting: ' , e.params.args.data);
		  });
	}
	if($("#ev_post").length){
		$("#ev_post").select2({placeholder: "Choose any one option..."});
	}
	if($("#ev_evaluator").length){
		$("#ev_evaluator").select2({placeholder: "Choose any one option..."});
	}
	if($("#restrictedCountries").length){
		$("#restrictedCountries").select2({placeholder: "Choose any one option..."});
	}
	
	//User profile bio Skills, language and hobbies multiple selector
	if($("#skills").length){
		$("#skills").select2({tags: true});
	}
	if($("#hobbies").length){
		$("#hobbies").select2({tags: true});
	}
	if($("#languages").length){
		$("#languages").select2({tags: true});
	}
	
	//Hr Agencies countries
	if($("#agency_country_id").length){
		$("#agency_country_id").select2({tags: true});
	}
	
	//evaluator departments
	if($("#departments_select").length){
		$("#departments_select").select2({tags: true});
	}
	
	//Profile Canvas PieChart
	if(jQuery("#chartContainer").length!=0){
		var pieChartValues = [{
		  y: 20,
		  indexLabel: "Update Bio",
		  color: "#1f77b4"
		}, {
		  y: 20,
		  indexLabel: "Upload Profile Image",
		  color: "#ff7f0e"
		}, {
		  y: 50,
		  indexLabel: "Upload Resume",
		  color: " #ffbb78"
		}, {
		  y: 5,
		  indexLabel: "Registration",
		  color: "#248f8f"
		}, {
		  y: 5,
		  indexLabel: "Email verification",
		  color: "#d62728"
		}];
		renderPieChart(pieChartValues);

		function renderPieChart(values) {

		  var chart = new CanvasJS.Chart("chartContainer", {
			backgroundColor: "white",
			colorSet: "colorSet2",
			height:350,
			title: {
			  text: "How Works Profile Completion Status",
			  fontFamily: "Verdana",
			  fontSize: 25,
			  fontWeight: "normal",
			},
			animationEnabled: true,
			data: [{
			  indexLabelFontSize: 15,
			  indexLabelFontFamily: "Monospace",
			  indexLabelFontColor: "darkgrey",
			  indexLabelLineColor: "darkgrey",
			  indexLabelPlacement: "outside",
			  type: "pie",
			  showInLegend: false,
			  toolTipContent: "<strong>#percent%</strong>",
			  dataPoints: values
			}]
		  });
		  chart.render();
		}
	
	}
		
		
	//Event Apply handle
	jQuery("#applyeventForm").on("submit",function(e){
		e.preventDefault();
		jQuery('.apply_error').html();
		jQuery('#loading').show();
		var id= jQuery("#checkuserevent").attr("data-id");
		var action= jQuery("#checkuserevent").attr("data-action");
		  jQuery.ajax({
				method:'POST',  
				url : action,
				dataType: 'JSON',
				data : {id:id },
				success: function(data){
					if(data.success==false){
							jQuery('#loading').hide();
							var ErrorMessage='<ul class="apply_error">';
							for(i=0;i<data.message.length;i++){
								ErrorMessage+="<li>"+data.message[i]+"</li>";
							}
							ErrorMessage+="</ul>";
							console.log(ErrorMessage);
							
							Swal.fire({
							   title: "Details Required:",  
							  html: ErrorMessage,  
							 
							});
							//jQuery('.bottom_alert').html('<strong>'+data.message+'</strong>');
						}else{
							var $form = jQuery('#applyeventForm');
							$form.get(0).submit();
						}
				}   
			});
	});
	jQuery(".event_apply_btn").on("click",function(){
		jQuery('.apply_error').html();
		if(jQuery(this).hasClass("hasEventFields")){
			var scrollPos =  jQuery("#required_infosection").offset().top;
			jQuery(window).scrollTop(scrollPos);
			//jQuery("#required_infosection").focus();
		}else{
			jQuery('#loading').show();
			var id= jQuery("#checkuserevent").attr("data-id");
			var action= jQuery("#checkuserevent").attr("data-action");
			  jQuery.ajax({
					method:'POST',  
					url : action,
					dataType: 'JSON',
					data : {id:id },
					success: function(data){
						
						if(data.success==false){
							jQuery('#loading').hide();
							jQuery('.top_alert').html('<strong>'+data.message+'</strong>');
							
						}else{
							var $form = jQuery('#eventsapplyform');
							$form.get(0).submit();
						}
							
					}   
				});
		}
	});
	
	/* Cv Loader Preview Modal */
	jQuery("body").on("click",".resume_icon_preview",function(e){
		e.preventDefault();
		var filelink = jQuery(this).attr("href");
		var $applicantResumeModal = jQuery('#applicant_resume_modal');
		var $modalBody = $applicantResumeModal.find('.modal-body');

		$modalBody.empty();
		$applicantResumeModal.modal("show");

		var iframeSrc = `https://docs.google.com/viewer?embedded=true&url=${filelink}`;
		var iframeHtml = `<iframe src="${iframeSrc}" id="resume_preview_area" class="resume_preview_area" height="600" width="100%" onload="this.removeAttribute('srcdoc')"></iframe>`;
		$modalBody.html(iframeHtml);

		var resume_preview_area = document.getElementById('resume_preview_area');
		resume_preview_area.srcdoc = `<p style="width: 100%; border: 2px solid #efefef;" class="loaderImage"><img style="width: 100%;" src="${resumePlaceholder}"></p>`;

		return false;
	});
	jQuery('.modal-content').find('.close').on('click',function(){
	   jQuery('.modal').modal("hide");
	  });
	  jQuery('.modal').find('[data-dismiss="modal"]').on('click',function(){
	   jQuery('.modal').modal("hide");
	  });
	  
	  // Country State City Changes 
	  var cityDefault=`<option value="">Choose State First</option>`;
	  var stateDefault=`<option value="">Choose Country First</option>`;
	  jQuery(document).on('change','.country_options',function(){
		jQuery(".city_options").html(cityDefault);
        var el = jQuery(this);
        var id=el.val();
        var action=el.attr("data-action");
		jQuery.ajax({
			method:'POST',  
			url : action,
			data : {id:id },
			success: function(data){
				jQuery(".state_options").html(data);
			}   
		});
    });
	jQuery(document).on('change','.state_options',function(){
        var el = jQuery(this);
        var id=el.val();
        var action=el.attr("data-action");
		jQuery.ajax({
			method:'POST',  
			url : action,
			data : {id:id },
			success: function(data){
				jQuery(".city_options").html(data);
			}   
		});
    });
	  
	  //Any dashboard tab change on click
   jQuery(document).on('click','.cmtab_dashboard_click',function(){
	   var el = jQuery(this);
        var id=el.attr("data-id");
	   jQuery('.cmtab_dashboard_click').removeClass("active");
	   el.addClass("active");
	   jQuery('.disp_none').removeClass("active");
	   jQuery('#'+id).addClass("active");
   });
    jQuery(document).on('click',".change_schedule", function(){
		jQuery("#loading").show();
		var el = jQuery(this);
        var uev_id=[];
		uev_id.push(el.attr("data-id"));
		
        var action=el.attr("data-action");
        var schedule=el.siblings("select").val();
		if(schedule!=""){
			jQuery.ajax({
			method:'POST',  
			url : action,
			data : {id:uev_id,schedule:schedule },
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
	
	 jQuery(document).on('click',".clonebut_abs", function(){
			
			var extraHTML = jQuery(".repeat_html").html(); 
			var checkval = 0;
			jQuery(".repouter").append("<div class='addonfields row mb-3'>"+extraHTML+" <a href='javascript:void(0)' class='actionremove col-12'>Remove</a></div>");
			jQuery('.addonfields').removeClass().addClass('addonfields  row mb-3');
			jQuery(".addonfields").each(function(){
				checkval++;
				jQuery(this).addClass("clscount"+checkval);
							
				jQuery(".clscount"+checkval).find(".actionremove").attr("data",checkval);
			}); 
		});
			jQuery(".repouter").on('click','.actionremove',function(){
			var currId = jQuery(this).attr("data");
			jQuery(".clscount"+currId).remove();
			var checkval = 0;
			jQuery('.addonfields').removeClass().addClass('addonfields  row mb-3');
			jQuery(".addonfields").each(function(){ 
				checkval++;
				jQuery(this).addClass("clscount"+checkval);
				jQuery(".clscount"+checkval).find(".actionremove").attr("data",checkval);
			});
		});	

	jQuery.fn.shuffleChildren = function() {
			  jQuery.each(this.get(), function(index, el) {
				var $el = jQuery(el);
				var $find = $el.children();

				$find.sort(function() {
				  return 0.5 - Math.random();
				});

				$el.empty();
				$find.appendTo($el);
			  });
			};

		jQuery("#shuffle_btn").click(function() {
		  jQuery(".shuffle_question_items").shuffleChildren();
		});	





		/* on change departments get posts */
	 var postDefault=`<option value="">Choose any one option</option>`;
		  jQuery(document).on('change','.department_options',function(){
			jQuery(".post_options").html(postDefault);
			var el = jQuery(this);
			var id=el.val();
			var action=el.attr("data-action");
			jQuery.ajax({
				method:'POST',  
				url : action,
				data : {id:id },
				success: function(data){
					jQuery(".post_options").html(data);
				}   
			});
		});  
		
		
		jQuery(document).on('change','.post_assign_select',function(){
			var el = jQuery(this);
			var postid=el.val();
			var action=el.attr("data-action");
			var id=el.attr("data-id");
			jQuery.ajax({
				method:'POST',  
				url : action,
				dataType : 'json',
				data : {id:id,postid:postid },
				success: function(data){
					jQuery(".salary_details_applicant").html(data.salary);
					jQuery(".shuffle_question_items").html(data.questions);
				}   
			});
		});	   

});
