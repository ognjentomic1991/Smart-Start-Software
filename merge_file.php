<?php
	$csv = array();
	if(isset($_GET['merge_file'])){
		$file = $_GET['merge_file'];
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
	var merge_csv = <?php echo json_encode($csv); ?>;
	merge_csv = JSON.stringify(merge_csv); 
	merge_csv = merge_csv.replace(/\ufeff/g, "")
	merge_csv = JSON.parse(merge_csv); 
	var merge_label = <?php echo json_encode($table_label); ?>;
	merge_label = JSON.stringify(merge_label); 
	merge_label = merge_label.replace(/\ufeff/g, "")
	merge_label = JSON.parse(merge_label); 
</script>