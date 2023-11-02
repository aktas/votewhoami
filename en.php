<?php 
//ini_set("display_errors",1);
require_once "functions/sessions.php";
require_once "functions/security.php";
require_once "functions/routing.php";
require_once "functions/cookies.php";
require_once "functions/character.php";
require_once "classes/allClasses.php";
require_once "functions/visitors.php";

if(isset($_GET['language']) && isset($_GET['i'])){
	if(ucfirst($_GET['language']) != "English"){
		go("index");
	}else{
		$i = trim(mb_strtolower(security($_GET['language']))."-".security($_GET['i']));
		$language = trim(ucfirst(security($_GET['language'])));
		$getGroups = new \votewhoami\groups\groups();
		$getGroup = $getGroups->getRow("SELECT * FROM groups WHERE groupLanguage = ? AND groupVLink = ?",array($language,$i));
		if($getGroup){
			define("VIEW",1); // 1 -> viewLink, 2 -> editLink
			$hideDiv = "1";
		}else{
			$getGroup = $getGroups->getRow("SELECT * FROM groups WHERE groupLanguage = ? AND groupELink = ?",array($language,$i));
			if($getGroup){
				define("VIEW",2);
				$hideDiv = "1";
			}
		}
	}
}

if(!isset($hideDiv)){
	$hideDiv = "0";
}

$first = "1";

$db = new \votewhoami\db\database();
$settings = $db->getRow("SELECT * FROM admin WHERE id = ?",array(1));

$getCharacters = getCharacter("EN");

$del = (defined("VIEW") && VIEW == 2) ? $getGroup->id : 0;
$seeAdd = (defined("VIEW") && VIEW == 1) ? $getGroup->id : 0;
if((defined("VIEW") && VIEW == 2) || (defined("VIEW") && VIEW == 1)){
	$link = $i;
}else{
	$link = 0;
} 

$token = md5(uniqid(mt_rand(), true));
setSession("token",$token);

$url = "en";

getVisitor();

$cookieC = getCookieControl();
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta name="title" content="<?php echo $settings->titleEn; ?>">
	<meta name="description" content="<?php echo $settings->descriptionEn; ?>">
	<meta name="keywords" content="<?php echo $settings->keywordsEn; ?>">
	<meta name="robots" content="index, nofollow">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="language" content="English">
	<meta name="google-site-verification" content="<?php echo $settings->googleSiteVerification; ?>" />
	<title>VOTE WHO AM I</title>
	<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
	<script src="https://kit.fontawesome.com/9907df2918.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="shortcut icon" type="image/png" href="img/favicon.ico"/>
	<script data-ad-client="ca-pub-7829383694822608" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
<body>
	
	<div class="header mb-3">
		<span class="language">
			<div class="dropdown">
	  			<span class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">EN</span>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
				  	<a class="dropdown-item" href="tr">TR</a>
				</div>
			</div>
		</span>
		<?php echo mb_strtoupper($settings->titleEn); ?>
		<span class="info" data-toggle="modal" data-target="#info"><i class="far fa-question-circle"></i></span>
	</div>
	<main class="container">
		<div class="row">
			<div class="col-md-12">
				<h3 class="mb-3">Search</h3>
				<select class="form-control selectpicker country" data-live-search="true">
					<option value="">Select Country</option>
					<option value="AF">Afghanistan</option>
					<option value="AX">Åland Islands</option>
					<option value="AL">Albania</option>
					<option value="DZ">Algeria</option>
					<option value="AS">American Samoa</option>
					<option value="AD">Andorra</option>
					<option value="AO">Angola</option>
					<option value="AI">Anguilla</option>
					<option value="AQ">Antarctica</option>
					<option value="AG">Antigua and Barbuda</option>
					<option value="AR">Argentina</option>
					<option value="AM">Armenia</option>
					<option value="AW">Aruba</option>
					<option value="AU">Australia</option>
					<option value="AT">Austria</option>
					<option value="AZ">Azerbaijan</option>
					<option value="BS">Bahamas</option>
					<option value="BH">Bahrain</option>
					<option value="BD">Bangladesh</option>
					<option value="BB">Barbados</option>
					<option value="BY">Belarus</option>
					<option value="BE">Belgium</option>
					<option value="BZ">Belize</option>
					<option value="BJ">Benin</option>
					<option value="BM">Bermuda</option>
					<option value="BT">Bhutan</option>
					<option value="BO">Bolivia, Plurinational State of</option>
					<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
					<option value="BA">Bosnia and Herzegovina</option>
					<option value="BW">Botswana</option>
					<option value="BV">Bouvet Island</option>
					<option value="BR">Brazil</option>
					<option value="IO">British Indian Ocean Territory</option>
					<option value="BN">Brunei Darussalam</option>
					<option value="BG">Bulgaria</option>
					<option value="BF">Burkina Faso</option>
					<option value="BI">Burundi</option>
					<option value="KH">Cambodia</option>
					<option value="CM">Cameroon</option>
					<option value="CA">Canada</option>
					<option value="CV">Cape Verde</option>
					<option value="KY">Cayman Islands</option>
					<option value="CF">Central African Republic</option>
					<option value="TD">Chad</option>
					<option value="CL">Chile</option>
					<option value="CN">China</option>
					<option value="CX">Christmas Island</option>
					<option value="CC">Cocos (Keeling) Islands</option>
					<option value="CO">Colombia</option>
					<option value="KM">Comoros</option>
					<option value="CG">Congo</option>
					<option value="CD">Congo, the Democratic Republic of the</option>
					<option value="CK">Cook Islands</option>
					<option value="CR">Costa Rica</option>
					<option value="CI">Côte d'Ivoire</option>
					<option value="HR">Croatia</option>
					<option value="CU">Cuba</option>
					<option value="CW">Curaçao</option>
					<option value="CY">Cyprus</option>
					<option value="CZ">Czech Republic</option>
					<option value="DK">Denmark</option>
					<option value="DJ">Djibouti</option>
					<option value="DM">Dominica</option>
					<option value="DO">Dominican Republic</option>
					<option value="EC">Ecuador</option>
					<option value="EG">Egypt</option>
					<option value="SV">El Salvador</option>
					<option value="GQ">Equatorial Guinea</option>
					<option value="ER">Eritrea</option>
					<option value="EE">Estonia</option>
					<option value="ET">Ethiopia</option>
					<option value="FK">Falkland Islands (Malvinas)</option>
					<option value="FO">Faroe Islands</option>
					<option value="FJ">Fiji</option>
					<option value="FI">Finland</option>
					<option value="FR">France</option>
					<option value="GF">French Guiana</option>
					<option value="PF">French Polynesia</option>
					<option value="TF">French Southern Territories</option>
					<option value="GA">Gabon</option>
					<option value="GM">Gambia</option>
					<option value="GE">Georgia</option>
					<option value="DE">Germany</option>
					<option value="GH">Ghana</option>
					<option value="GI">Gibraltar</option>
					<option value="GR">Greece</option>
					<option value="GL">Greenland</option>
					<option value="GD">Grenada</option>
					<option value="GP">Guadeloupe</option>
					<option value="GU">Guam</option>
					<option value="GT">Guatemala</option>
					<option value="GG">Guernsey</option>
					<option value="GN">Guinea</option>
					<option value="GW">Guinea-Bissau</option>
					<option value="GY">Guyana</option>
					<option value="HT">Haiti</option>
					<option value="HM">Heard Island and McDonald Islands</option>
					<option value="VA">Holy See (Vatican City State)</option>
					<option value="HN">Honduras</option>
					<option value="HK">Hong Kong</option>
					<option value="HU">Hungary</option>
					<option value="IS">Iceland</option>
					<option value="IN">India</option>
					<option value="ID">Indonesia</option>
					<option value="IR">Iran, Islamic Republic of</option>
					<option value="IQ">Iraq</option>
					<option value="IE">Ireland</option>
					<option value="IM">Isle of Man</option>
					<option value="IL">Israel</option>
					<option value="IT">Italy</option>
					<option value="JM">Jamaica</option>
					<option value="JP">Japan</option>
					<option value="JE">Jersey</option>
					<option value="JO">Jordan</option>
					<option value="KZ">Kazakhstan</option>
					<option value="KE">Kenya</option>
					<option value="KI">Kiribati</option>
					<option value="KP">Korea, Democratic People's Republic of</option>
					<option value="KR">Korea, Republic of</option>
					<option value="KW">Kuwait</option>
					<option value="KG">Kyrgyzstan</option>
					<option value="LA">Lao People's Democratic Republic</option>
					<option value="LV">Latvia</option>
					<option value="LB">Lebanon</option>
					<option value="LS">Lesotho</option>
					<option value="LR">Liberia</option>
					<option value="LY">Libya</option>
					<option value="LI">Liechtenstein</option>
					<option value="LT">Lithuania</option>
					<option value="LU">Luxembourg</option>
					<option value="MO">Macao</option>
					<option value="MK">Macedonia, the former Yugoslav Republic of</option>
					<option value="MG">Madagascar</option>
					<option value="MW">Malawi</option>
					<option value="MY">Malaysia</option>
					<option value="MV">Maldives</option>
					<option value="ML">Mali</option>
					<option value="MT">Malta</option>
					<option value="MH">Marshall Islands</option>
					<option value="MQ">Martinique</option>
					<option value="MR">Mauritania</option>
					<option value="MU">Mauritius</option>
					<option value="YT">Mayotte</option>
					<option value="MX">Mexico</option>
					<option value="FM">Micronesia, Federated States of</option>
					<option value="MD">Moldova, Republic of</option>
					<option value="MC">Monaco</option>
					<option value="MN">Mongolia</option>
					<option value="ME">Montenegro</option>
					<option value="MS">Montserrat</option>
					<option value="MA">Morocco</option>
					<option value="MZ">Mozambique</option>
					<option value="MM">Myanmar</option>
					<option value="NA">Namibia</option>
					<option value="NR">Nauru</option>
					<option value="NP">Nepal</option>
					<option value="NL">Netherlands</option>
					<option value="NC">New Caledonia</option>
					<option value="NZ">New Zealand</option>
					<option value="NI">Nicaragua</option>
					<option value="NE">Niger</option>
					<option value="NG">Nigeria</option>
					<option value="NU">Niue</option>
					<option value="NF">Norfolk Island</option>
					<option value="MP">Northern Mariana Islands</option>
					<option value="NO">Norway</option>
					<option value="OM">Oman</option>
					<option value="PK">Pakistan</option>
					<option value="PW">Palau</option>
					<option value="PS">Palestinian Territory, Occupied</option>
					<option value="PA">Panama</option>
					<option value="PG">Papua New Guinea</option>
					<option value="PY">Paraguay</option>
					<option value="PE">Peru</option>
					<option value="PH">Philippines</option>
					<option value="PN">Pitcairn</option>
					<option value="PL">Poland</option>
					<option value="PT">Portugal</option>
					<option value="PR">Puerto Rico</option>
					<option value="QA">Qatar</option>
					<option value="RE">Réunion</option>
					<option value="RO">Romania</option>
					<option value="RU">Russian Federation</option>
					<option value="RW">Rwanda</option>
					<option value="BL">Saint Barthélemy</option>
					<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
					<option value="KN">Saint Kitts and Nevis</option>
					<option value="LC">Saint Lucia</option>
					<option value="MF">Saint Martin (French part)</option>
					<option value="PM">Saint Pierre and Miquelon</option>
					<option value="VC">Saint Vincent and the Grenadines</option>
					<option value="WS">Samoa</option>
					<option value="SM">San Marino</option>
					<option value="ST">Sao Tome and Principe</option>
					<option value="SA">Saudi Arabia</option>
					<option value="SN">Senegal</option>
					<option value="RS">Serbia</option>
					<option value="SC">Seychelles</option>
					<option value="SL">Sierra Leone</option>
					<option value="SG">Singapore</option>
					<option value="SX">Sint Maarten (Dutch part)</option>
					<option value="SK">Slovakia</option>
					<option value="SI">Slovenia</option>
					<option value="SB">Solomon Islands</option>
					<option value="SO">Somalia</option>
					<option value="ZA">South Africa</option>
					<option value="GS">South Georgia and the South Sandwich Islands</option>
					<option value="SS">South Sudan</option>
					<option value="ES">Spain</option>
					<option value="LK">Sri Lanka</option>
					<option value="SD">Sudan</option>
					<option value="SR">Suriname</option>
					<option value="SJ">Svalbard and Jan Mayen</option>
					<option value="SZ">Swaziland</option>
					<option value="SE">Sweden</option>
					<option value="CH">Switzerland</option>
					<option value="SY">Syrian Arab Republic</option>
					<option value="TW">Taiwan, Province of China</option>
					<option value="TJ">Tajikistan</option>
					<option value="TZ">Tanzania, United Republic of</option>
					<option value="TH">Thailand</option>
					<option value="TL">Timor-Leste</option>
					<option value="TG">Togo</option>
					<option value="TK">Tokelau</option>
					<option value="TO">Tonga</option>
					<option value="TT">Trinidad and Tobago</option>
					<option value="TN">Tunisia</option>
					<option value="TR">Turkey</option>
					<option value="TM">Turkmenistan</option>
					<option value="TC">Turks and Caicos Islands</option>
					<option value="TV">Tuvalu</option>
					<option value="UG">Uganda</option>
					<option value="UA">Ukraine</option>
					<option value="AE">United Arab Emirates</option>
					<option value="GB">United Kingdom</option>
					<option value="US">United States</option>
					<option value="UM">United States Minor Outlying Islands</option>
					<option value="UY">Uruguay</option>
					<option value="UZ">Uzbekistan</option>
					<option value="VU">Vanuatu</option>
					<option value="VE">Venezuela, Bolivarian Republic of</option>
					<option value="VN">Viet Nam</option>
					<option value="VG">Virgin Islands, British</option>
					<option value="VI">Virgin Islands, U.S.</option>
					<option value="WF">Wallis and Futuna</option>
					<option value="EH">Western Sahara</option>
					<option value="YE">Yemen</option>
					<option value="ZM">Zambia</option>
					<option value="ZW">Zimbabwe</option>
				</select>
			</div>
		</div> <br>
		<div class="row">
			<div class="col-md-9">
				<select class="form-control selectpicker groups" data-live-search="true" hideDisabled="true" disabled="" >
					<option value="">Select Group</option>
				</select>
			</div>
			<div class="col-md-3 mb-5">
				<button class="btn btn-primary" id="addGroupButton" disabled="">Create group</button>
			</div>
			<div class="col-md-12" id="showDiv">
				<h3 class="mb-4" id="groupName"></h3>
				<table id="example" class="table table-striped dt-responsive nowrap" style="width:100%; ">
					<thead>
					    <tr>
					        <th>Name</th>
					        <th>Characters (Top 3)</th>
					        <th>Detail</th>
					    </tr>
					</thead>
					<tbody></tbody>
				</table> <br> <br>
				<?php if(defined("VIEW") && VIEW == 2){  ?> <br>
					<div class="groupInformation">
						<h3>Group Information</h3>
						<div class="row">
							<div class="col-md-12">
								<input type="text" class="form-control" id="groupNameChange" placeholder="Group Name" value="<?=$getGroup->groupName?>" name="">	
							</div>
							<div class="col-md-12">
								<div class="checkbox-area">
									<label> <input class="form-check-input" type="checkbox" id="checkbox" name="special"> Special</label>
								</div>
								<div class="checkbox-area">
									<label> <input class="form-check-input" type="checkbox" id="checkbox2" name="editable"> Editable</label>
								</div>
								<button id="updateButton" class="btn btn-primary">Update</button>
							</div>
						</div> <br>
						<p><b>View Link -></b> <a href="https://votewhoami.com/<?=$getGroup->groupVLink?>" class="viewLink" id="viewLink">https://votewhoami.com/<?=$getGroup->groupVLink ?></a><i title="Copy" class="far fa-copy copyButton" onclick='kopyala(".viewLink");'></i></p>
						<p><b>Edit Link -></b> <a href="https://votewhoami.com/<?=$getGroup->groupELink?>" class="editLink" id="editLink">https://votewhoami.com/<?=$getGroup->groupELink; ?></a><i title="Copy" class="far fa-copy copyButton" onclick='kopyala(".editLink");'></i></p> 
						<button id="updateLinksButton" class="btn btn-primary">Update Links</button> <br> <br>
						<p><i class="fas fa-info-circle"></i> Do not share the edit link with anyone</p>
						<p><i class="fas fa-info-circle"></i> Note that if you lose the links you will no longer be able to reach your group! So please save the links.</p>
					</div> <br>
				
					<div class="addGroupMember">
						<h4 style='text-align: left'>Add Group Member:</h4>
						<div class="row">
							<div class="col-md-10" >
								<input type="text" name="name" class="form-control" id="addMemberName" placeholder="Member Name"></div>
							<div class="col-md-2">
								<button id="addMemberCharacterButton" class="btn btn-primary">Add</button>
							</div>
						</div>
						<?php $x = 0; foreach($getCharacters as $value){ echo "<div id='addMemberCharacter$x' onclick='addMemberCharacter(\"$value\",$x)' >$value</div>"; $x++; } ?>
					</div> <br>
					<div class="deleteGroupDiv">
						<button class="btn btn-danger deleteGroup">Delete Group</button> <br>
					</div>
					
					<script type="text/javascript">
						let groupSpecial = "<?php echo $getGroup->groupSpecial ?>";
						let groupEditable = "<?php echo $getGroup->groupEditable ?>";
						if(groupSpecial == "on"){
							document.getElementById("checkbox").checked = true;
						}if(groupEditable == "on"){
							document.getElementById("checkbox2").checked = true;
						}
					</script>
				<?php } ?>
				<div class="addGroupMemberForVisitor">
					<h4 style='text-align: left'>Add Group Member:</h4>
					<div class="row">
						<div class="col-md-10" >
							<input type="text" name="name" class="form-control" id="addMemberName" placeholder="Member Name"></div>
						<div class="col-md-2">
							<button id="addMemberCharacterButtonForVisitor" class="btn btn-primary">Add</button>
						</div>
					</div>
					<?php $x = 0; foreach($getCharacters as $value){ echo "<div id='addMemberCharacterForVisitor$x' onclick='addMemberCharacterForVisitor(\"$value\",$x)' >$value</div>"; $x++; } ?>
				</div>
			</div>
			<div class="col-md-12" id="showDiv2">
				<div class="addGroup">
					<h3>Create Group</h3>
					<div class="row">
						<div class="col-md-12">
							<input type="text" class="form-control" placeholder="Group Name" name="">	
						</div>
						<div class="col-md-12">
							<div class="checkbox-area">
								<label> <input class="form-check-input" type="checkbox" id="getCheckbox" name="getSpecial"> Special</label>
							</div>
							<div class="checkbox-area">
								<label> <input class="form-check-input" type="checkbox" id="getCheckbox2" name="getEditable"> Editable</label>
							</div>
							<button id="createGroup" class="btn btn-primary">Create</button>
							<p><i class="fas fa-info-circle"></i> If you make your group special, only those who log in with the link can view it. The group cannot be reached by searching through the form. After creating a group, you will be given the link of your group.</p>
							<p><i class="fas fa-info-circle"></i> If you make your group editable, those who view your group with a link can add group members to your group.</p>
							<p><i class="fas fa-info-circle"></i> Note that after you add your group, you will be given an edit link only for you.</p><br>
						</div>
					</div> <br>

				</div>
			</div>
		</div>
		<?php if($cookieC){ ?>
		<div class="cookie">
			Cookies are used to make the most of our site. You are considered to have accepted the use of cookies by logging in to this site.
			<a href="https://automattic.com/cookies/">For more information</a>
			<span onclick="okCookie()"><i class="fas fa-times"></i></span>
		</div>
		<?php } ?>
	</main>

	<!-- Modal Start -->
	<div class="modal fade bd-example-modal-lg" id="characterModal" tabindex="-1" role="dialog" aria-labelledby="characterModalTitle" aria-hidden="true">
	  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body" id="exampleModalBody">
	      	<div>Character Adjectives</div>
	      	<div class="addCharacters"></div>
	      </div>
	    </div>
	  </div>
	</div>
	<div class="modal fade bd-example-modal-lg" id="info" tabindex="-1" role="dialog" aria-labelledby="infoTitle" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="infoTitle" >VOTE WHO AM I</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body"> 
	      	<h3>Who Are We?</h3>
	      	<p>A free online voting platform. You can create your own group, add group members, vote and track results without any restrictions.</p> <br>
	      	<h3>Contact Us</h3> <br>
	      	<p> It may take a long time for us to answer. Maybe we never answer. But be sure to read it. If you want to reach Admin, you can contact us at votewhoami@gmail.com. Please send your suggestions and requests via the form below. </p>
	      	<form action="process.php" method="POST" class="needs-validation" novalidate>
			  <div class="form-row">
			    <div class="col-md-6 mb-3">
			      <label for="validationCustom01">Name</label>
			      <input type="text" class="form-control" name="name" id="validationCustom01" placeholder="Name" required>
			      <div class="valid-feedback">
			        Looks good!
			      </div>
			    </div>
			    <div class="col-md-6 mb-3">
			      <label for="validationCustom02">Email</label>
			      <input type="email" class="form-control" name="email" id="validationCustom02" placeholder="Email" required>
			      <div class="valid-feedback">
			        Looks good!
			      </div>
			    </div>
			    <div class="col-md-12 mb-3">
			      <label for="validationCustom03">Message</label>
			      <textarea class="form-control" name="message" id="validationCustom03" placeholder="Message" required=""></textarea>
			      <div class="valid-feedback">
			        Looks good!
			      </div>
			    </div>
			  </div>
			  <input type="hidden" name="token" value="<?=$token?>">
			  <input type="hidden" name="url" value="<?=$url?>">
			  <button class="btn btn-primary" name="sendMessage" type="submit">Send</button>
			</form> <br> <br> <br>
			<div style="position: absolute; right: 5px; bottom: 5px; font-family:Montserrat">© All rights reserved</div>
			<script>
			// Example starter JavaScript for disabling form submissions if there are invalid fields
			(function() {
			  'use strict';
			  window.addEventListener('load', function() {
			    // Fetch all the forms we want to apply custom Bootstrap validation styles to
			    var forms = document.getElementsByClassName('needs-validation');
			    // Loop over them and prevent submission
			    var validation = Array.prototype.filter.call(forms, function(form) {
			      form.addEventListener('submit', function(event) {
			        if (form.checkValidity() === false) {
			          event.preventDefault();
			          event.stopPropagation();
			        }
			        form.classList.add('was-validated');
			      }, false);
			    });
			  }, false);
			})();
			</script>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- Modal Finish -->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
	<!-- DATATABLE START -->
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    		$('#example').DataTable();
    	} );
	</script>
    <!-- DATATABLE END -->
    <?php if(isset($_GET['statu']) && ($_GET['statu'] == "ok")){ ?>
		<script type="text/javascript">
			toastr["success"]("The message has been successfully sent!!");
		</script>
	<?php }if(isset($_GET['statu']) && ($_GET['statu'] == "no")){ ?>
		<script type="text/javascript">
			toastr["warning"]("There is a problem! Please try again.");
		</script>
	<?php }if(isset($_GET['statu']) && ($_GET['statu'] == "nope")){ ?>
		<script type="text/javascript">
			toastr["warning"]("Spam message was detected.");
		</script>
	<?php } ?>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript">
		var hideDiv = "<?php echo $hideDiv; ?>";
		var first = "<?php echo $first; ?>";
		$(".country").change(function(){
		    var country = $(".country option:selected").val();
		    var token = $("input[name=token]").val();
		    let link = "<?php echo $link; ?>";
		    if(country == ""){
		    	$('.groups').prop('disabled', true);
				$('.groups').selectpicker('refresh');
				$("#addGroupButton").prop("disabled",true);
		    }else{
		    	$.ajax({
					type: 'POST',
					url: 'searchGroups.php',
					data: 'searchGroups=ok&token='+token+"&country="+country+"&link="+link,
					beforeSend: function(){
						$("#addGroupButton").html('<i class="fas fa-circle-notch"></i> Loading');

						$('.groups').prop('disabled', true);
						$('.groups').selectpicker('refresh');
					},success: function(result){
						$("#addGroupButton").html("Create group");
						if(result == 1){
							if($("#showDiv").css("display") != 'none'){
								$("#showDiv").toggle("fast");
							}
							toastr["warning"]("There is a problem! Please try again.");
							$('.groups').prop('disabled', true);
							$('.groups').selectpicker('refresh');
							$("#addGroupButton").prop("disabled",true);
						}else if(result == 2){
							if($("#showDiv").css("display") != 'none'){
								$("#showDiv").toggle("fast");
							}
							$('.groups').find('option').remove();
							toastr["warning"]("No results found. Create your own group.");
							$('.groups').prop('disabled', true);
							$('.groups').selectpicker('refresh');
							$("#addGroupButton").prop("disabled",false);
						}else{
							$('.groups').find('option').remove();
							$('.groups').selectpicker('refresh');
							var array = result.split("---");
							$("#addGroupButton").prop("disabled",false);
							$('.groups').prop('disabled', false);
							
							array.forEach(function(item,index){
								if(!(item == "")){
									$('.groups').append(item);
								}
							});
							
							$('.groups').selectpicker('refresh');
							$(".groups ~ option").css("display","none");
							$('.groups').find('option').first().val();
							$('.groups').selectpicker('render');
							$('.groups').selectpicker('refresh');
						}
						
					}
				})
		    }
			
		});

		$(".groups").change(function(){
		    let group = $(".groups option:selected").attr('val');
		    let groupName = $(".groups option:selected").val();
		    let country = $(".country option:selected").val();
		    let token = $("input[name=token]").val();
		    if(group == ""){

		    }else{
		    	$.ajax({
					type: 'POST',
					url: 'searchGroups.php',
					data: 'group='+group+'&searchGroup=ok&token='+token+"&country="+country+"&lan=English",
					beforeSend: function(){
						$("#addGroupButton").html('<i class="fas fa-circle-notch"></i> Loading');
						$("#addGroupButton").prop("disabled",true);
						$('.groups').prop('disabled', true);
						$('.groups').selectpicker('refresh');
					},success: function(result){
						if(result == 1){
							if($("#showDiv").css("display") != 'none'){
								$("#showDiv").toggle("fast");
							}
							toastr["warning"]("There is a problem! Please try again."); 
						}else if(result == 2){
							if($("#showDiv").css("display") != 'none'){
								$("#showDiv").toggle("fast");
							}
							toastr["warning"]("No results found. Create your own group.");
						}else{
							let del = "<?php echo $del; ?>"; // VIEW 2 --> Kontrolü a
							let seeAdd = "<?php echo $seeAdd; ?>";
							let t = $('#example').DataTable(); 
							t.clear().draw();
							$("#groupName").text(groupName);
							let arr = result.trim().split("-----");
							
							let num = arr.length;
							arr.splice(num - 1); 
							let p = 0;
							arr.forEach(function(n){
								let arr2 = n.trim().split("---");
								var c = arr2[1].split(",");
								var c = listArray(c);
								if((c.length) > 3){
									let arr3 = arr2[1].trim().split(",");
									var rowCharacters = toFirstUpper(arr3[0])+","+toFirstUpper(arr3[1])+","+toFirstUpper(arr3[2]);
								}else{
									var rowCharacters = toFirstUpper(arr2[1]);
								}
								let add = "Modal("+arr2[2]+",\""+arr2[0]+"\")"; 
								if(seeAdd == group){
									$(".addGroupMemberForVisitor").css("display","block");
								}else{
									$(".addGroupMemberForVisitor").css("display","none");
								}
								if(del == group){
									let link = "<?php echo $link; ?>";
									var button = "<button data-toggle='modal' style='margin-right:5px' data-target='#characterModal' onclick='"+add+"' class='btn btn-primary'>View</button><button id='deleteButton"+p+"' onclick='deleteRow("+p+","+group+",\""+link+"\",\""+token+"\","+arr2[2]+")' class='btn btn-danger'>Delete</button>";
									$(".groupInformation").css("display","block");
									$(".addGroupMember").css("display","block");
								}else{
									var button = "<button data-toggle='modal' data-target='#characterModal' onclick='"+add+"' class='btn btn-primary'>View</button>";
									$(".groupInformation").css("display","none");
									$(".addGroupMember").css("display","none");
								} p++; 
								t.row.add( [arr2[0],rowCharacters,button] ).draw( false );
							});
							
							$("#showDiv").css("display","block");

							if((hideDiv == "1") && (first == "0")){
								if($(".addGroupMember").css("display") == "block"){
									$(".addGroupMember").toggle();
								}
								if($(".addGroupMemberForVisitor").css("display") == "block"){
									$(".addGroupMemberForVisitor").toggle();
								}
								if($(".groupInformation").css("display") == "block"){
									$(".groupInformation").toggle();
								}
								if($(".deleteGroupDiv").css("display") == "block"){
									$(".deleteGroupDiv").toggle();
								}
								hideDiv = 0;
							}

							if(first == "1"){
								first = "0";
							}
						}
						$("#addGroupButton").html("Create group");
						$("#addGroupButton").prop("disabled",false);
						$('.groups').prop('disabled', false);
						$('.groups').selectpicker('render');
						$('.groups').selectpicker('refresh');

						
					}
				});

		    }
			
		}); 

		function Modal(id,name){ 
			let token = $("input[name=token]").val();
			$.ajax({
				type: 'POST',
				url: 'process.php',
				data: 'getActiveCharacters=ok&token='+token+'&id='+id+'&language=English',
				success: function(r){
					if(r == 1){
						var obj3 = ["aas"];
					}else{
						var obj3 = $.parseJSON(r).split(",");
					} 
					$.ajax({
						type: 'POST',
						url: 'process.php',
						data: 'getCharacterAdjectives=ok&language=EN&token='+token,
						success: function(result){ 
							obj = $.parseJSON(result);
							$.ajax({
								type: 'POST',
								url: 'process.php',
								data: 'getGroupMemberDetail=ok&language=English&id='+id+'&token='+token,
								success: function(result){
									if(result == 0){
										toastr["warning"]("There is a problem! Please try again.");
									}else{ 
										obj2 = $.parseJSON(result);
										let string = "";
										let x = 0;
										let i = 0;
										$("#exampleModalLongTitle").text(name); 
										Object.keys(obj).forEach(key => { 
											Object.keys(obj2).forEach(key2 => {
												if(key.toLowerCase().trim() == key2.toLowerCase().trim()){
													string = string + "<div class='"+key+"' onclick='Vote("+i+","+id+",\""+key+"\")' id='memberCharacter"+i+"'>"+toFirstUpper(key) +" <span class='badge badge-info'>"+obj2[key2]+"</span></div>";
													x = 1;
												}
											});
											if(x == 0){
												string = string + "<div class='"+key+"' onclick='Vote("+i+","+id+",\""+key+"\")' id='memberCharacter"+i+"'>"+toFirstUpper(key) +" <span class='badge badge-info'>0</span></div>";
											}else{
												x = 0;
											}
											i++;
										  //console.log(key, obj2[key]);
										});
										$(".addCharacters").html(string);
										obj3.forEach(function(r){
											$(".addCharacters ."+r.toLowerCase().trim()).attr("class","voteActive");
										});

									}
								}
							});
						}
					});
				}
			});
			
		}

		function Vote(num,id,character){
			let token = $("input[name=token]").val();
			$.ajax({
				type: 'POST',
				url: 'process.php',
				data: 'vote=ok&token='+token+'&id='+id+'&character='+character,
				success: function(result){
					if(result == 0){
						toastr["warning"]("There is a problem! Please try again."); 
					}else if(result == 1){
						toastr["warning"]("You can vote up to 3 for a group member."); 
					}else{
						var sound = new Audio('sounds/select.wav');
						sound.play();
						if($("#memberCharacter"+num).attr("class") == "voteActive"){
							$("#memberCharacter"+num).attr("class",character.trim());
							$("#memberCharacter"+num+" span").html(Number($("#memberCharacter"+num+" span").text()) - 1);
						}else{
							$("#memberCharacter"+num).attr("class","voteActive");
							$("#memberCharacter"+num+" span").html(Number($("#memberCharacter"+num+" span").text()) + 1);
						}
					}
				},
				error: function(){
					toastr["warning"]("There is a problem! Please try again."); 
				}
			})
		}

		$("#addGroupButton").click(function(){ // showDiv ve showDiv2 aç kapat kontrol
			if(($(".groups option:selected").attr('val') == "") || ($(".groups option:selected").attr('val')  == undefined)){
				if($("#showDiv").css("display") != "none"){
					$("#showDiv").toggle("slow");
				}
				$("#showDiv2").toggle("fast");
				if($("#showDiv2").css("display") == "none"){
					$("#addGroupButton").html('<i class="fas fa-times"></i>');
				}else{
					$("#addGroupButton").text("Create group");
				}
			}else{
				if($("#showDiv").css("display") == "none"){
					$("#showDiv").toggle("slow");
					$("#showDiv2").toggle("fast");
					$("#addGroupButton").text("Create group");
				}else{
					$("#showDiv").toggle("fast");
					$("#showDiv2").toggle("slow");
					$("#addGroupButton").html('<i class="fas fa-times"></i>');
				}
			}
		});

		$("#createGroup").click(function(){
			let groupName = ($(".addGroup input[type=text]").val()).trim();
			if((groupName == null) || (groupName == undefined) || (groupName == "")){
				toastr["warning"]("Please enter the group name."); 
			}else{
				let country = $(".country option:selected").val();
				if((country == null) || (country == undefined) || (country == "")){
					toastr["warning"]("There is a problem! Please try again."); 
				}else{
					let special = (document.getElementById("getCheckbox").checked).toString();
					let editable = (document.getElementById("getCheckbox2").checked).toString();
					let token = "<?php echo $token; ?>";
					$.ajax({
						type: 'POST',
						url: 'process.php',
						data: 'createGroup=ok&groupName='+groupName+'&special='+special+'&editable='+editable+'&language=English&token='+token+'&country='+country,
						success: function(result){
							if(result == 0){
								toastr["warning"]("There is a problem! Please try again."); 
							}else if(result == "nameProblem"){
								toastr["warning"]("This group name has already been used!"); 
							}else if(result == 1){
								toastr["warning"]("The group name must be between 2 and 105 characters."); 
							}else if(result == 2){
								toastr["warning"]("The group creation process has been limited!");
							}else{
								let loc = "https://votewhoami.com/"+result;
								window.location.assign(loc);
							}
						}
					});
				}
			}
		});

		
	</script>
	<?php if(defined("VIEW") && VIEW == 1){  ?>
		<script type="text/javascript">
			$(document).ready(function(){
				let country = "<?php echo $getGroup->groupCountry; ?>";
				let groupId = "<?php echo $getGroup->id; ?>";
				let groupName = "<?php echo $getGroup->groupName; ?>"
				$(".country option[value="+country+"]").attr("selected","selected").change();
				setTimeout(function(){
					$('.groups').selectpicker('val',groupName).change();
					$('.groups').selectpicker('refresh');
					//$(".groups option[value="+groupId+"]:selected").change();
				},1000)
			});
		</script>
	<?php }  ?>
	<?php if((defined("VIEW") && VIEW == 1) && (isset($getGroup) && $getGroup->groupEditable == "on")){ ?>
		<script type="text/javascript">
			$(".addGroupMemberForVisitor").css("display","block");
			let memberCharacterArr = [];
			var clearArr = new Array(); 
			let groupName = "<?php echo $getGroup->groupName; ?>";
			function addMemberCharacterForVisitor(val,num){
				if(memberCharacterArr.indexOf(val) != -1){
					var sound = new Audio('sounds/select.wav');
					sound.play();
					let x = memberCharacterArr.indexOf(val);
					memberCharacterArr.splice(x,1);
					let y = clearArr.indexOf(num.toString());
					clearArr.splice(y,1);
					$("#addMemberCharacterForVisitor"+num).attr("class","");
				}else{
					if(memberCharacterArr.length >= 3){
						toastr["warning"]("You can vote up to 3 for a group member."); 
					}else{
						var sound = new Audio('sounds/select.wav');
						sound.play();
						memberCharacterArr.push(val);
						clearArr.push(num.toString());
						$("#addMemberCharacterForVisitor"+num).attr("class","voteActive");			
					}
				}
			}

			$(document).ready(function(){
				$("#addMemberCharacterButtonForVisitor").click(function(){
					if(memberCharacterArr.length == 0){
						toastr["warning"]("You must vote at least 1.");
					}else{
						if(memberCharacterArr.length > 3){
							toastr["warning"]("You can vote up to 3 for a group member."); 
						}else{
							let memberName = $("#addMemberName").val();
							if(!isNaN(memberName.trim())){ // Boş ise Please enter member name
								toastr["warning"]("Please enter member name."); 
							}else{
								var characters = "";
								memberCharacterArr.forEach(function(e){
									characters = characters + e + ", ";
								});
								var characters = characters.replace(/, +$/g,"");
								let link = "<?php echo $getGroup->groupVLink; ?>";
								let groupId = "<?php echo $getGroup->id; ?>";
								let token = "<?php echo $token; ?>";
								$.ajax({
									type: 'POST',
									url: 'process.php',
									data: 'addGroupMemberForVisitor=ok&memberName='+memberName+"&characters="+characters+"&link="+link+"&groupId="+groupId+"&token="+token,
									success: function(result){
										if(result == 0){
											toastr["warning"]("There is a problem! Please try again."); 
										}else if(result == "nameProblem"){
											toastr["warning"]("This member name has already been used!"); 
										}else if(result == "cookieProblem"){
											toastr["warning"]("Adding group members has been limited."); 
										}else if(result == "nameLimitProblem"){
											toastr["warning"]("Member name cannot exceed 35 characters!");
										}else{
											let t = $('#example').DataTable();
											let id = result;
											let add = 'Modal('+id+',"'+memberName+'")';
											let button = "<button data-toggle='modal' style='margin-right:5px' onclick='"+add+"' data-target='#characterModal' class='btn btn-primary'>View</button>";
											t.row.add( [memberName,characters,button] ).draw( false );
											toastr["success"]("Group member successfully added. You can check it from the table.");
											$("#addMemberName").val("");
											clearArr.forEach(function(a){
												let s = "#addMemberCharacterForVisitor"+a;
												$(s).attr("class","");
											});
											clearArr = [];
											memberCharacterArr = [];
										}
									}
								});
							}
						}
					}
				});
			});

		</script>
	<?php } ?>
	<?php if(defined("VIEW") && VIEW == 2){ ?>
		<script type="text/javascript">
			let memberCharacterArr = [];
			var clearArr = new Array(); // Üye eklendiğinde tıklamayı iptal eder.
			function addMemberCharacter(val,num){
				if(memberCharacterArr.indexOf(val) != -1){
					var sound = new Audio('sounds/select.wav');
					sound.play();
					let x = memberCharacterArr.indexOf(val);
					memberCharacterArr.splice(x,1);
					let y = clearArr.indexOf(num.toString());
					clearArr.splice(y,1);
					$("#addMemberCharacter"+num).attr("class","");
				}else{
					if(memberCharacterArr.length >= 3){
						toastr["warning"]("You can vote up to 3 for a group member."); 
					}else{
						var sound = new Audio('sounds/select.wav');
						sound.play();
						memberCharacterArr.push(val);
						clearArr.push(num.toString());
						$("#addMemberCharacter"+num).attr("class","voteActive");	
					}
				}
			}

			function deleteRow(num,groupId,link,token,id){ 
				$.ajax({
					type: 'POST',
					url: 'process.php',
					data: 'deleteRow=ok&groupId='+groupId+'&link='+link+'&token='+token+'&id='+id,
					success: function(result){
						if(result == 0){
							toastr["warning"]("There is a problem! Please try again."); 
						}else{
							toastr["success"]("Transaction successful.");
							let t = $('#example').DataTable();
							t.row($("#deleteButton"+num).parents('tr')).remove().draw();
						}
					}
				});
			}

			$(document).ready(function(){
				var deleteNum = 9999;
				let country = "<?php echo $getGroup->groupCountry; ?>";
				let groupId = "<?php echo $getGroup->id; ?>";
				let groupName = "<?php echo $getGroup->groupName; ?>";
				$(".country option[value="+country+"]").attr("selected","selected").change();
				setTimeout(function(){
					$('.groups').selectpicker('val',groupName).change();
					$('.groups').selectpicker('refresh');
					//$(".groups option[value="+groupId+"]:selected").change();
				},1000);

				$("#updateButton").click(function(){
					let groupName = $("#groupNameChange").val();
					if(groupName.length < 2){
						toastr["warning"]("Please enter the group name."); 
					}else{
						let special = (document.getElementById("checkbox").checked).toString();
						let editable = (document.getElementById("checkbox2").checked).toString();
						let token = "<?php echo $token; ?>";
						let link = "<?php echo $link; ?>";
						let id = "<?php echo $getGroup->id; ?>";
						$.ajax({
							type: "POST",
							url: "process.php",
							data: "updateGroup=ok&groupName="+groupName+"&special="+special+"&editable="+editable+"&token="+token+"&id="+id+"&link="+link,
							success: function(result){
								if(result == 0){
									toastr["warning"]("There is a problem! Please try again."); 
								}else if(result == "nameProblem"){
									toastr["warning"]("This group name has already been used!"); 
								}else if(result == 1){
									toastr["warning"]("Please enter the group name."); 
								}else if(result == 2){
									toastr["info"]("You need to change the group settings for the update process."); 
								}else{
									toastr["success"]("Transaction successful."); 
								}
							}
						});
					}
				});

				$("#updateLinksButton").click(function(){
					let link = "<?php echo $getGroup->groupELink; ?>";
					let id = "<?php echo $getGroup->id; ?>";
					let token = "<?php echo $token; ?>";
					$.ajax({
						type: 'POST',
						url: 'process.php',
						data: 'updateLinks=ok&link='+link+"&id="+id+"&token="+token,
						success: function(result){
							if(result == 0){
								toastr["warning"]("There is a problem! Please try again."); 
							}else{
								let loc = "https://votewhoami.com/"+result;
								window.location.assign(loc);
							}
						}
					});
				});

				$("#addMemberCharacterButton").click(function(){
					if(memberCharacterArr.length == 0){
						toastr["warning"]("You must vote at least 1.");
					}else{
						if(memberCharacterArr.length > 3){
							toastr["warning"]("You can vote up to 3 for a group member."); 
						}else{
							let memberName = $("#addMemberName").val();
							if(!isNaN(memberName.trim())){ // Boş ise Please enter member name
								toastr["warning"]("Please enter member name."); 
							}else{
								var characters = "";
								memberCharacterArr.forEach(function(e){
									characters = characters + e + ", ";
								});
								var characters = characters.replace(/, +$/g,"");
								let link = "<?php echo $getGroup->groupELink; ?>";
								let groupId = "<?php echo $getGroup->id; ?>";
								let token = "<?php echo $token; ?>";
								$.ajax({
									type: 'POST',
									url: 'process.php',
									data: 'addGroupMember=ok&memberName='+memberName+"&characters="+characters+"&link="+link+"&groupId="+groupId+"&token="+token+"&language=English",
									success: function(result){
										if(result == 0){
											toastr["warning"]("There is a problem! Please try again."); 
										}else if(result == "nameProblem"){
											toastr["warning"]("This member name has already been used!"); 
										}else if(result == "cookieProblem"){
											toastr["warning"]("Adding group members has been limited."); 
										}else if(result == "nameLimitProblem"){
											toastr["warning"]("Member name cannot exceed 35 characters!");
										}else{
											let t = $('#example').DataTable();
											let id = result;
											let add = 'Modal('+id+',"'+memberName+'")';
											let button = "<button data-toggle='modal' style='margin-right:5px' onclick='"+add+"' data-target='#characterModal' class='btn btn-primary'>View</button><button id='deleteButton"+deleteNum+"' onclick='deleteRow("+deleteNum+","+groupId+",\""+link+"\",\""+token+"\","+id+")' class='btn btn-danger'>Delete</button>";
											t.row.add( [memberName,characters,button] ).draw( false );
											toastr["success"]("Group member successfully added. You can check it from the table.");
											deleteNum++; 
											$("#addMemberName").val("");
											clearArr.forEach(function(a){
												let s = "#addMemberCharacter"+a;
												$(s).attr("class","");
											});
											clearArr = [];
											memberCharacterArr = [];
										}
									}
								});
							}
						}
					}
				});

				$(".deleteGroup").click(function(){
					let link = "<?php echo $getGroup->groupELink; ?>";
					let groupId = "<?php echo $getGroup->id; ?>";
					let token = "<?php echo $token; ?>";
					$.ajax({
						type: 'POST',
						url: 'process.php',
						data: 'deleteGroup=ok&link='+link+'&groupId='+groupId+'&token='+token,
						success: function(result){
							if(result == 0){
								toastr["warning"]("There is a problem! Please try again."); 
							}else{
								toastr["success"]("Transaction successful."); 
								setTimeout(function(){ window.location.assign("https://votewhoami.com"); },1000);
							}
						}

					});
				});

			});
		</script>
	<?php } ?>
</body>
</html>