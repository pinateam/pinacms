$.fn.pfd = function(options)
{
	var filterId = 0;
		for(filterId in options.filters) {
				//добавление слайдера и канвы
				var html = "<div id=\"filter_"+filterId+"\" style=\"display: block; width: 200px; padding: 0 5px; margin: 10px 0px 10px 0px;\">";
				//добавление канвы, если существует объект с данными для расчета координат
				html += "<p>"+options.filters[filterId]["title"]+"</p>";
				if(typeof options.filters[filterId]["data"] != "undefined") {
						html += "<canvas id=\"canvas_"+filterId+"\" style=\"border: 1px solid grey; width: 200px; height: 20px;\"></canvas>";
				}
				//alert(options.ranges[filterId]);
				var value = 0;
				if(typeof options.ranges[filterId] != "undefined") {
						value = options.ranges[filterId];
				} else {
						value = options.filters[filterId]["min"]+";"+options.filters[filterId]["max"];
				}
				html += "<input id=\""+filterId+"\" class=\"slider\" type=\"slider\" value=\""+value+"\" /></div><br />";
				$(".products_filters").append(html);

				//инициализация слайдера
				var slider = $("#"+filterId);
				if(slider.val() == ""){
						slider.val("0;"+options.filters[filterId]["max"]);
				}
				slider.slider({
						from: options.filters[filterId]["min"],
						to: options.filters[filterId]["max"],
						step: options.filters[filterId]["step"],
						smooth: true,
						format: { format: "##"},
						round: 0,
						dimension: "",
						skin: "plastic",
						callback: function (value) {
								options.callback.call();
								if(typeof options.filters[filterId]["data"] != "undefined") {
										drawCanvases();
								}
						}
				});
		}

		if(typeof options.filters[filterId] != "undefined" && typeof options.filters[filterId]["data"] != "undefined") {
				drawCanvases();
		}

		function drawCanvases() {
				var xy = [];
				for(findFilterId in options.filters) {
						xy = findXY(findFilterId);
						draw("canvas_"+findFilterId, xy, findFilterId);						
				}
		}

		function findXY(findFilterId) {
				ranges = [];
				x = [];
				countFilters = 0;
				for(filterId in options.filters) {
						++countFilters;
						if(filterId != findFilterId) {
								ranges = $("#"+filterId).val().split(";");
								dx = options.filters[filterId]["dx"];
								min = options.filters[filterId]["min"];
								left = Math.round((ranges[0] - min) * dx);
								right = Math.round((ranges[1] - min) * dx);
								//console.log(left, ranges[0], dx);
								for(i in options.filters[filterId]["data"]) {
										if(options.filters[filterId]["data"][i] >= left && options.filters[filterId]["data"][i] <= right) {
												if(typeof options.filters[findFilterId]["data"][i] == "undefined" || isNaN(options.filters[findFilterId]["data"][i])){
														continue;
												}
												x[i] = options.filters[findFilterId]["data"][i];
										}
								}
						}
				}

				if(countFilters == 1) {
						x = options.filters[findFilterId]["data"];
				}

				x.sort(function(a, b) {
						if(a > b) return 1;
						if(a < b) return -1;
						return 0;
				});
				//alert(x);

				xy = [];
				xi = x[0];
				yi = 1;
				j = 0;				
				dy = options.filters[findFilterId]["dy"];

				if(x.length > 1) {
						for(var i = 1; i < x.length; i++) {
								if(x[i] > xi){
										yi = getY(yi, dy);
										xy[j] = [];
										if(j > 0 && xi - xy[j-1][1][0] < 8) {										
												xy[j].push([xy[j-1][0][0], options.height]);
												xy[j].push([xi, yi]);
												xy[j].push([xi + 2, options.height]);
										} else {
												xy[j] = getXY(findFilterId, xi, yi);
										}
										++j;
										yi = 0;
										xi = x[i];
								}
								++yi;
								if(i == x.length - 1) {
										if(typeof xy[j] == "undefined") {
												xy[j] = [];
										}
										xy[j] = getXY(findFilterId, xi, getY(yi, dy));
								}
						}
				} else {
						if(typeof xy[j] == "undefined") {
								xy[j] = [];
						}
						xy[j] = getXY(findFilterId, xi, getY(yi, dy));
				}

				/*for(i in xy) {
						console.log(xy[i][0], xy[i][1], xy[i][2]);
				}*/
								
				return xy;
		}

		function getXY(findFilterId, x, y) {
				var xy = [];
				xy.push([x - options.filters[findFilterId]['offset'], options.height]);
				xy.push([x, y]);
				xy.push([x + options.filters[findFilterId]['offset'], options.height]);
				return xy;
		}

		function getY(y, dy) {
				y = options.height - Math.round(y * dy);
				y = Math.round(y / 2);
				if(y > options.height)
				{
						y = 0;
				}
				if(y < 0)
				{
					 	y = options.height - (options.height - 1);
				}

				return y;
		}

		function draw(canvasId, xy, filterId) {
				var canvas = document.getElementById(canvasId);
				var ctx = canvas.getContext('2d');
				canvas.height = options.height;
				canvas.width = options.width;
				ctx.beginPath();  
				ctx.fillStyle = options.color;
				
				for(i in xy) {
					//console.log(i);
						x1 = xy[i][0][0];
						y1 = xy[i][0][1];
						x2 = xy[i][1][0];
						y2 = xy[i][1][1];
						x3 = xy[i][2][0];
						y3 = xy[i][2][1];

						ctx.moveTo(x1,y1);
						//todo придумать как объединить несколько рядом стоящих кривых бизье в одну
						if(i < xy.length - 1) {
								h = parseInt(i)+1;
								nextX2 = xy[h][1][0];
								diff = (nextX2 - x3);
								if(diff <= options.filters[filterId]['dx']){
										x3 = xy[h][2][0];
								}

						}
						ctx.quadraticCurveTo(x2, y2, x3, y3);
				}
				
				ctx.fill();
				ctx.strokeStyle = options.color;
				ctx.stroke();
		}
}