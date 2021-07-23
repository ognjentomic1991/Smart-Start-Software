<?php 
	$collect = "";
	$handle = "/";
	$load_dir = "/import/";
	if ($handle = opendir('.'.$load_dir)){
		while (false !== ($entry = readdir($handle))){
			if ( $entry != "." && $entry != ".." && $entry != "import.xlsx" && $entry != "index.php" && $entry != "obsolete" ){
				$collect .= "<li><a href=\"merge_file.php?merge_file=" . $entry . "&sort_by=﻿MaticniBroj\" data-csv=\"" . $entry . "\">" . substr($entry, 0, -4) . "</a></li>";
			}
		}
		closedir($handle);
	}
?>
<script>
	var list_merge = <?php echo json_encode($collect); ?>;
	list_merge = JSON.stringify(list_merge); 
	list_merge = list_merge.replace(/\ufeff/g, "");
	list_merge = JSON.parse(list_merge); 
</script>