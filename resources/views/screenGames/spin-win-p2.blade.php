<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('spin/p2.css') }}" />
</head>

<body>
    <div id="chart"></div>
    <div id="balloon-container"></div>
    <form action="{{ route('spin-win-page-p1') }}" id="first_page_spin" method="get">
    </form>
    <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const theSpinningWheel = document.getElementById("chart");
        const balloonContainer = document.getElementById("balloon-container");

        function random(num) {
            return Math.floor(Math.random() * num);
        }

        function getRandomStyles() {
            var r = random(255);
            var g = random(255);
            var b = random(255);
            var mt = random(200);
            var ml = random(50);
            var dur = random(5) + 5;
            return `
                    background-color: rgba(${r},${g},${b},0.7);
                    color: rgba(${r},${g},${b},0.7); 
                    box-shadow: inset -7px -3px 10px rgba(${r - 10},${g - 10},${b - 10},0.7);
                    margin: ${mt}px 0 0 ${ml}px;
                    animation: float ${dur}s ease-in infinite
                    `;
        }

        function createBalloons(num) {
            for (var i = num; i > 0; i--) {
                var balloon = document.createElement("div");
                balloon.className = "balloon";
                balloon.style.cssText = getRandomStyles();
                balloonContainer.append(balloon);
            }
        }

        function removeBalloons() {
            balloonContainer.style.opacity = 0;
            setTimeout(() => {
                balloonContainer.remove();
            }, 500);
        }
        // BALLOON Container

        var dataAPI = @json($prizeDataJson);
        window.addEventListener("load", function() {
            // createBalloons(30)
            console.log("API Response:", @json($prizeDataJson));
            // dataAPI = @json($prizeDataJson);
            console.log("api", JSON.parse(dataAPI));
            dataAPI = JSON.parse(dataAPI);
            var padding = {
                    top: 20,
                    right: 40,
                    bottom: 0,
                    left: 0
                },
                w = 500 - padding.left - padding.right,
                h = 500 - padding.top - padding.bottom,
                r = Math.min(w, h) / 2,
                rotation = 0,
                oldrotation = 0,
                picked = 100000,
                oldpick = [],
                color = d3.scale.category20(); //category20c()
            var data = dataAPI;
            var svg = d3
                .select("#chart")
                .append("svg")
                .data([data])
                .attr("width", w + padding.left + padding.right)
                .attr("height", h + padding.top + padding.bottom);
            var container = svg
                .append("g")
                .attr("class", "chartholder")
                .attr(
                    "transform",
                    "translate(" +
                    (w / 2 + padding.left) +
                    "," +
                    (h / 2 + padding.top) +
                    ")"
                );
            var vis = container.append("g");
            var pie = d3.layout
                .pie()
                .sort(null)
                .value(function(d) {
                    return 1;
                });
            // declare an arc generator function
            var arc = d3.svg.arc().outerRadius(r);
            // select paths, use arc generator to draw
            var arcs = vis
                .selectAll("g.slice")
                .data(pie)
                .enter()
                .append("g")
                .attr("class", "slice");

            arcs
                .append("path")
                .attr("fill", function(d, i) {
                    return color(i);
                })
                .attr("d", function(d) {
                    return arc(d);
                });
            arcs
                .append("text")
                .attr("transform", function(d) {
                    d.innerRadius = 0;
                    d.outerRadius = r;
                    d.angle = (d.startAngle + d.endAngle) / 2;
                    return (
                        "rotate(" +
                        ((d.angle * 180) / Math.PI - 90) +
                        ")translate(" +
                        (d.outerRadius - 10) +
                        ")"
                    );
                })
                .attr("text-anchor", "end")
                .text(function(d, i) {
                    return data[i].label;
                });
            container.on("click", spin);

            function spin(d) {
                container.on("click", null);
                //all slices have been seen, all done
                console.log(
                    "OldPick: " + oldpick.length,
                    "Data length: " + data.length
                );
                if (oldpick.length == data.length) {
                    console.log("done");
                    container.on("click", null);
                    return;
                }
                var ps = 360 / data.length,
                    pieslice = Math.round(1440 / data.length),
                    rng = Math.floor(Math.random() * 1440 + 360);

                rotation = Math.round(rng / ps) * ps;

                picked = Math.round(data.length - (rotation % 360) / ps);
                picked = picked >= data.length ? picked % data.length : picked;
                if (oldpick.indexOf(picked) !== -1) {
                    d3.select(this).call(spin);
                    return;
                } else {
                    oldpick.push(picked);
                }
                rotation += 90 - Math.round(ps / 2);
                vis
                    .transition()
                    .duration(3000)
                    .attrTween("transform", rotTween)
                    .each("end", function() {
                        //mark question as seen
                        d3.select(".slice:nth-child(" + (picked + 1) + ") path").attr(
                            "fill",
                            "#111"
                        );
                        //populate question
                        d3.select("#question h1").text(data[picked].question);
                        oldrotation = rotation;
                        /* Get the result value from object "data" */
                        console.log(data[picked].value);
                        /* Comment the below line for restrict spin to sngle time */
                        Swal.fire({
                            title: "You Won : " + data[picked].label,
                            confirmButtonText: "Save and Get to Home again",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Swal.fire("Saved!", "", "success");
                                // Here you Go back to Home again + Prize ID 
                                const firstPageForm = document.getElementById("first_page_spin");
                                firstPageForm.submit();
                            }
                        });
                        theSpinningWheel.remove();
                        createBalloons(30);
                    });
                // createBalloons(30) ;
            }
            //make arrow
            svg
                .append("g")
                .attr(
                    "transform",
                    "translate(" +
                    (w + padding.left + padding.right) +
                    "," +
                    (h / 2 + padding.top) +
                    ")"
                )
                .append("path")
                .attr(
                    "d",
                    "M-" + r * 0.15 + ",0L0," + r * 0.05 + "L0,-" + r * 0.05 + "Z"
                )
                .style({
                    fill: "black"
                });
            //draw spin circle
            container
                .append("circle")
                .attr("cx", 0)
                .attr("cy", 0)
                .attr("r", 60)
                .style({
                    fill: "white",
                    cursor: "pointer"
                });
            //spin text
            container
                .append("text")
                .attr("x", 0)
                .attr("y", 15)
                .attr("text-anchor", "middle")
                .text("SPIN")
                .style({
                    "font-weight": "bold",
                    "font-size": "30px"
                });

            function rotTween(to) {
                var i = d3.interpolate(oldrotation % 360, rotation);
                return function(t) {
                    return "rotate(" + i(t) + ")";
                };
            }

        });
    </script>
</body>

</html>
