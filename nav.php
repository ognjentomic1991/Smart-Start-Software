<?php
	function list_load_file($handle){
		$load_dir = "/import/";
		if ($handle = opendir('.'.$load_dir)){
			while (false !== ($entry = readdir($handle))){
				if ($entry != "." && $entry != ".." && $entry != "import.xlsx" && $entry != "index.php" && $entry != "obsolete" ){?>
					<li><a href="<?php echo $_SERVER['PHP_SELF'];?>?load_file=import/<?php echo $entry;?>&sort_by=﻿MaticniBroj" data-csv="<?php echo $entry;?>"><?php echo substr($entry, 0, -4);?></a></li><?php
				}
			}
			closedir($handle);
		}
	}
	function list_merge_file($handle){
		$load_dir = "/import/";
		if ($handle = opendir('.'.$load_dir)){
			while (false !== ($entry = readdir($handle))){
				if ($entry != "." && $entry != ".." && $entry != "import.xlsx" && $entry != "index.php" && $entry != "obsolete" && $_GET['load_file'] != "import/" . $entry ){?>
					<li><a href="<?php echo $_SERVER['PHP_SELF'];?>?load_file=<?php echo "import/" . $entry;?>&sort_by=﻿MaticniBroj" data-csv="<?php echo $entry;?>"><?php echo substr($entry, 0, -4);?></a></li><?php
				}
			}
			closedir($handle);
		}
	}
	function gen_menu($csv, $i, $trgt){
		if(isset($csv[$i][$trgt])){
			${"unique_".$trgt} = array(); 
			echo "<ul class=\"filters\">";
			for($i = 0; $i < sizeof($csv); $i++) {
				if(!in_array($csv[$i][$trgt], ${"unique_".$trgt}) && $csv[$i][$trgt] != ""){
					array_push(${"unique_".$trgt}, $csv[$i][$trgt]);
					echo "<li><a href=\"#\">".$csv[$i][$trgt]."</a></li>";
				}
			}
			echo "</ul>";
		}
	}
	if(!isset($i)){$i = "";}
?>
<nav>
	<h4 data-trgt=".load_file">Učitaj CSV</h4>
	<ul class="load_file">
		<?php list_load_file("/");?>
	</ul>
	<h4 data-trgt=".merge_file">Spoji CSV</h4>
	<ul class="merge_file">
		<?php list_merge_file("/");?>
	</ul>
	<div class="group_foreign_key">
		<h4 data-trgt=".foreign_key">Spoji Adrese po Foreign Key-u</h4>
		<ul class="foreign_key">
		</ul>
	</div>
	<h4 data-trgt=".filters">Filteri...</h4>
	<?php
		gen_menu($csv, $i, "Status");
		gen_menu($csv, $i, "DatumOsnivanja");
	?>
</nav>