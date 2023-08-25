<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;"><img src="<?php echo url('/')?>/assets/images/company/<?php echo $company->logo ?>" style="height:100px;"></p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;"><?php echo $company->name  ?></p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;"><?php echo $company->address  ?></p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;"><?php echo $company->email  ?></p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;"><?php echo $company->phone  ?></p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;"><?php echo $company->website_link  ?></p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;"><?php echo date("d M, Y")  ?></p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">Dear <?php echo $user->name  ?>,</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">RE: Letter of Intent - <?php echo $post->name  ?> Position</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">I am pleased to inform you that you have been selected for the position of <?php echo $post->name  ?> at <?php echo $company->name  ?>. We were impressed by your qualifications, skills, and experience, and believe that you will make a valuable addition to our team. We are excited to extend this offer to you and invite you to join our organization.</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;"><?php echo make_table_with_salary_info($companySalaryInfo)  ?></p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">Position: <?php echo $post->name  ?></p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">Department: <?php echo $department->name  ?></p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">Start Date: <?php echo date("d M, Y",strtotime(' +1 day'))  ?></p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">Salary: $ <?php echo $companySalaryInfo->total_salary  ?></p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">As a <?php echo $post->name  ?> at <?php echo $company->name  ?>, you will be responsible for designing and developing high-quality websites, ensuring their functionality and usability. Your expertise in web development technologies and your ability to work collaboratively with our team will be instrumental in driving the success of our projects.</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">We offer a competitive salary package, along with benefits that may include health insurance, retirement plans, paid time off, and other perks. Detailed information regarding your compensation and benefits will be provided in the employment agreement, which will be sent to you shortly after your acceptance of this letter.</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">Please note that this offer is contingent upon the successful completion of background checks and any other pre-employment requirements as outlined by the company policies and applicable laws.</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">To accept this offer, please sign and return a copy of this letter by [Acceptance Deadline Date]. You can email a scanned copy or use the postal service to send the signed document to <?php echo $company->address  ?>. Upon receiving your acceptance, we will initiate the necessary onboarding process and provide you with further instructions.</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">We are confident that you will be a valuable asset to our team and contribute significantly to our company's success. We look forward to your positive response and welcoming you to <?php echo $company->name  ?>.</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">Should you have any questions or require further clarification, please do not hesitate to contact me at <?php echo $company->email  ?> or <?php echo $company->phone  ?>. Once again, congratulations on your selection, and we are excited to have you join our team.</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">Thank you for your attention, and we anticipate a favorable response.</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">Sincerely,</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">&nbsp;</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;"><?php echo get_hr_By_eventId($event->ev_id)->name ?></p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;">HR Manager</p>
<p style="margin: 0cm 0cm 0.0001pt; font-size: 12pt; font-family: 'Times New Roman', serif;"><?php echo $company->name  ?></p>				  