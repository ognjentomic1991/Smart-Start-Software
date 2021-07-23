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
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/smart_start.css">
		<link rel="stylesheet" type="text/css" href="js/malihu/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/malihu/jquery.mCustomScrollbar.concat.min.js"></script>
	</head>
	<body>
		<div class="data_load"></div>
		<nav>
			<h4 data-trgt=".load_file">Load a CSV</h4>
			<ul class="load_file">
				<?php list_load_file("/");?>
			</ul>
			<h4 data-trgt=".merge_file">Merge a CSV</h4>
			<ul class="merge_file"><?php // list_merge_file("/");?></ul>
			<div class="group_foreign_key">
				<h4 data-trgt=".foreign_key">Foreign Key</h4>
				<ul class="foreign_key">
				</ul>
			</div>
			<h4 data-trgt=".filters">Filters...</h4>
			<?php // gen_menu($csv, $i, "Status"); gen_menu($csv, $i, "DatumOsnivanja");?>
		</nav>
		<div class="sticky_header"></div>
		<div class="list_company_wrapper">
			<ul class="list_company"></ul>
		</div>
		<div class="loading"><p>...working...</p></div>
		<div class="gmap">
			<div id="map"></div>
			<script>
				var map;
				function initMap() {
					map = new google.maps.Map(document.getElementById('map'), {
						center: {lat: 44.800, lng: 20.389},
						zoom: 8
					});
				}
			</script>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAapolAYHULzJzMlNNiLkuwg2riTKiecHA&callback=initMap" async defer></script>
		</div>

		<script type="text/javascript">
			$( document ).ready(function(){
				$.ajaxSetup({ cache: false });
				window.ss = window.ss || {};

				ss.loaded_csv = "";

				ss.label_ironing = function(){
					var label_count = 1;
					$(".sticky_header div").each(function(){
						$(this).width($(".list_company li:nth-child(1) div:nth-child("+label_count+")").width());
						label_count++;
					});
				};

				ss.click_h4 = function(){
					$("h4")
						.off()
						.on("click", function(){
							$($(this).attr("data-trgt")).slideToggle();
						});
				};

				ss.click_load_file = function(){
					$("nav .load_file li a")
						.off()
						.on("click", function(e){
							e.preventDefault();
							ss.loaded_csv = $(this).attr("data-csv");
							$(".loading").fadeIn(150, function(){});
							$(".data_load").load("load_file.php?&load_file=import/"+$(this).attr("data-csv"), function(){
								var loaded_label_collect = "";
								for(var y = 0; y < loaded_label.length; y++){
									loaded_label_collect += "<div>"+loaded_label[y]+"</div>";
								}
								var c_1 = "<li>", c_2 = "", c_3 = "";
								for(var y = 0; y < loaded_label.length; y++){
									c_1 += "<div>"+loaded_label[y]+"</div>";
								}
								c_1 += "</li>";
								$(".list_company").empty().append(c_1);
								for(var z = 0; z < loaded_csv.length; z++){
									if(loaded_csv[z][loaded_label[0]] != ""){
										c_3 = "";
										c_2 = "<li>";
										for(var f = 0; f < loaded_label.length; f++){
											c_3 += "<div class=\""+loaded_label[f]+"\">"+loaded_csv[z][loaded_label[f]]+"</div>";
										}
										c_2 += c_3;
										c_2 += "</li>";
										$(".list_company").append(c_2);
									}
								}
								$(".sticky_header").empty().append(loaded_label_collect);
								ss.label_ironing();
								$(".data_load").load("list_merge_file.php?loaded_csv="+$(this).attr("data-csv"), function(){
									$("nav .merge_file").empty().append(list_merge);
									$("nav .merge_file li a").each(function(){
										if($(this).attr("data-csv") == ss.loaded_csv){
											$(this).parent().remove();
										}
									});
									ss.click_merge_file();
								});

								// $(".list_company").each(function(){
								// 	$(this).html($(this).children('li').sort(function(a, b){
								// 		return ($(b).find("div:nth-child(5)").text()) < ($(a).find("div:nth-child(5)").text()) ? 1 : -1;
								// 	}));
								// });

								$(".loading").fadeOut(150);
							});
							ss.nav_selected($(this), "nav .load_file li a");
						});
				};

				ss.click_merge_file = function(){
					$(".merge_file li a")
						.off()
						.on("click", function(e){
							e.preventDefault();
							$(".data_load").load("merge_file.php?merge_file=import/"+$(this).attr("data-csv"), function(){
								var collect = "";
								var k = 0;
								for(k=0; k < loaded_label[0].length; k++){
									if(merge_label.includes(loaded_label[k])){
										collect += "<li><a href=\"\" data-label=\""+loaded_label[k]+"\">"+loaded_label[k]+"</a></li>";
									}
								}
								$(".group_foreign_key .foreign_key").empty();
								if(collect != ""){
									$(".group_foreign_key .foreign_key").append(collect);
									ss.click_foreign_key();
								}
							});
							ss.nav_selected($(this), "nav .merge_file li a");
						});
				};

				ss.nav_selected = function(trgt, rst){
					$(rst).removeClass("nav_selected");
					$(trgt).addClass("nav_selected");
				};

				ss.click_foreign_key = function(){
					$(".group_foreign_key .foreign_key li a").on("click", function(e){
						e.preventDefault();
						var data_data_label = $(this).attr("data-label");
						var data_data_value = "";
						$(".list_company li").each(function(){
							$(this).append("<div>x</div>");
							data_data_value = $(this).find("."+data_data_label).text();
							for(var k = 0; k < merge_csv.length; k++){
								if(merge_csv[k][data_data_label] == data_data_value){
									$(this).find("div:last-of-type").html(merge_csv[k][data_data_label]);
								}
							}
						});
						ss.label_ironing();
					});
				};


				ss.click_h4();
				ss.click_load_file();

				$.mCustomScrollbar.defaults.scrollButtons.enable=false;
				$.mCustomScrollbar.defaults.axis="yx";
				$.mCustomScrollbar.defaults.scrollbarPosition="inside";
				$.mCustomScrollbar.defaults.autoDraggerLength=true;
				$.mCustomScrollbar.defaults.autoExpandScrollbar=true;
				$.mCustomScrollbar.defaults.contentTouchScroll=20;
				$.mCustomScrollbar.defaults.documentTouchScroll=true;
				$.mCustomScrollbar.defaults.autoHideScrollbar=true;
				$(".list_company_wrapper").mCustomScrollbar({theme:"light"});
				$("nav").mCustomScrollbar({theme:"light"});
				
				$(".loading").fadeOut(150);

				$.ajax({url: "https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyAapolAYHULzJzMlNNiLkuwg2riTKiecHA", success: function(result){
					console.log("***************** result:"+result.results[0].geometry.location.lat);
				}});

			});
		</script>

	</body>
</html>
