<?php if ($draw){ ?>



<script>

	$(function(){

		var cy = window.cy = cytoscape({
			container: document.getElementById('cy'),

			boxSelectionEnabled: false,
			autounselectify: false,

			layout: {
				name: 'dagre',
				fit:true
				
			},
			resize : true,
			<?php echo JS_PAN; ?>
			minZoom: 1e-50,
			maxZoom: 1e50,
			zoomingEnabled: true,
			userZoomingEnabled: true,
			panningEnabled: true,
			userPanningEnabled: true,
			motionBlur: true,

			
			


			style: [
			{
				selector: 'node',
				style: {
					'border-width': 'data(border)',
					'border-color': 'yellow',
					'content': 'data(id)',
					'width': 25,	
					'height' : 25,					
					'text-opacity': 1,
					'text-valign': 'center',
					'text-halign': 'center',
					'color': 'white',
					'text-outline-width': 1,
					'text-outline-color': '#AC516E',
					'font-family': 'iryekan',
					'font-size' : '7',
					'background-color': 'data (bc)'								
				}
			},

			{
				selector: 'edge',
				style: {
					'width': 1,
					'text-opacity': 0.5,
					'control-point-distance' : '30',
					'shadow-color' : 'white',
					'shadow-offset-y' :'5',
					'shadow-blur' : '5',
					'text-margin-y': '8',
					'text-margin-x': '5',
					'font-family': 'iryekan',
					'font-size' : '8',
					'label' : 'data(label)',
					'text-outline-width': 0.1,
					'text-outline-color': 'white',
					'target-arrow-shape': 'triangle',
					'line-color': 'white',
					'target-arrow-color': 'white',
					'curve-style': 'bezier',
					'<pos>-arrow-fill' : 'tee',


				}
			}
			],

			elements: {
				nodes: [
				<?php 
				$i=0;
				foreach ($nahaee as $state) {
					if ($state==$final_start) $start_color = "#00B16A";
					else $start_color = "#F5F5F5";

					if ($final_final[$i] == 1) 
					{
						$start_color = "#F64747";
						$border=1;
					}
					else {
						$border = 0;
					}
					
					if(end($nahaee) !== $state){
						echo "{ data: { id: '$state' , bc : '$start_color' , border :'$border'  } },
						";
					}
					else 
						echo "{ data: { id: '$state' , bc : '$start_color' , border :'$border' } }
					";
					$i++;
				} ?>
				
				],
				edges: [
				<?php
				foreach ($nahaee as $state) {

					foreach ($alphabets as $char) {
						$koja = $arrows[$state][$char];
						echo "{ data: { source: '$state', target: '$koja'  , label:'$char' }  },
						";

					} }
					?>
					]
				},
			});



	});


/*
			$("div#rightinfo").html(''+
				<?php echo json_encode($nahaee) ?>
				+' ')*/
			</script>

			<style>
				

				#cy {
					
					<?php if($lang=="en")  echo "width: 690px;"; else echo "width: 690px;";?>
					
					height: 580px;
					<?php if($lang=="en")  echo "left: 575px;"; else echo "left: 95px;";?>
					
					position: absolute;				
					top: 230px;
					overflow: scroll; 
					
				}
				
				#load {			
					
					<?php if($lang=="en")  echo "width: 690px;"; else echo "width: 690px;";?>
					
					height: 580px;
					<?php if($lang=="en")  echo "left: 575px;"; else echo "left: 95px;";?>
					
					position: absolute;				
					top: 230px;
					overflow: scroll; 
					
				
				}

			</style>
			<script>

				function saveaspng(){
					var png64 = cy.png({
						bg: '#272822',
						scale : 9
					});
					$('#png-eg').attr('href', png64);
				}


				function saveasjpg(){
					var png64 = cy.jpg({
						bg: '#272822',
						scale : 10
					});

					$('#jpg-eg').attr('href', png64);
				}



				$(function(){

					cy.resize();
					cy.center();
				});


			</script>

<style>
	
	.center-block {
    display: block;
    margin : auto;
 }

</style>
<span class="load center-block" id="load" style="display:none; top:60%;" >
	<img src="496.gif"  alt="loading" width="196"  class="img-responsive center-block">
</span>
			<div style="overflow:hidden; display:none;" class="blink1"  id="cy">
				





			</div>


		</div>


<script>
	
	$(".load").show();
	
	$(".load").fadeOut(3000);
	$(".blink1").fadeIn(2000);

</script>

		<?php } else { ?>

		<div class="col-lg-7" >

			<?php 
			if($lang=="fa")
				echo '<img src="source/examplefa.png" id="img-left" style="width:100%;" alt="draw_automata" title="draw_automata"  class="img-responsive img-rounded">';

			else echo '<img src="source/exampleen.png" id="img-left" style="width:100%;" alt="draw_automata" title="draw_automata" class="img-responsive img-rounded">';

			?>

			<div id="draw" style="display:none;color:white; background-image:url(pixel_weave.png); margin-top:15px; margin-bottom:15px;">
				<script src="source/fsm.js"></script>
				<script>

					if (typeof btoa == 'undefined') {
						function btoa(str) {
							var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
							var encoded = [];
							var c = 0;
							while (c < str.length) {
								var b0 = str.charCodeAt(c++);
								var b1 = str.charCodeAt(c++);
								var b2 = str.charCodeAt(c++);
								var buf = (b0 << 16) + ((b1 || 0) << 8) + (b2 || 0);
								var i0 = (buf & (63 << 18)) >> 18;
								var i1 = (buf & (63 << 12)) >> 12;
								var i2 = isNaN(b1) ? 64 : (buf & (63 << 6)) >> 6;
								var i3 = isNaN(b2) ? 64 : (buf & 63);
								encoded[encoded.length] = chars.charAt(i0);
								encoded[encoded.length] = chars.charAt(i1);
								encoded[encoded.length] = chars.charAt(i2);
								encoded[encoded.length] = chars.charAt(i3);
							}
							return encoded.join('');
						}
					}

				</script>

				<canvas id="canvas" width="650" height="300">
					<span class="error">مرورگر شما از کانواس پشتیبانی نمیکند</span>
				</canvas>
				<br>
				<center>  <a style="font-size:11px; margin-bottom:10px;" class="btn btn-primary btn-xs" onclick="javascript:saveAsPNG()" > <?=SAVEAS?> PNG</a>
					<a style="font-size:11px; margin-bottom:10px;" class="btn btn-info btn-xs" > <?=Dhelp?> </a>  
					
				</center> 

			</div>
			<div id="cih" style="display:none; color:white;"> 

				<div class="row" style="margin-top:35px;">
					

					<div class="col-lg-12">
						
						<div class="alert alert-warning"><i class="fa fa-user-secret" aria-hidden="true"></i> <?=COMMING_SOON?> ... </div>
						<div class="alert alert-danger"><br>

							<i class="fa fa-info-circle" aria-hidden="true"></i> <?=CMTEXT?> 

							<br><br></div>

							<div class="alert alert-info">
								<i class="fa fa-dwonload" aria-hidden="true"></i>  <?=DONTHAVEFILE?> : <br><hr>
								<a download="2.txt" href="myfile/2.txt" class="btn btn-default btn-sm">0 1 | - A B + C D + E F</a>
								<a download="4.txt" href="myfile/4.txt" class="btn btn-default btn-sm">1 2 3 4 | - A + B + C D E</a>

							</div>

						</div>




					</div>

				</div>

				<div id="show" style="display:none; color:white;"> 

					<div class="row" style="margin-top:35px;">
						

						<div class="col-lg-12">
							
							<div class="alert alert-info"><br>

								<i class="fa fa-list-ol" aria-hidden="true"></i> <?=WHATWEDO?> 

								<br><br></div>

							</div>




						</div>

					</div>

				</div>
			</div>

			<?php } ?>