<?PHP
/*
Simfatic Forms Main Form processor script

This script does all the server side processing. 
(Displaying the form, processing form submissions,
displaying errors, making CAPTCHA image, and so on.) 

All pages (including the form page) are displayed using 
templates in the 'templ' sub folder. 

The overall structure is that of a list of modules. Depending on the 
arguments (POST/GET) passed to the script, the modules process in sequence. 

Please note that just appending  a header and footer to this script won't work.
To embed the form, use the 'Copy & Paste' code in the 'Take the Code' page. 
To extend the functionality, see 'Extension Modules' in the help.

*/

@ini_set("display_errors", 1);//the error handler is added later in FormProc
error_reporting(E_ALL & ~((defined('E_STRICT')?E_STRICT:0)|E_NOTICE));

require_once(dirname(__FILE__)."/includes/Boundary_Survey_Request-lib.php");
$formproc_obj =  new SFM_FormProcessor('Boundary_Survey_Request');
$formproc_obj->initTimeZone('UTC');
$formproc_obj->setFormID('43a2394e-106c-4feb-b915-1172a31d0ccb');
$formproc_obj->setFormKey('c083b2c2-e652-4c5e-ab31-45bef4dd234f');
$formproc_obj->setLocale('en-US','M/d/yyyy');
$formproc_obj->setEmailFormatHTML(false);
$formproc_obj->EnableLogging(false);
$formproc_obj->SetErrorEmail('bryan Official Email <bryan.o.cancel@gmail.com>');
$formproc_obj->SetDebugMode(false);
$formproc_obj->setIsInstalled(true);
$formproc_obj->SetPrintPreviewPage(sfm_readfile(dirname(__FILE__)."/templ/Boundary_Survey_Request_print_preview_file.txt"));
$formproc_obj->SetSingleBoxErrorDisplay(true);
$formproc_obj->setFormPage(0,sfm_readfile(dirname(__FILE__)."/templ/Boundary_Survey_Request_form_page_0.txt"));
$formproc_obj->AddElementInfo('Name','text','');
$formproc_obj->AddElementInfo('Email','text','');
$formproc_obj->AddElementInfo('Phone','text','');
$formproc_obj->AddElementInfo('NameOfTitleCompany','text','');
$formproc_obj->AddElementInfo('AddressOfTitleCompany','text','');
$formproc_obj->AddElementInfo('Address','text','');
$formproc_obj->AddElementInfo('City','text','');
$formproc_obj->AddElementInfo('ParcelID','text','');
$formproc_obj->AddElementInfo('AccessCode','text','');
$formproc_obj->AddElementInfo('LegalDescription','multiline','');
$formproc_obj->AddElementInfo('ListingAgent','text','');
$formproc_obj->AddElementInfo('DateNeeded','text','');
$formproc_obj->AddElementInfo('ClosingDate','text','');
$formproc_obj->AddElementInfo('NameOfBuyer','text','');
$formproc_obj->AddElementInfo('NameOfLender','text','');
$formproc_obj->AddElementInfo('NameOfTitleAtty','text','');
$formproc_obj->AddElementInfo('NameOfUnderWriter','text','');
$formproc_obj->AddElementInfo('AddExtras','listbox','');
$formproc_obj->AddElementInfo('Comments','multiline','');
$formproc_obj->AddElementInfo('FileUpload','file','');
$formproc_obj->AddDefaultValue('Name','*Your Name');
$formproc_obj->AddDefaultValue('Email','*Your Email');
$formproc_obj->AddDefaultValue('Phone','Your Phone #');
$formproc_obj->AddDefaultValue('NameOfTitleCompany','*Name of Title Company');
$formproc_obj->AddDefaultValue('AddressOfTitleCompany','*Address of Title Company');
$formproc_obj->AddDefaultValue('Address','*Address');
$formproc_obj->AddDefaultValue('City','*City | State | Zip');
$formproc_obj->AddDefaultValue('ParcelID','Parcel ID (required if house number is N/A)');
$formproc_obj->AddDefaultValue('AccessCode','Access Code For The Property');
$formproc_obj->AddDefaultValue('LegalDescription','LEGAL DESCRIPTION: Lot | Block | Plat/Map Book | Pages | Subdivision | etc.');
$formproc_obj->AddDefaultValue('ListingAgent','Listing Agent: "Contact Info."');
$formproc_obj->AddDefaultValue('DateNeeded','*Date Needed');
$formproc_obj->AddDefaultValue('ClosingDate','Closing Date');
$formproc_obj->AddDefaultValue('NameOfBuyer','Buyer(s)');
$formproc_obj->AddDefaultValue('NameOfLender','Lender');
$formproc_obj->AddDefaultValue('NameOfTitleAtty','Title Co./ Attorney');
$formproc_obj->AddDefaultValue('NameOfUnderWriter','Title Insurance/Underwriter');
$formproc_obj->setIsInstalled(true);
$formproc_obj->setFormFileFolder('./formdata');
$formproc_obj->DisableAntiSpammerSecurityChecks();
$formproc_obj->SetFromAddress('forms@lebrongroup.com');
$page_renderer =  new FM_FormPageDisplayModule();
$formproc_obj->addModule($page_renderer);

$upld =  new FM_FileUploadHandler();
$upld->SetFileUploadFields(array('FileUpload'));
$formproc_obj->addModule($upld);

$data_email_sender =  new FM_FormDataSender(sfm_readfile(dirname(__FILE__)."/templ/Boundary_Survey_Request_email_subj.txt"),sfm_readfile(dirname(__FILE__)."/templ/Boundary_Survey_Request_email_body.txt"),'%Email%');
$data_email_sender->AddToAddr('requests <request@lebrongroup.com>');
$data_email_sender->SetAttachFiles(true);
$formproc_obj->addModule($data_email_sender);

$tupage =  new FM_ThankYouPage();
$tupage->SetRedirURL('http://lebrongroup.com/thank-you.html');
$formproc_obj->addModule($tupage);

$thumbnail =  new FM_ThumbnailModule();
$formproc_obj->AddExtensionModule($thumbnail);
$data_email_sender->SetFileUploader($upld);
$page_renderer->SetFileUploader($upld);
$formproc_obj->ProcessForm();

?>