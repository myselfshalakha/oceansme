<?php

namespace App\Shortcodes;
use Illuminate\Support\Facades\DB;
class companyTitle {

  public function register($shortcode, $content, $compiler, $name, $viewData)
  {
	  ob_start();
	?>
	<table style="border-collapse: collapse; width: 100%; height: 67.1718px;" border="1"><colgroup><col style="width: 37.9656%;"><col style="width: 30.9456%;"><col style="width: 31.0888%;"></colgroup>
	<tbody>
	<tr style="height: 22.3906px;">
	<td style="height: 22.3906px;"><strong>Department</strong></td>
	<td style="height: 22.3906px;"><strong>Job Title</strong></td>
	<td style="height: 22.3906px;"><strong>Salary</strong></td>
	</tr>
	<tr style="height: 22.3906px;">
	<td style="height: 22.3906px;">Information Technology</td>
	<td style="height: 22.3906px;">Web Designer</td>
	<td style="height: 22.3906px;">$1,000</td>
	</tr>
	</tbody>
	</table>
	<?php
	$content = ob_get_clean();
	return $content;
  }
  
}
