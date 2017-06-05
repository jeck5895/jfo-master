$(function(){
	$('input[name=termsCondition]').change(function(){
 		if(!(this.checked)){

 			$(".terms-condition").notify(
 				"You must agree to Terms and Condition", 
 				{ position:"top" }
 				);

 			$('input[name=register-applicant]').prop('disabled',true);
 		}
 		else{
 			console.log('checked');
 			$('input[name=register-applicant]').prop('disabled',false);
 		}
 	});
});
