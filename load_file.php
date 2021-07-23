<?php
	$csv = array();
	if(isset($_GET['load_file'])){
		$file = $_GET['load_file'];
		$csv = array_map('str_getcsv', file($file));
		$table_label = array();
		for($i = 0; $i < sizeof($csv[0]); $i++){
			array_push($table_label, $csv[0][$i]);
		}
		array_walk($csv, function(&$a) use ($csv){
			$a = array_combine(str_replace("\ufeff", "", $csv[0]), $a);
		});
		array_shift($csv);
		// if(isset($_GET['sort_by'])){usort($csv, function($a, $b) {return $a[$_GET['sort_by']] <=> $b[$_GET['sort_by']];});}
	}
?>
<script>
	var loaded_csv = <?php echo json_encode($csv); ?>;
	loaded_csv = JSON.stringify(loaded_csv); 
	loaded_csv = loaded_csv.replace(/\ufeff/g, "")
	loaded_csv = JSON.parse(loaded_csv); 
	var loaded_label = <?php echo json_encode($table_label); ?>;
	loaded_label = JSON.stringify(loaded_label); 
	loaded_label = loaded_label.replace(/\ufeff/g, "")
	loaded_label = JSON.parse(loaded_label); 
</script>