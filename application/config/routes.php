<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'authenticate/auth';
$route['login/facebook'] = 'authenticate/login_facebook';
$route['login/google'] = 'authenticate/login_google';
$route['accounts/recovery'] = "authenticate/account_recovery";
$route['accounts/resetpassword'] = "authenticate/reset_password";
$route['accounts/employers/activate'] = 'authenticate/employer_account_activate';

$route['admin/account/settings'] = 'admin/account_settings';
$route['admin/jobs/(:any)'] = 'admin/get_job_post/$1';
$route['admin/review/jobs'] = 'admin/review_job_post';
$route['admin/applicants/for-review'] = 'admin/applicants_for_review';
$route['admin/applicants/public'] = 'admin/applicants_public';
$route['admin/applicants/private'] = 'admin/applicants_private';
$route['admin/applicants/inactive'] = 'admin/applicants_inactive';
$route['admin/advertisements/sliders'] = 'admin/get_advertisements_sliders';
$route['admin/advertisements/get/featured_jobs'] = 'admin/get_featured_jobs';
$route['admin/advertisements/get/featured_jobs_by_location'] = 'admin/get_featured_jobs_by_location';
$route['admin/advertisements/get/featured_companies'] = 'admin/get_featured_companies';
$route['admin/categories'] = 'admin/get_categories';
$route['admin/maintenance/keywords'] = 'admin/keywords';
$route['admin/maintenance/advertisements/sliders'] = 'admin/maintenance_advertisements_sliders';
$route['admin/maintenance/advertisements/featured/jobs'] = 'admin/maintenance_featured_jobs';
$route['admin/maintenance/advertisements/featured/jobs-by-location'] = 'admin/maintenance_featured_jobs_by_location';
$route['admin/maintenance/advertisements/featured/companies'] = 'admin/maintenance_featured_companies';



$route['jobs'] = 'home/jobs';
$route['jobs/search'] = 'home/jobs';
$route['jobs/details/(:any)/(:any)'] = 'home/company_job_post/$1/$1';
$route['companies/(:any)'] = 'home/company_profile/$1';
$route['applicants/(:any)'] = 'home/applicant_profile/$1';

$route['registration/job-seeker'] = 'registration/view_applicant_registration';
$route['registration/employer'] = 'registration/view_employer_registration';
$route['sign-up-with-facebook'] = 'Registration/social_applicant_registration';

$route['applicant/applications/pending'] = 'applicant/dashboard_pending';
$route['applicant/applications/for-interview'] = 'applicant/dashboard_interview';
$route['applicant/applications/withdrawn'] = 'applicant/dashboard_withdrawn';
$route['applicant/applications/reviewed'] = 'applicant/dashboard_reviewed';
$route['applicant/applications/declined'] = 'applicant/dashboard_declined';
$route['applicant/suggested-jobs'] = 'applicant/suggested_jobs';
$route['applicant/account/settings'] = 'applicant/account_settings';
$route['applicant/profile/edit/(:any)'] = 'applicant/update_profile/$1';
$route['applicant/profile'] = 'applicant/user_profile';
$route['applicant/profile/edit'] = 'applicant/user_profile_edit';
$route['applicant/resume'] = 'applicant/user_resume';
$route['applicant/recommended-jobs'] = 'applicant/recommended_jobs';


$route['company/applicants/dashboard'] = 'employer/view_applicants';
$route['candidates'] = 'employer/view_all_applicants';
$route['co/profile/settings'] = 'employer/account_company_settings';
$route['co/profile/edit'] = 'employer/profile_edit';
$route['co/jobs'] = 'employer/review_posted_jobs';
$route['employer/upload/profile'] = 'employer/upload_profile_image'; 
$route['co/job/create'] = 'employer/create_job_post';
$route['employer/job/edit/id/(:any)'] = 'employer/edit_job_post/$1';
$route['employer/jobs/(:any)'] = 'employer/get_job_post/$1';
// $route['company/(:any)/jobs/(:any)'] = 'employer/company_job_post/$1';


$route['api/companies/applicants/tag_as_reviewed'] = 'api/companies/tag_as_reviewed';
$route['api/companies/applicants/tag_for_interview'] = 'api/companies/tag_for_interview';
$route['api/companies/applicants/tag_as_reject'] = 'api/companies/tag_as_reject';

$route['api/admin/featured_jobs/activate'] = 'api/admin/featured_jobs_activate';
$route['api/admin/featured_jobs/deactivate'] = 'api/admin/featured_jobs_deactivate';

$route['api/admin/featured_jobs_by_location/activate'] = 'api/admin/featured_jobs_by_location_activate';
$route['api/admin/featured_jobs_by_location/deactivate'] = 'api/admin/featured_jobs_by_location_deactivate';

$route['api/admin/featured_companies/activate'] = 'api/admin/featured_companies_activate';
$route['api/admin/featured_companies/deactivate'] = 'api/admin/featured_companies_deactivate';

$route['api/admin/advertisement/activate'] = 'api/admin/advertisement_activate';
$route['api/admin/advertisement/deactivate'] = 'api/admin/advertisement_deactivate';

// REST API ROUTES
// $route['api/example/users/(:num)'] = 'api/example/users/id/$1';
