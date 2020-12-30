var options = {
	series: [{
		name: 'Likes',
		data: data
	}],
	chart: {
		height: 350,
		type: 'line',
		toolbar: {
			show: false,
		}
	},
	grid: {
		show: false,
		padding: {
			left: 0,
			right: 0
		}
	},
	stroke: {
		width: 7,
		curve: 'smooth'
	},
	xaxis: {
		type: 'datetime',
        categories: [
            '1/11/2020', 
            '1/11/2020', 
            '2/11/2020', 
            '3/11/2020', 
            '4/11/2020', 
            '5/11/2020', 
            '6/11/2020', 
            '7/11/2020', 
            '8/11/2020', 
            '9/11/2020', 
            '10/11/2020', 
            '11/11/2020', 
            '12/11/2020', 
            '1/11/2021', 
        ],
	},
	title: {
		text: 'Total rata - rata aset yang masuk',
		align: 'center',
		style: {
			fontSize: "16px",
			color: '#666'
		}
	},
	fill: {
		type: 'gradient',
		gradient: {
			shade: 'dark',
			gradientToColors: [ '#1b00ff'],
			shadeIntensity: 1,
			type: 'horizontal',
			opacityFrom: 1,
			opacityTo: 1,
			stops: [0, 100, 100, 100]
		},
	},
	markers: {
		size: 4,
		colors: ["#FFA41B"],
		strokeColors: "#fff",
		strokeWidth: 2,
		hover: {
			size: 7,
		}
	},
	yaxis: {
		min: -10,
		max: 50,
		title: {
			text: 'aset',
		},
	}
};

var chart = new ApexCharts(document.querySelector("#chart1"), options);
chart.render();
