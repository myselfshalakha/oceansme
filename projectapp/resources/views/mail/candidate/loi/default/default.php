<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!------Font Awesome-------->
		<script src="https://kit.fontawesome.com/8fd9f824fa.js" crossorigin="anonymous"></script>
		 
		<!------Font Family-------->
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
		
	</head>
	<body style="font-family: 'roboto',sans-serif; text-decoration: none; list-style-type: none; box-sizing: border-box;">
		
		<table width="100%">
			<tr>
				<td>
					<table width="100%">
						<tr>
							<td> <p style="font-size: 14px; font-weight: 400; padding: 0px 20px 20px; margin: 0px; line-height: 1.5em;"> <?php echo date("d M Y")  ?> </p> </td>
						</tr>
						<tr>
							<td> <p style="font-size: 14px; font-weight: 400; padding: 0px 20px 20px; margin: 0px; line-height: 1.5em;"> <span style="font-weight: 700;"> Validity : </span> 90 days from issued date </p> </td>
						</tr>
						<tr>
							<td> <p style="font-size: 20px; font-weight: 700; text-align:center; margin: 0px; line-height: 1.5em;  padding: 0px 20px 17px;"> Letter Of Intent </p> </td>	
						</tr>
						<tr>
							<td> <p style="font-size: 14px; font-weight: 400; padding: 0px 20px 20px; margin: 0px; line-height: 1.5em;"> Dear  <?php echo ($user->gender=="male")?'Mr':"" ?><?php echo ($user->gender=="female")?'Mrs':"" ?> <?php echo $user->name  ?>,  </p> </td>	
						</tr>
						<tr>
							<td> <p style="font-size: 14px; font-weight: 400; padding: 0px 20px 20px; margin: 0px; line-height: 1.5em;"> We are delighted to express you our sincere congratulations for successfully completing our recruitment process:  <span style="font-weight:700"> Bravo! </span> </p> </td>
						</tr>
						<tr>
							<td> <p style="font-size: 14px; font-weight: 400; padding: 0px 20px 20px; margin: 0px; line-height: 1.5em;"> You have been shortlisted as a new potential member of <?php echo $company->name ?> family.  </p> </td>
						</tr>
						<tr>
							<td> <p style="font-size: 14px; font-weight: 400; padding: 30px 20px 20px; margin: 0px; line-height: 1.5em;"> Through this letter we confirm our interest to hire you onboard one of our ships, according to the following conditions and subject to your full compliance and adherence with the below listed qualifications.   </p> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tbody>
						<tr>
							<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> A. Contract Specifics </p> </th>
						</tr> 
						<tr>
							<th style="vertical-align: baseline; width: 15%;"> <p style="text-align: left;font-size: 14px;font-weight: 700;margin: 0px; padding: 30px 0px 12px 20px; line-height: 1.5em"> Position: </p> </th>
							<td style="vertical-align: baseline; width: 85%;"> <p style="text-align: left;font-size: 14px; font-weight: 400; margin: 0px; padding: 30px 20px 12px 10px; line-height: 1.5em"> <?php 
							echo $department->name." - ";
							echo $post->name;
							if(!empty($post->rank)){
								echo " - ".$post->rank;
							}
							if(!empty($post->rank_position)){
								echo " - ".$post->rank_position;
							}						
							
							?> </p> </td>
						</tr>
						<tr>
							<th style="vertical-align: baseline; width: 15%;"> <p style="text-align: left;font-size: 14px;font-weight: 700; margin: 0px; padding: 12px 0px 12px 20px; line-height: 1.5em"> Monthly Net salary: </p> </th>
							<td style="vertical-align: baseline; width: 85%;"> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 12px 20px 12px 10px; line-height: 1.5em"> <span style="font-weight:700">$<?php echo convertPriceToNumber($companySalaryInfo->total_salary);  ?> USD </span> – net per worked month </p> </td>
						</tr>
						<?php if(!empty($companySalaryInfo->contract_length_loi)){ ?>
						<tr>
							<th style="vertical-align: baseline; width: 15%;"> <p style="text-align: left;font-size: 14px;font-weight: 700;margin: 0px; padding: 12px 0px 12px 20px; line-height: 1.5em"> Contract Length:   </p> </th>
							<td style="vertical-align: baseline; width: 85%;"> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 12px 20px 12px 10px; line-height: 1.5em"> The contract length offered by <?php echo $company->name ?> for this position is <span style="font-weight:700"> <?php echo $companySalaryInfo->contract_length_loi ?></span>, with a <span style="font-weight:700"> leave period of <?php echo $companySalaryInfo->vacation_month ?> months </span> (unpaid holidays) between consecutive embarkations.   </p> </td>
						</tr>
						<?php
						}
						?>
						<tr>
							<th style="vertical-align: baseline; width: 15%;"> <p style="text-align: left;font-size: 14px;font-weight: 700;margin: 0px; padding: 12px 0px 30px 20px; line-height: 1.5em"> Contract Employer:  </p> </th>
							<td style="vertical-align: baseline; width: 85%;"> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 12px 20px 30px 10px; line-height: 1.5em"> Your employment with <?php echo $company->name ?> will be disciplined through a Seafarer Employment Agreement (SEA) that will be stipulated through MSC Malta Seafarers Company Limited – Upper Vaults 4, Valletta Waterfront, Floriana FRN 1914, Malta.  </p> </td>
						</tr>
					</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%"> 
						<tr>
							<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> B. General Conditions and requirements </p> </th>
						</tr> 
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em;"> MSC Cruises may offer you a position on one of its ships only if you agree to the conditions below and fully comply with the administrative requirements listed in this document. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Please, carefully read this document and, whether you agree with its terms and wish to be considered for Employment, <a href="#" style="font-weight:700; color: #000;"> send us back its signed copy within 48 hours from the date of the letter. </a> </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 10px 20px; line-height: 1.5em;"> Once accepted to join us, the Crew HR Coordinators will schedule your embarkation date based on MSC Cruises crew rotation needs, on your availability, and the documents preparation process you are invited to complete as specified below. </p> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%"> 
						<tr>
							<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> C. General information about the Employment Terms  </p> </th>
						</tr> 
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em;"> The onboard rotation can be settled, at the time of scheduling, for a shorter period of employment, in accordance with on-board turnover and seafarer needs, at sole discretion of the Employer. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> The Employment formally starts on the embarkation day. During the onboard period, the Employer has the right to tranship any crewmember, whether necessary for business requirements, up to two times.</p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 10px 20px; line-height: 1.5em;"> The working shifts, defined by the onboard ship management, may go up to 11 hours per day, with a maximum extent of 77 hours per week, in compliance with the Maritime Labour Convention 2006. Working days include weekends and public holidays. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 10px 20px; line-height: 1.5em;"> The Seafarer Employment Agreement (SEA) terms are under the collective agreement for cruise liners (ITF); kindly ask your assigned agency or us if you want to review it. </p> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%"> 
						<tr>
							<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> D. Document preparation guideline  </p> </th>
						</tr> 
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em;"> If you accept becoming an MSC Family member, you will be responsible to secure all documentation needed to embark. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Kindly consider the following points and the specific indication given as a guideline.</p> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%"> 
						<tr>
							<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> E. Personal Information Form  </p> </th>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em;"> <a href="#" style="font-weight:600; color: #07103e; "> "See attachment “Personal Information Form". </a> </p> </td>
						</tr>						
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> This form is used to collect your personal details & it is an editable WORLD doc. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> We recommend opening and filling out the form using a laptop/desktop computer, not by using a smartphone or tablet.</p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Once duly filled, please save the form, and send it back to us in the same format. </p> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%"> 
						<tr>
							<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> F. Passport  </p> </th>
						</tr>						
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em;"> Kindly provide us with: </p> </td>
						</tr>
						<tr>
							<td> 
								<ol style="padding: 8px 20px 8px 50px; margin-top: 0px; margin-bottom: 0px;">
									<li style="font-size: 14px; line-height: 1.5em; font-weight: 400;"> A colour copy of your valid passport (picture page) </li>
									<li style="font-size: 14px; line-height: 1.5em; font-weight: 400;"> A copy of your Codice Fiscale (for Italian applicants only!) </li>
								</ol>							
							</td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> The residual passport validity should be at least 18 months from the receiving day of this letter of intent.</p> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%"> 
						<tr>
							<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> G. Medical documentation  </p> </th>
						</tr>						
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em;"> <a href="#" style="font-weight:600; color: #07103e;"> See attachment “PEME A & B”. </a> </p> </td>
						</tr>						
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> To formalize your Employment, you must complete a detailed Pre-Employment Medical Examination with any national medical facility/physician or by centres for seafarers approved by your local maritime authorities. In addition, the analyzing physician should declare you medically fit for the position. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Its requirements are as follows: </p> </td>
						</tr>
						<tr>
							<td> 
								<ol style="padding: 8px 20px 8px 50px; margin-top: 0px; margin-bottom: 0px;">
									<li style="font-size: 14px; line-height: 1.5em; font-weight: 400;"> Every field to be duly filled in, </li>
									<li style="font-size: 14px; line-height: 1.5em; font-weight: 400;"> Duly signed by the seafarer, </li>
									<li style="font-size: 14px; line-height: 1.5em; font-weight: 400;"> Date of issue and date of expiry reported clearly, </li>
									<li style="font-size: 14px; line-height: 1.5em; font-weight: 400;"> Stamp of the filling doctor visible, </li>
									<li style="font-size: 14px; line-height: 1.5em; font-weight: 400;"> Duly signed by the relevant doctor. </li>
								</ol>							
							</td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Kindly consider that this document has a maximum validity of 24 months. </p> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%"> 
						<tr>
							<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> H. Record of vaccination   </p> </th>
						</tr>						
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em;"> <a href="#" style="font-weight:600; color: #07103e;"> See attachment “Record of vaccination”. </a> </p> </td>
						</tr>						
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Your doctor (local medical facility/registered physician) must fill in and sign the form. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Record of Vaccination must mandatorily include records of vaccinations against the following childhood-related, infects-contagious illnesses: </p> </td>
						</tr>
						<tr>
							<td> 
								<ol style="padding: 8px 20px 8px 50px; margin-top: 0px; margin-bottom: 0px; list-style-type: lower-alpha;">
									<li style="font-size: 14px; line-height: 1.5em; font-weight: 400;"> MMR (Measles, Mumps, and Rubella) – universal 3-in-1 vaccine* </li>
									<li style="font-size: 14px; line-height: 1.5em; font-weight: 400;"> Chickenpox – universal  </li>
								</ol>							
							</td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> *Note: MMRV (Measles, Mumps, Rubella, and Chickenpox) – a universal 4-in-1 vaccine can replace both individual vaccinations. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> The International Certificate of vaccination or revaccination issued by your local Ministry of Health is also accepted. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Kindly note: </p> </td>
						</tr>
						<tr>
							<td> 
								<ol style="padding: 8px 20px 8px 50px; margin-top: 0px; margin-bottom: 0px; list-style-type: lower-alpha;">
									<li style="font-size: 14px; line-height: 1.5em; font-weight: 400;"> MMR (Measles, Mumps, and Rubella) – universal 3-in-1 vaccine* </li>
									<li style="font-size: 14px; line-height: 1.5em; font-weight: 400;"> Chickenpox – universal  </li>
								</ol>							
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%"> 
						<tr>
							<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> I. Any other valid vaccination certificate    </p> </th>
						</tr>							
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em;"> Should you have any other valid vaccination certificates, such as yellow fever, Covid-19 (and related documentation), please forward copies of these with the other certifications.. </p> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%"> 
						<tr>
							<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> J. General consideration on Medical Documentation </p> </th>
						</tr>						
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em;"> <a href="#" style="font-weight:600; color: #000;"> The cost of medical examinations is the responsibility of the applicant. </a> </p> </td>
						</tr>						
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Failure to pass the pre-boarding medical examination precludes the possibility of embarkation. MSC Cruises and its representatives will not be liable for any loss you may incur due to your failure to pass the medical examination. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> For this reason, we highly recommend to self-assess your health conditions before you take any step through the medical examination process (such as resigning from your current Employment). </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> The PEME forms can be filled out by any national medical facility/physician or by centres for seafarers approved by your local maritime authorities. However, we suggest that you process your medical examinations before applying for any STCW training and incur its costs. </p> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tbody><tr>
							<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> K. BST/STCW Courses   </p> </th>
						</tr> 
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 0px 20px; line-height: 1.5em"> You must demonstrate that you hold the requested certifications of the following STCW courses issued by recognized worldwide training centres. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 0px 20px; line-height: 1.5em"> You can find the lists of authorized issuing centres on your local transportation ministry or coast guard websites. </p> </td>
						</tr>
						<tr>
							<td>	
								<ol style="margin: 0; padding: 8px 20px 0px 56px;">
									<li style="font-size: 14px; line-height: 24px; font-weight: 700;"> Personal Survival Techniques A-VI/1-1
										<ul style="margin: 0; padding: 8px 0px 8px 30px;">
											<li style="font-size: 14px; line-height: 24px; font-weight: 500;"> REGULATION VI/1 OF THE IMO STCW CODE, PARAGRAPH 2.1.4 OF THE STCW’78, SECTION A-VI/1, TABLE A-VI/1-4 IN COMPLIANCE WITH IMO MODEL COURSE 1.21
										</li></ul>
									</li>
									<li style="font-size: 14px; line-height: 24px; font-weight: 700;"> Fire Prevention and Fire Fighting A-VI/1-2  
										<ul style="margin: 0; padding: 8px 0px 8px 30px;">
											<li style="font-size: 14px; line-height: 24px; font-weight: 500;"> FIRE PREVENTION AND FIRE FIGHTING: REGULATION VI/1 OF THE IMO STCW CODE, PARAGRAPH 1 OF THE STCW’78, SECTION A-VI/1, TABLE A-VI/1-2 IN COMPLIANCE WITH IMO MODEL COURSE 1.20                                          
										</li></ul>
									</li>
									<li style="font-size: 14px; line-height: 24px; font-weight: 700;"> Elementary First Aid A-VI/1-3    
										<ul style="margin: 0; padding: 8px 0px 8px 30px;">
											<li style="font-size: 14px; line-height: 24px; font-weight: 500;"> ELEMENTARY FIRST AID: REGULATION VI/1 OF THE IMO STCW CODE, SECTION A-VI/1, TABLE A-VI/1-3 IN COMPLIANCE WITH IMO MODEL COURSE 1.13                     
										</li></ul>
									</li>
									<li style="font-size: 14px; line-height: 24px; font-weight: 700;"> Personal Safety and Social Responsibilities A-VI/1-4
										<ul style="margin: 0; padding: 8px 0px 8px 30px;">
											<li style="font-size: 14px; line-height: 24px; font-weight: 500;"> PERSONAL SURVIVAL TECHNIQUES: REGULATION VI/1 OF THE IMO STCW CODE, SECTION A-VI/1, TABLE A-VI/1-1 IN COMPLIANCE WITH IMO MODEL COURSE 1.19                      
										</li></ul>
									</li>
									<li style="font-size: 14px; line-height: 24px; font-weight: 700;"> Security Awareness Training for seafarers </li>
									<li style="font-size: 14px; line-height: 24px; font-weight: 700;"> Crowd Management A-V/2 </li>
									<li style="font-size: 14px; line-height: 24px; font-weight: 700;"> Crisis Management A-V/2 </li>
								</ol>
							</td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 0px 20px; line-height: 1.5em"> The above-reported certificates must explicitly refer to the “STCW 78 code as amended” or the STCW 2010 code. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 0px 20px; line-height: 1.5em"> The certificates must comply with the following requirements: </p> </td>
						</tr>
						<tr>
							<td>	
								<ol style="margin: 0; padding: 8px 20px 0px 80px; list-style-type: lower-alpha;">
									<li style="font-size: 14px; line-height: 24px; font-weight: 400;"> Name of Training Centre clearly shown. </li>
									<li style="font-size: 14px; line-height: 24px; font-weight: 400;"> Issuing date (Explora Journeys flag state recognizes a maximum validity of 5 years) </li>
									<li style="font-size: 14px; line-height: 24px; font-weight: 400;"> Recognition of Maritime Authority reported on each Certificate </li>
								</ol>
							</td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 0px 20px; line-height: 1.5em"> The Maritime Authority/Institution recognizing the Certificates must operate and be in the same Country of the Training Centre (example: Training Centre located in Rome and recognized by the Italian Maritime Authority).</p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 30px 20px; line-height: 1.5em"> <a href="#" style="font-weight:600; color:#000;"> You will bear the cost of these certificates,</a> and MSC Cruises will not be liable for any expense you may incur in obtaining or seeking to obtain the Compulsory Qualifications. </p> </td>
						</tr>
					</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tbody><tr>
								<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> L. Immigration Visa    </p> </th>
							</tr> 
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em"> MSC Cruises doesn’t require its candidates to hold any specific Immigration VISA as a mandatory hiring prerequisite but sharing a copy of any valid ones you might have is highly appreciated. </p> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em"> Everyone, who needs a Visa to embark (i.e., Schengen VISA or US C1/D VISA) on the assigned ship, will receive instructions from the Crew Hr Managers office about this need; the candidate will have to manage autonomously for the Visa issuing requirements. </p> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em"> <a href="#" style="font-weight:600; color:#000;"> The embassy or consular VISAs fees are being refunded once on board. </a> Therefore, keep the original receipts and give them to the Purser in charge of its processing.</p> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 30px 20px; line-height: 1.5em"> Beware: any agency or mediation cost and travel expense afforded to proceed with the VISA application and its obtention is not refundable.  </p> </td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tbody>
							<tr>
								<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> M. National Seaman Book (optional)   </p> </th>
							</tr> 
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em"> Seaman Book is not mandatory. </p> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 30px 20px; line-height: 1.5em;"> Please share a copy with us if you have a valid National Seaman Book. </p> </td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tbody>
							<tr>
								<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> N. A 4x4 photo (JPEG format)  </p> </th>
							</tr> 
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em;"> You must provide one photo with your other documents:</p> </td>
							</tr>
							<tr>
								<td>	
									<ul style="margin: 0; padding: 8px 20px 30px 80px; list-style-type: lower-alpha;">
										<li style="font-size: 14px; line-height: 24px; font-weight: 400;"> Submit a color photo, taken within the last 6 months </li>
										<li style="font-size: 14px; line-height: 24px; font-weight: 400;"> Use a clear image of your face. Do not use filters commonly used on social media. </li>
										<li style="font-size: 14px; line-height: 24px; font-weight: 400;"> Have someone else take your photo. No selfies. </li>
										<li style="font-size: 14px; line-height: 24px; font-weight: 400;"> Take off your eyeglasses for photo purposes. </li>
										<li style="font-size: 14px; line-height: 24px; font-weight: 400;"> Use a plain white or off-white background. </li>
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tbody>
							<tr>
								<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> O. Application for Panama Seamen’s Book form  </p> </th>
							</tr> 
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em;"> We require each embarking crew member to apply for the issuing a Panama Seamen Book. </p> </td>
							</tr>
							<tr>
								<td> <a href="#" style="text-align: left;font-size: 14px; font-weight: 600; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em; color:#07103e; display: block;"> Please see attachment “Application for Panama SB”.</a> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Kindly fill in only the following sections of this Annex:</p> </td>
							</tr>
							<tr>
								<td>	
									<ol style="margin: 0; padding: 8px 20px 30px 80px;">
										<li style="font-size: 14px; line-height: 24px; font-weight: 400;"> Registry/personal data (Section 1-2-3)</li>
										<li style="font-size: 14px; line-height: 24px; font-weight: 400;"> Clear signature </li>
									</ol>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tbody>
							<tr>
								<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> P. Documentation Notes  </p> </th>
							</tr> 
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em"> When travelling to reach and embark on the assigned ship, bring all the original documentation (Passport, Seaman’s book, STCW Training certificates, medical forms). </p> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Never leave the documentation behind; if asked to provide evidence of a document, supply copies of them, keep the original with you. Without original documents, you won’t be accepted on board by the Ship Command. </p> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Due to cyber security reasons, we cannot receive information and files by using external weblinks or connecting to the cloud or remote drives. </p> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Please send your files as email attachments using only the following file extension: DOC, PDF, or JPEG..</p> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Before sending the files, please  <a href="#" style="font-weight:700; text-decoration: none; color:#000; "> rename them as specified in this Letter of Intent. </a></p> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Once we receive the required documents, the MSC Cruises Crew department will consider you available for onboard scheduling and contact you with relevant embarkation details.</p> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> We invite you to provide soonest the above requested documents and stay in contact with us for any other related needs.</p> </td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tbody>
							<tr>
								<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> Q. Travel  </p> </th>
							</tr> 
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em"> MSC Cruises provides every travelling crew member (for embarkation, debarkation, trans-ship purposes) with  prepaid flight tickets, any hotel accommodations as needed, and transfer services in the port of embarkation/debarkation. </p> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 0px 20px; line-height: 1.5em;"> We try to book “Seaman’s Ticket fares” when booking your travel, including a 40 Kg baggage allowance. </p> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 0px 20px 8px 20px; line-height: 1.5em;"> However, the “free” baggage allowance may be limited to 23 kilos on local or regional flights; bear this in mind when handling your luggage. </p> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em; color:#000; display: block;"> Travel arrangements include tickets and services from/to the international airport nearer your residence. </p> </td>
							</tr>
							<tr>
								<td> <a href="#" style="text-align: left;font-size: 14px;font-weight: 700; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em; color:#000; display: block;"> Any travel cost will be at your own expense if debarkation occurs for disciplinary actions or personal reasons and breaches the minimum contract duration.. </a> </td>
							</tr>
							<tr>
								<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 30px 20px; line-height: 1.5em;"> Finally, together with the flight ticket, MSC Cruises issues the Guarantee Letter, a document proving that you are travelling as a seafarer (to be shown to the authorities upon request).</p> </td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tbody><tr>
							<th colspan="2"> <p style="font-size: 14px; font-weight: 600; padding: 10; margin: 0px; line-height: 1.5em; background: #07103e; color: #fff; text-align: left;"> R. Validity of This Letter Of Intent  </p> </th>
						</tr> 
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em"> As set out above, this letter is not an employment contract and does not create any legal, contractual, or employment relationship between you and MSC Cruises. Employment is formally offered whether satisfied the terms defined in this document, and it’s strictly subject to the operational requirements of MSC Cruises. This letter is governed by the law of England and Wales and any dispute arising out of this document will be referred exclusively to the Courts of England and Wales. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> MSC MALTA SEAFARER COMPANY LIMITED, incorporated in Malta with company number MT23234921, whose registered office is at Upper Vaults 4, Valletta Waterfront, Floriana FRN1914, Malta, acting as Data Controller, collects and processes your personal data fairly and transparently for the instauration and performance of the employment contract, in compliance with the applicable requirements of the General Data Protection Regulation Reg. (EU) 2016/679 (“GDPR”). MSC CREW SERVICES (ITALIA) S.R.L, via delle Rose, 60, 80063 Piano di Sorrento (NA) Italy, acts as Data Processor on instructions from the Data Controller. To access, rectify or delete your personal data, please write an email to privacyhelpdesk@msccruises.com. For other questions regarding privacy and data protection at MSC Cruises, you may contact the Data Protection Officer at dpo@msccruises.com. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Issuing Person Appointed only for talent acquisition purpose & procedure (on behalf of Msc Malta Seafarer company Limited or MSC Crew Services Italia S.r.l. as per Administration Service agreement) </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Marco Maresca </p> </td>
						</tr>
						<tr>
							<td> <img src="https://impalawebs.com/work/jagpreet/images/signature.png" alt="logo" style="max-width: 100%; height: 108px; object-fit: contain; display: block; padding: 0px 0px 30px 0px"> </td>
						</tr>
					</tbody></table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tbody>
							<tr>
								<th colspan="2"> <p style="color: #000; text-align: center; padding: 60px 0px 0px; font-size: 24px; font-weight: 700; margin:0px;"> For Candidate Use </p> </th>
							</tr> 
							<tr>
								<td colspan="2"> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 0px 20px; line-height: 1.5em; text-align: center;"> I have read and understand this letter of intent. I acknowledge that this is not a contract of Employment and does not create any legal relationship between me, MSC Malta Seafarers Company or any company affiliated or connected thereto. I acknowledge and understand that I will only be offered Employment if I satisfy the criteria set out above an if the operational requirements allow it. </p> </td>
							</tr>
							<tr>
								<td colspan="2"> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 0px 20px 8px 20px; line-height: 1.5em; text-align: center;"> Further to this I authorize MSC Malta Seafarers Company or their representative to share my personal details with their manning agency or offices in order to process my job application.</p> </td>
							</tr>
							<tr>
								<td style="text-align: center;"> 
									<ul style="margin: 0;padding: 60px 0px 0px 0px;list-style: none;margin-block-start: 0px;margin-block-end: 0px;padding-inline-start: 0px; display: inline-block;">
										<li style="display: inline-block; margin-bottom: 20px; margin-right: 5px;"> <span style="text-align: left;font-size: 14px;font-weight: 400; line-height: 1.5em; margin-right:5px; display: inline-block; width:85px"> Name: </span> <span style="width:200px; height:3px; border-bottom:1px solid #000; display: inline-block;"> </span> </li>
										<li style="display: inline-block; margin-bottom: 20px; margin-right: 5px;"> <span style="text-align: left;font-size: 14px;font-weight: 400; line-height: 1.5em; margin-right:5px; display: inline-block; width:85px"> Signature: </span> <span style="width:200px; height:3px; border-bottom:1px solid #000; display: inline-block;"> </span></li>
									</ul>
								</td>
							</tr>
							<tr>
								<td style="text-align: center;"> 
									<ul style="margin: 0;padding: 0px ;list-style: none;margin-block-start: 0px;margin-block-end: 0px;padding-inline-start: 0px; display: inline-block;">
										<li style="display: inline-block; margin-bottom: 20px; margin-right: 5px;"> <span style="text-align: left;font-size: 14px;font-weight: 400; line-height: 1.5em; margin-right:5px; display: inline-block; width:85px"> Date: </span> <span style="width:200px; height:3px; border-bottom:1px solid #000; display: inline-block;"> </span> </li>
										<li style="display: inline-block; margin-bottom: 20px; margin-right: 5px;"> <span style="text-align: left;font-size: 14px;font-weight: 400; line-height: 1.5em; margin-right:5px; display: inline-block; width:85px"> Position: </span> <span style="width:200px; height:3px; border-bottom:1px solid #000; display: inline-block;"> </span> </li>
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
		
	</body>
</html>