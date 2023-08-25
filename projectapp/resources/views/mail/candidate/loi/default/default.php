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
		
		<table style="width: 100%;">
			<tr>
				<td>
					<table width="100%">
						<tr>
							<td> <p style="font-size: 20px; font-weight: 700; text-align:center; margin: 0px; line-height: 1.5em; text-decoration:underline; padding: 0px 20px 17px;"> Letter Of Intent </p> </td>	
						</tr>
						<tr>
							<td> <p style="font-size: 14px; font-weight: 400; padding: 0px 20px 20px; margin: 0px; line-height: 1.5em;"> Dear <?php echo ($user->gender=="male")?'Mr':"" ?><?php echo ($user->gender=="female")?'Mrs':"" ?> <?php echo $user->name  ?>, </p> </td>	
						</tr>
						<tr>
							<td> <p style="font-size: 14px; font-weight: 400; padding: 0px 20px 20px; margin: 0px; line-height: 1.5em;"> Congratulations! In reference to your job application no 200252 dated <?php echo date("d M Y")  ?> with us, we are pleased to advise you that you have been short listed as a potential member of our team and, subject to you obtaining the below qualifications, we intend to hire you as <span style="font-weight:700"> <?php echo $post->name  ?> </span> with rank <span style="font-weight:700"> JUNIOR <?php echo $post->name  ?> </span> on board of one of our vessel, with a monthly salary as per scheme below: </p> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="padding: 0px 20px;">
					<table style="width:100%; border: 1px solid black; border-collapse: collapse;">
						<tr>
							<th style="font-size: 14px; font-weight: 400; color: #ff0000; line-height: 1.5em; padding: 20px; border: 1px solid black; border-collapse: collapse; text-align:center;"> Basic Wage </th>
							<th style="font-size: 14px; font-weight: 400; color: #ff0000; line-height:  1.5em; padding: 20px; text-transform: uppercase; border: 1px solid black; border-collapse: collapse; text-align:center;"> Other Contractual indemnities <span style="font-size: 14px; font-weight: 400; color: #000000; line-height: 1.5em; font-style: italic;"> (SAT/SUN HOLIDAYS, LEAVE COMPENS, MINIMUM FIXED OVERTIME, etc.) </span> </th>
							<th style="font-size: 14px; font-weight: 600; color: #ff0000; line-height:  1.5em; padding: 20px; border: 1px solid black; border-collapse: collapse; text-align:center;"> TOTAL GUARANTEED WAGE </th>
							<th style="font-size: 14px; font-weight: 400; color: #000000; line-height:  1.5em; padding: 20px; border: 1px solid black; border-collapse: collapse; text-align:center;"> Service Charge </th>
							<th style="font-size: 14px; font-weight: 400; color: #000000; line-height:  1.5em; padding: 20px; border: 1px solid black; border-collapse: collapse; text-align:center;"> Bonus Level </th>
							<th style="font-size: 14px; font-weight: 400; color: #000000; line-height:  1.5em; padding: 20px; border: 1px solid black; border-collapse: collapse; text-align:center;"> Bonus Ad personam </th>
							<th style="font-size: 14px; font-weight: 600; color: #000000; line-height:  1.5em; padding: 20px; text-transform: uppercase; border: 1px solid black; border-collapse: collapse; text-align:center;"> TOTAL SALARY </th>
						</tr>
						<tr>
							<td style="font-size: 14px; font-weight: 400; color: #ff0000; line-height: 1.5em; padding: 20px; border: 1px solid black; border-collapse: collapse; text-align:center;"> $<?php echo $companySalaryInfo->basic_wage  ?> </td>
							<td style="font-size: 14px; font-weight: 400; color: #ff0000; line-height: 1.5em; padding: 20px; border: 1px solid black; border-collapse: collapse; text-align:center;"> $<?php echo $companySalaryInfo->other_contractual  ?> </td>
							<td style="font-size: 14px; font-weight: 600; color: #ff0000; line-height: 1.5em; padding: 20px; border: 1px solid black; border-collapse: collapse; text-align:center;"> $<?php echo $companySalaryInfo->guaranteed_wage  ?> </td>
							<td style="font-size: 14px; font-weight: 400; color: #000000; line-height:  1.5em; padding: 20px; border: 1px solid black; border-collapse: collapse; text-align:center;"> $<?php echo $companySalaryInfo->service_charge  ?> </td>
							<td style="font-size: 14px; font-weight: 400; color: #000000; line-height:  1.5em; padding: 20px; border: 1px solid black; border-collapse: collapse; text-align:center;"> $<?php echo $companySalaryInfo->bonus_level  ?> </td>
							<td style="font-size: 14px; font-weight: 400; color: #000000; line-height:  1.5em; padding: 20px; border: 1px solid black; border-collapse: collapse; text-align:center;"> $<?php echo $companySalaryInfo->bonus_personam  ?> </td>
							<td style="font-size: 14px; font-weight: 600; color: #000000; line-height:  1.5em; padding: 20px; border: 1px solid black; border-collapse: collapse; text-align:center;"> $<?php echo $companySalaryInfo->total_salary  ?> </td>
						</tr>
						<tr>
							<td colspan="3" style="font-size: 14px; font-weight: 600; color: #ff0000; line-height: 1.5em; padding: 20px; border: 1px solid black; border-collapse: collapse; text-align:left; font-style: italic;"> As per CBA </td>
							<td colspan="4" style="font-size: 14px; font-weight: 600; color: #000000; line-height: 1.5em; padding: 20px; border: 1px solid black; border-collapse: collapse; text-align:left; font-style: italic;"> Additional Earnings as per Company Policies </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%"> 
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em;"> You will only be offered employment if you comply with the conditions below and always subject to our operational requirements. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> This is not an offer of employment and is not a Seafarers’ Employment Agreement (“SEA”). This document does not create any employment, legal or other contractual relationship between us and you. You will be provided with an SEA before you join a ship and it will be a condition of your engagement that you sign a SEA before you join any of our vessel.</p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 10px 20px; line-height: 1.5em;"> You must go through this document carefully and if you agree with its terms and wish to be considered for employment, please return a signed copy within 48 hours from the date of the letter. </p> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 10px 20px 15px 20px; line-height: 1.5em;"> Please note that the embarkation waiting period may vary from few days to several months. Soon after your acceptance to this LOI, our manning agent located in your country or nearby country will contact you. Should you require any clarification about your embarkation please contact the manning office. </p> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 15px 20px 20px 20px; line-height: 1.5em;"> Before we can offer you a position on one of our vessel you must satisfy the following conditions: </p> </td>
						</tr>
						<tr> 
							<td> <h4 style="font-size:50px, font-weight:700; margin:0px; padding: 0px 20px; line-height: 1.5em;">1.  Medical Test </h4> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> You must successfully complete a detailed Pre-Embarkation Medical Examination with one of our authorised medical centres (a list of our authorised medical centres will be provided to you by your local manning agency). Before we can offer you an employment you must be declared medically fit for the position detailed above by an authorised medical centre. </p>
							<p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> The cost of an approved medical may vary from country to country and the cost will be borne by you. You should consider carefully whether you will be able to pass the Pre-Embarkation Medical Examination before you take any steps (such as resigning from your current employment) as we will not be liable for any losses you incur as a result of a failure to pass a Pre-Embarkation Medical Examination. </p>
							</td>
						</tr>
						<tr> 
							<td> <h4 style="font-size:50px, font-weight:700; margin:0px; padding: 0px 20px; line-height: 1.5em;">2.  Passport </h4> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> You must have a valid passport with a validity of at least one year from the proposed date of joining the vessel. </p>
							</td>
						</tr>
						<tr> 
							<td> <h4 style="font-size:50px, font-weight:700; margin:0px; padding: 0px 20px; line-height: 1.5em;">3.  National Seaman Book </h4> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Before you can be offered a position on one of our vessels you will need to obtain a national seaman book or Flag Seaman book . Your local manning agent will guide you through the process of obtaining a seaman book. </p>
							</td>
						</tr>
						<tr> 
							<td> <h4 style="font-size:50px, font-weight:700; margin:0px; padding: 0px 20px; line-height: 1.5em;">4.  BST/STCW Courses 2010 </h4> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> You will need to demonstrate that you have the necessary certification in the following (together the “Compulsory Qualifications”) from an institute approved in your country and approved by our local manning agents (you can get the list of institutes from our manning agents in your country): </p>
							<ol style="margin: 8px 0px">
								<li style="font-size: 14px;line-height: 34px;font-weight: 400;"> Personal Survival Techniques A-VI/1-1 </li>
								<li style="font-size: 14px;line-height: 34px;font-weight: 400;"> Fire Prevention and Fire Fighting A-VI/1-2 </li>
								<li style="font-size: 14px;line-height: 34px;font-weight: 400;"> Elementary First Aid A-VI/1-3</li>
								<li style="font-size: 14px;line-height: 34px;font-weight: 400;"> Personal Safety and Social Responsibilities A-VI/1-4 </li>
								<li style="font-size: 14px;line-height: 34px;font-weight: 400;"> Security awareness Training for seafarers  </li>
								<li style="font-size: 14px;line-height: 34px;font-weight: 400;"> Crowd Management A-V/2 </li>
								<li style="font-size: 14px;line-height: 34px;font-weight: 400;"> Crisis Management A-V/2 </li>
							</ol>
							
							<p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> The cost of these certificates will be borne by you and we will not be liable for any cost you incur in obtaining or seeking to obtain the Compulsory Qualifications. </p>
						</tr>
						<tr> 
							<td> <h4 style="font-size:50px, font-weight:700; margin:0px; padding: 0px 20px; line-height: 1.5em;">5.  Yellow Fever </h4> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> You must have a valid yellow fever vaccination certificate from a centre authorised by us. You must meet the cost of obtaining this certificate. </p>
							</td>
						</tr>
						<tr> 
							<td> <h4 style="font-size:50px, font-weight:700; margin:0px; padding: 0px 20px; line-height: 1.5em;">6.  Visa </h4> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> When you are assigned to a ship, you must apply for the necessary visa although we and our manning agents will provide you with assistance. You required to pay the visa fee but the embassy fee will be reimbursed upon presenting original embassy receipt on board after embarkation. You will not be offered employment if you have not obtained the necessary visa(s). </p>
							</td>
						</tr>
						<tr> 
							<td> <h4 style="font-size:50px, font-weight:700; margin:0px; padding: 0px 20px; line-height: 1.5em;">7.  Documents Required By National Law </h4> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Depending upon your country of origin you may need to obtain other documents required by the national law of your country. You will be advised of any such documents by our manning agency/local office. </p>
							</td>
						</tr>
						<tr> 
							<td> <h4 style="font-size:50px, font-weight:700; margin:0px; padding: 0px 20px; line-height: 1.5em;">8. Contract Term </h4> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> Any contract you are offered with MSC Malta Seafarers Company is normal fixed in 9 months with right of the company to reduce or extend this time for a maximum of 2 mouth for hotel / catering personnel and 1 mouth for deck & engine and your salary will only be paid during term of your SEA. At the conclusion of any contract, we will provide economy class air travel back to your home country in accordance with the terms of the SEA. </p>
							</td>
						</tr>
						<tr> 
							<td> <h4 style="font-size:50px, font-weight:700; margin:0px; padding: 0px 20px; line-height: 1.5em;">9. Pre-Embarkation Training </h4> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 15px 20px; line-height: 1.5em;"> After completing all required documents you will need to attend company on board training in your country. Training will be free of cost and company will bear all expenses of training. It will be a condition of joining a vessel that you complete the training course to our satisfaction </p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tr> 
							<td> <h4 style="font-size:50px, font-weight:700; margin:0px; padding: 15px 20px 0px; line-height: 1.5em;">Validity of This Letter Of Intent </h4> </td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em;"> As set out above, this letter is not an employment contract and does not create any legal, contractual or employment relationship between us and you. You will only be offered employment if you satisfy the terms above and strictly subject to our operational requirements. This letter is be governed by the law of England and Wales and any dispute arising out of this document will be referred exclusively to the Courts of England and Wales. </p>
							</td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 400; margin: 0px; padding: 8px 20px 0px 20px; line-height: 1.5em; font-style: italic;"> MSC MALTA SEAFARER COMPANY LIMITED, incorporated in Malta with company number MT23234921, whose registered office is at Upper Vaults 4, Valletta Waterfront, Floriana FRN1914, Malta, acting as Data Controller, collects and processes your personal data in a fair and transparent way for the purposes of the instauration and performance of the employment contract, in compliance with the applicable requirements of the General Data Protection Regulation Reg. (EU) 2016/679 ("GDPR"). MEDITERRANEAN SHIPPING COMPANY S.r.l. Cruise Crew Division, Corso Italia , 214, 80063 Piano di Sorrento (NA) Italy, acts as Data Processor on instructions from the Data Controller. To access, rectify or delete your personal data please write an email to <a href="#" style="font-weight:600;"> privacyhelpdesk@msccruises.com.</a> For other questions regarding privacy and data protection at MSC Cruises you may contact the Data Protection Officer at <a href="#" style="font-weight:600;"> dpo@msccruises.com. </a> </p>
							</td>
						</tr>
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 600; margin: 0px; padding: 40px 20px 40px 20px; line-height: 1.5em; font-style: italic;"> Issuing Person Appointed only for talent acquisition purpose & procedure (on behalf of Msc Malta Seafarer company Limited or MSC Crew Services Italia Srl as per Administration Service agreement ) </p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 600; margin: 0px; padding: 0px 20px 50px 20px; line-height: 1.5em;"> Issuing Person: Alessandra Nunes  </p>
							</td>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 600; margin: 0px; padding: 0px 20px 50px 20px; line-height: 1.5em;"> Signature: Mail Confirmation </p> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tr>
							<td> <p style="text-align: left;font-size: 14px;font-weight: 600; margin: 0px; padding: 0px 20px 60px 20px; line-height: 1.5em;"> Issuing person of MSC Malta Seafarer company Limited or MSC Crew Services Italia Srl as per Administration Service agreement) </p>
							</td>
						</tr>
						<tr>
							<td> <span style="border-bottom: 2px solid #000; display: block; margin: 0px 20px 40px;"> </span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tr>
							<th colspan="2"> <p style="color: #000; text-align: center; padding: 30px 0px 0px; font-size: 24px; font-weight: 700; margin:0px;"> For Candidate Use </p> </th>
						</tr> 
						<tr>
							<td colspan="2"> <p style="font-size: 14px;font-weight: 600; margin: 0px; padding: 30px 20px 8px 20px; line-height: 1.5em; text-align: left;"> I have read and understand this letter of Intent. I acknowledge that this is not a contract of employment and does not create any legal relationship between me, MSC Malta Seafarers Company or any company affiliated or connected thereto. I acknowledge and understand that I will only be offered employment if I satisfy the criteria set out above an if the operational requirements allow it. </p> </td>
						</tr>
						<tr>
							<td colspan="2"> <p style="font-size: 14px;font-weight: 600; margin: 0px; padding: 8px 20px 8px 20px; line-height: 1.5em; text-align: left;"> Further to this I authorise MSC Malta Seafarers Company or their representative to share my personal details with their manning agency or offices in order to process my job application. </p> </td>
						</tr>
						<tr>
							<td style="text-align: left;"> 
								<ul style="margin: 0;padding: 40px 0px 0px 20px;list-style: none;margin-block-start: 0px;margin-block-end: 0px; 0px; display: inline-block; width: 97%;">
									<li style="display: inline-block; margin-bottom: 20px; margin-right: 5px; width: 48%;"> <span style="text-align: left;font-size: 14px;font-weight: 400; line-height: 1.5em; margin-right:5px; display: inline-block; width:85px"> Name: </span> <span style="width:480px; height:3px; border-bottom:1px solid #000; display: inline-block;"> </span> </li>
									<li style="display: inline-block; margin-bottom: 20px; margin-right: 5px; width: 48%;"> <span style="text-align: left;font-size: 14px;font-weight: 400; line-height: 1.5em; margin-right:5px; display: inline-block; width:85px"> Signature: </span> <span style="width:480px; height:3px; border-bottom:1px solid #000; display: inline-block;"> </span></li>
								</ul>
							</td>
						</tr>
						<tr>
							<td style="text-align: left;"> 
								<ul style="margin: 0;padding: 0px 0px 30px 20px;list-style: none;margin-block-start: 0px;margin-block-end: 0px; 0px; display: inline-block; width: 97%;">
									<li style="display: inline-block; margin-bottom: 20px; margin-right: 5px; width: 48%;"> <span style="text-align: left;font-size: 14px;font-weight: 400; line-height: 1.5em; margin-right:5px; display: inline-block; width:85px"> Date: </span> <span style="width:480px; height:3px; border-bottom:1px solid #000; display: inline-block;"> </span> </li>
									<li style="display: inline-block; margin-bottom: 20px; margin-right: 5px; width: 48%;"> <span style="text-align: left;font-size: 14px;font-weight: 400; line-height: 1.5em; margin-right:5px; display: inline-block; width:85px"> Position: </span> <span style="width:480px; height:3px; border-bottom:1px solid #000; display: inline-block;"> </span> </li>
								</ul>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	
	</body>
</html>