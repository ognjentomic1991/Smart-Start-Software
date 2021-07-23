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
			<a href="<?php echo $_SERVER['PHP_SELF'];?>" class="logo"></a>
			<div class="display">
				<div class="display_style ds_both nav_selected">Oba</div>
				<div class="display_style ds_list">Lista</div>
				<div class="display_style ds_map">Mapa</div>
				<div class="display_style ds_print">Štampanje</div>
			</div>
			<h4 class="load_file_title" data-trgt=".load_file">Učitaj CSV</h4>
			<ul class="load_file"><?php list_load_file("/");?></ul>
			<h4 class="merge_address_title" data-trgt=".merge_address">Spoji Adrese</h4>
			<ul class="merge_address"></ul>
			<div class="group_address_foreign_key">
				<h4 class="foreign_key_title" data-trgt=".foreign_key">Spoji Adrese po Foreign Key-u</h4>
				<ul class="foreign_key"></ul>
			</div>
			<h4 class="merge_report_title" data-trgt=".merge_report">Spoji finansije</h4>
			<ul class="merge_report"></ul>
			<div class="group_report_foreign_key">
				<h4 class="report_foreign_key_title" data-trgt=".report_foreign_key">Spoji finansije po Foreign Key</h4>
				<ul class="report_foreign_key"></ul>
			</div>
			<h4 class="map_actions_title" data-trgt=".map_actions">Mapa...</h4>
			<ul class="map_actions">
				<li><a href="#" class="map_get_geocode">Postavi markere</a></li>
			</ul>
			<h4 class="columns_title" data-trgt=".columns">Prikaži/Sakri kolone</h4>
			<ul class="columns">
			</ul>
			<?php // gen_menu($csv, $i, "Status"); gen_menu($csv, $i, "DatumOsnivanja");?>
		</nav>
		<div class="print_back"></div>
		<div class="sticky_header"></div>
		<div class="list_company_wrapper">
			<ul class="list_company"></ul>
		</div>
		<div class="loading"><p>...UČITAVANJE...</p></div>
		<div class="gmap">
			<div id="map"></div>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuC0GEYnzrcDwJ8-FL-CqhoPQodd6pHpk&callback=initMap" async defer></script>
            <script>
                var map;
                function initMap() {
                    map = new google.maps.Map(document.getElementById('map'), {
                        center: {lat: 44.800, lng: 20.389},
                        zoom: 8
                    });
                }
            </script>
		</div>

		<script type="text/javascript">
			$( document ).ready(function(){
				$.ajaxSetup({ cache: false });
				window.ss = window.ss || {};

				ss.loaded_csv = "";
				
				ss.nav_selected = function(trgt, rst){
					$(rst).removeClass("nav_selected");
					$(trgt).addClass("nav_selected");
				};

				ss.nav_h4_autoshow = function(){
					$("."+$(this).parent().parent().attr("class")+"_title").trigger("click");
				}

				ss.label_ironing = function(){
					var label_count = 1;
					$(".sticky_header div").each(function(){
						$(this).width($(".list_company li:nth-child(1) div:nth-child("+label_count+")").width());
						label_count++;
					});
				};

				ss.click_display_style = function(){
					$("nav .display_style")
						.off()
						.on("click", function(){
							if($(this).hasClass("ds_both")){
								document.documentElement.style.setProperty("--nav-width", "250px");
								document.documentElement.style.setProperty("--map-height", "50vh");
								document.documentElement.style.setProperty("--list-height", "50vh");
								ss.nav_selected($(this), "nav .display_style");
								$("nav").removeClass("print_friendly");
								// $(".list_company_wrapper").mCustomScrollbar("disable",false);
								// $(".list_company_wrapper").mCustomScrollbar("update");
								// $("nav").mCustomScrollbar({theme:"light"});
							}else if($(this).hasClass("ds_list")){
								document.documentElement.style.setProperty("--nav-width", "250px");
								document.documentElement.style.setProperty("--map-height", "0vh");
								document.documentElement.style.setProperty("--list-height", "100vh");
								ss.nav_selected($(this), "nav .display_style");
								$("nav").removeClass("print_friendly");
								// $(".list_company_wrapper").mCustomScrollbar("disable",false);
								// $(".list_company_wrapper").mCustomScrollbar("update");
								// $("nav").mCustomScrollbar({theme:"light"});
							}else if($(this).hasClass("ds_map")){
								document.documentElement.style.setProperty("--nav-width", "250px");
								document.documentElement.style.setProperty("--map-height", "100vh");
								document.documentElement.style.setProperty("--list-height", "0vh");
								ss.nav_selected($(this), "nav .display_style");
								$("nav").removeClass("print_friendly");
								// $(".list_company_wrapper").mCustomScrollbar("disable",false);
								// $(".list_company_wrapper").mCustomScrollbar("update");
								// $("nav").mCustomScrollbar({theme:"light"});
							}else if($(this).hasClass("ds_print")){
								$(".print_back").show();
								document.documentElement.style.setProperty("--nav-width", "0px");
								ss.nav_selected($(this), "nav .display_style");
								$("nav").addClass("print_friendly");
								// $(".list_company_wrapper").mCustomScrollbar("destroy");
								ss.label_ironing();
								// var html = $(document).html();
							}
							// $($(this).attr("data-trgt")).slideToggle();
						});
				};

				ss.click_print_back = function(){
					$(".print_back")
						.off()
						.on("click", function(){
							$(".ds_both").trigger("click");
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
									loaded_label_collect += "<div class=\""+loaded_label[y]+"\">"+loaded_label[y]+"</div>";
								}
								var c_1 = "<li>", c_2 = "", c_3 = "";
								for(var y = 0; y < loaded_label.length; y++){
									c_1 += "<div class=\""+loaded_label[y]+"\">"+loaded_label[y]+"</div>";
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
								$(".data_load").load("list_merge_address.php?loaded_csv="+$(this).attr("data-csv"), function(){
									$("nav .merge_address").empty().append(list_merge);
									$("nav .merge_address li a").each(function(){
										if($(this).attr("data-csv") == ss.loaded_csv){
											$(this).parent().remove();
										}
									});
									ss.click_merge_address();
									$("nav .merge_report").empty().append(list_merge);
									$("nav .merge_report li a").each(function(){
										if($(this).attr("data-csv") == ss.loaded_csv){
											$(this).parent().remove();
										}
									});
									ss.click_merge_report();
								});
								$(".loading").fadeOut(150);
							});
							ss.nav_selected($(this), "nav .load_file li a");
							$("."+$(this).parent().parent().attr("class")+"_title").trigger("click");
						});
				};

				ss.click_merge_address = function(){
					$(".merge_address li a")
						.off()
						.on("click", function(e){
							e.preventDefault();
							$(".data_load").load("merge_address.php?merge_address=import/"+$(this).attr("data-csv"), function(){
								var collect = "";
								var k = 0;
								for(k=0; k < loaded_label[0].length; k++){
									if(merge_label.includes(loaded_label[k])){
										collect += "<li><a href=\"\" data-label=\""+loaded_label[k]+"\">"+loaded_label[k]+"</a></li>";
									}
								}
								$(".group_address_foreign_key .foreign_key").empty();
								if(collect != ""){
									$(".group_address_foreign_key .foreign_key").append(collect);
									ss.click_foreign_key();
								}
							});
							ss.nav_selected($(this), "nav .merge_address li a");
							$("."+$(this).parent().parent().attr("class")+"_title").trigger("click");
						});
				};

				ss.click_foreign_key = function(){
					$(".group_address_foreign_key .foreign_key li a").on("click", function(e){
						e.preventDefault();
						var data_data_label = $(this).attr("data-label");
						var data_data_value = "";
						var data_address_concat = "";
						var address_count = 0;
						var address_line_1 = "";
						$(".list_company li").each(function(){
							$(this).append("<div class=\"addresses\"></div>");
							data_data_value = $(this).find("."+data_data_label).text();
							address_count = 0;
							for(var k = 0; k < merge_csv.length; k++){
								if(merge_csv[k][data_data_label] == data_data_value){
									address_line_1 = merge_csv[k]["KucniBroj"]+", "+merge_csv[k]["Ulica"]+", "+merge_csv[k]["Opstina"];
									data_address_concat = "<div class=\"address\" data-relationship=\"\" id=\""+k+address_count+"\" data-address=\""+address_line_1+"\" data-lat=\"\" data-lng=\"\" data-type=\""+merge_csv[k]["TipAdreseOpis"]+"\"><strong>"+merge_csv[k]["TipAdreseOpis"]+"</strong><br>"+address_line_1+"</div>";
									$(this).find(".addresses").append(data_address_concat);
									data_address_concat ="";
									address_line_1 = "";
									address_count++;
								}
							}
							if(address_count == 0){
								$(this).find("div:last-of-type").html("Adrese");
							}
						});
						$(".list_company li .addresses .address").each(function(){
							$(this).attr("data-relationship", $(this).parent().parent().find(".Relationship").html());
						});
						ss.label_ironing();
						$("."+$(this).parent().parent().attr("class")+"_title").trigger("click");
					});
				};


				ss.click_merge_report = function(){
					$(".merge_report li a")
						.off()
						.on("click", function(e){
							e.preventDefault();
							$(".data_load").load("merge_report.php?merge_report=import/"+$(this).attr("data-csv"), function(){
								var collect = "";
								var k = 0;
								for(k=0; k < merge_report_label[0].length; k++){
									if(merge_report_label.includes(merge_report_label[k])){
										collect += "<li><a href=\"\" data-label=\""+merge_report_label[k]+"\">"+merge_report_label[k]+"</a></li>";
									}
								}
								$(".group_report_foreign_key .report_foreign_key").empty();
								if(collect != ""){
									$(".group_report_foreign_key .report_foreign_key").append(collect);
									ss.click_report_foreign_key();
								}
							});
							ss.nav_selected($(this), "nav .merge_report li a");
							$("."+$(this).parent().parent().attr("class")+"_title").trigger("click");
						});
				};


				ss.click_report_foreign_key = function(){
					$(".group_report_foreign_key .report_foreign_key li a").on("click", function(e){
						e.preventDefault();
						var data_data_label = $(this).attr("data-label");
						var data_data_value = "";
						var data_report_concat = "";
						var report_count = 10000;
						// var report_line_1 = "";
						$(".list_company li").each(function(){
							$(this).append("<div class=\"report\"></div>");
							data_data_value = $(this).find("."+data_data_label).text();
							report_count = 10000;
							for(var k = 0; k < merge_report_csv.length; k++){
								if(merge_report_csv[k][data_data_value] == data_data_value){
									// report_line_1 = merge_report_csv[k]["KucniBroj"]+", "+merge_report_csv[k]["Ulica"]+", "+merge_report_csv[k]["Opstina"];
									data_report_concat = ""+
										"<div class=\"report_item\" id=\""+k+report_count+"\">"+
											"<strong>"+merge_report_csv[k]["YEAR"]+"</strong>"+
											"<div class=\"r_table\">"+
												"<div class=\"r_row r_title\">"+
													"<div class=\"r_cell\">AOP 0402</div>"+
													"<div class=\"r_cell\">AOP 1002</div>"+
													"<div class=\"r_cell\">AOP 1009</div>"+
													"<div class=\"r_cell\">AOP 1024</div>"+
													"<div class=\"r_cell\">AOP 1026</div>"+
													"<div class=\"r_cell\">AOP 1023</div>"+
													"<div class=\"r_cell\">AOP 1019</div>"+
													"<div class=\"r_cell\">AOP 1063</div>"+
													"<div class=\"r_cell\">AOP 1064</div>"+
													"<div class=\"r_cell\">AOP 1065</div>"+
												"</div>"+
												"<div class=\"r_row\">"+
													"<div class=\"r_cell\">"+merge_report_csv[k]['AOP 0402']+"</div>"+
													"<div class=\"r_cell\">"+merge_report_csv[k]['AOP 1002']+"</div>"+
													"<div class=\"r_cell\">"+merge_report_csv[k]['AOP 1009']+"</div>"+
													"<div class=\"r_cell\">"+merge_report_csv[k]['AOP 1024']+"</div>"+
													"<div class=\"r_cell\">"+merge_report_csv[k]['AOP 1026']+"</div>"+
													"<div class=\"r_cell\">"+merge_report_csv[k]['AOP 1023']+"</div>"+
													"<div class=\"r_cell\">"+merge_report_csv[k]['AOP 1019']+"</div>"+
													"<div class=\"r_cell\">"+merge_report_csv[k]['AOP 1063']+"</div>"+
													"<div class=\"r_cell\">"+merge_report_csv[k]['AOP 1064']+"</div>"+
													"<div class=\"r_cell\">"+merge_report_csv[k]['AOP 1065']+"</div>"+
												"</div>"+
											"</div>"+
										"</div>";
									$(this).find(".report").append(data_report_concat);
									data_report_concat ="";
									// report_line_1 = "";
									report_count++;
								}
							}
							if(report_count == 0){
								$(this).find("div:last-of-type").html("Reports");
							}
						});
						ss.label_ironing();
						$("."+$(this).parent().parent().attr("class")+"_title").trigger("click");
					});
				};

				ss.map_get_geocode = function(){
					$(".map_get_geocode")
						.off()
						.on("click", function(e){
							e.preventDefault();
							$(".list_company .address").each(function(){
								var dis = $(this).attr("id");
								var d_lat = "";
								var d_lng = "";
								var relationship = $(this).attr("data-relationship");
								var relationship_marker = "";
								if(relationship == "supplier"){
									relationship_marker = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";
								}else if(relationship == "competition"){
									relationship_marker = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
								}else{
									relationship_marker = "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png";
								}
								$.ajax({url: "https://maps.googleapis.com/maps/api/geocode/json?address="+$(this).attr("data-address")+", Srbija&key=AIzaSyBuC0GEYnzrcDwJ8-FL-CqhoPQodd6pHpk"})
								.done(function(result){
									if(result.results[0].geometry.location.lng != undefined){
										d_lat = result.results[0].geometry.location.lat;
										d_lng = result.results[0].geometry.location.lng;
										console.log(d_lng);
										$("#"+dis).attr("data-lat", d_lat);
										$("#"+dis).attr("data-lng", d_lng);
										var myLatlng = new google.maps.LatLng(d_lat,d_lng);
										var marker = new google.maps.Marker({
											position: myLatlng,
											title: $(this).attr("data-address"),
											animation: google.maps.Animation.DROP,
											icon: { url: relationship_marker}
										});
										marker.setMap(map);
										$(".columns").empty();
										$(".sticky_header div").each(function(){
											$(".columns").append("<li class=\""+$(this).attr("class")+"\"><a class=\"nav_selected\" href=\"#\">"+$(this).attr("class")+"</a></li>");
										});
										$(".columns li").on("click", function(){
											$(".list_company ."+$(this).attr("class")).slideToggle(50);
											$(".sticky_header ."+$(this).attr("class")).slideToggle(50);
											$(this).find("a").toggleClass("nav_selected");
											ss.label_ironing();
										});
									}
								});
							});
						});
				};

				ss.click_print_back();
				ss.click_display_style();
				ss.click_h4();
				ss.click_load_file();
				ss.map_get_geocode();

				$.mCustomScrollbar.defaults.scrollButtons.enable=false;
				$.mCustomScrollbar.defaults.axis="yx";
				$.mCustomScrollbar.defaults.scrollbarPosition="inside";
				$.mCustomScrollbar.defaults.autoDraggerLength=true;
				$.mCustomScrollbar.defaults.autoExpandScrollbar=true;
				$.mCustomScrollbar.defaults.contentTouchScroll=20;
				$.mCustomScrollbar.defaults.documentTouchScroll=true;
				$.mCustomScrollbar.defaults.autoHideScrollbar=true;
				// $(".list_company_wrapper").mCustomScrollbar({theme:"light"});
				$("nav").mCustomScrollbar({theme:"light"});
				
				$(".loading").fadeOut(150);
			});
		</script>
		
	</body>
</html>