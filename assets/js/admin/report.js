$(function() {
	var ctx = $("#yearly-chart").get(0).getContext('2d');
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
			datasets: 
			[
				{
					label: 'Employers',
					backgroundColor: '#F44336',
					data: [12, 19, 10, 17, 28, 52, 4, 13, 11, 31, 23, 41], //to populate from database
				}, 
				{
					label: 'Applicants',
					backgroundColor: '#803690',
					data: [17, 22, 5, 5, 23, 33, 5, 3, 53, 32, 12, 23, 12], //to populate from database
				}, 
				{
					label: 'Job Posts',
					backgroundColor: '#46BFBD',
					data: [20, 21, 12, 5, 31, 13, 20, 12, 43, 53, 87, 91],	//to populate from database
				}, 
				{
					label: 'Applications',
					backgroundColor: '#FDB45C',
					data: [30, 29, 15, 5, 20, 35, 10, 23, 12, 31, 13, 31], //to populate from database
				}

			]
		}
	});
	
});