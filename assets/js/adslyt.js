//for fixed adsbox when scrolled down
// $(document).ready(function(){
// 	var ads_pos = $(".ads-container").offset().top;
// 	var windowWidth = $(window).innerWidth();

// 	$(window).resize(function() {
// 		windowWidth = $(window).innerWidth();
// 	});

// 	$(window).on("scroll", function(e){
//         var y = $(this).scrollTop();

//         if(y >= ads_pos && windowWidth >= 992){
//             $(".ads-container").addClass("fixedRight");
//         }
//         else{
//             $(".ads-container").removeClass("fixedRight");
//         }
//     });
// });