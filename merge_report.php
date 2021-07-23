<?php
	$csv = array();
	if(isset($_GET['merge_report'])){
		$file = $_GET['merge_report'];
		$csv = array_map('str_getcsv', file($file));
		$table_label = array();
		for($i = 0; $i < sizeof($csv[0]); $i++){
			array_push($table_label, $csv[0][$i]);
		}
		array_walk($csv, function(&$a) use ($csv){
			$a = array_combine(str_replace("\ufeff", "", $csv[0]), $a);
		});
		array_shift($csv);
		if(isset($_GET['sort_by'])){
			usort($csv, function($a, $b) {
			    return $a[$_GET['sort_by']] <=> $b[$_GET['sort_by']];
			});
		}
	}
?>
<script>
	var merge_report_csv = <?php echo json_encode($csv); ?>;
	merge_report_csv = JSON.stringify(merge_report_csv); 
	merge_report_csv = merge_report_csv.replace(/\ufeff/g, "")
	merge_report_csv = JSON.parse(merge_report_csv); 
	var merge_report_label = <?php echo json_encode($table_label); ?>;
	merge_report_label = JSON.stringify(merge_report_label); 
	merge_report_label = merge_report_label.replace(/\ufeff/g, "")
	merge_report_label = JSON.parse(merge_report_label); 
</script>