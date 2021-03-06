<?php
function remove_href_from_a($text)
{
    $pattern = "/(?<=href=(\"|'))[^\"']+(?=(\"|'))/";
    $replace_with = '#linkremoved';
    return preg_replace($pattern, $replace_with, $text);
}

function get_country_array()
{
    $countries = [
        "Aland islands (AX)" => "Aland islands (AX)",
        "Albania (AL)" => "Albania (AL)",
        "Andorra (AD)" => "Andorra (AD)",
        "Angola (AO)" => "Angola (AO)",
        "Anguilla (AI)" => "Anguilla (AI)",
        "Antigua and Barbuda (AG)" => "Antigua and Barbuda (AG)",
        "Argentina (AR)" => "Argentina (AR)",
        "Armenia (AM)" => "Armenia (AM)",
        "Australia (AU)" => "Australia (AU)",
        "Austria (AT)" => "Austria (AT)",
        "Azerbaijan (AZ)" => "Azerbaijan (AZ)",
        "Bahamas (BS)" => "Bahamas (BS)",
        "Bahrain (BH)" => "Bahrain (BH)",
        "Bangladesh (BD)" => "Bangladesh (BD)",
        "Barbados (BB)" => "Barbados (BB)",
        "Belarus (BY)" => "Belarus (BY)",
        "Belgium (BE)" => "Belgium (BE)",
        "Bolivia (BO)" => "Bolivia (BO)",
        "Bosnia and Herzegovina (BA)" => "Bosnia and Herzegovina (BA)",
        "Brazil (BR)" => "Brazil (BR)",
        "Brunei Darussalam (BN)" => "Brunei Darussalam (BN)",
        "Bulgaria (BG)" => "Bulgaria (BG)",
        "Burkina Faso (BF)" => "Burkina Faso (BF)",
        "Cambodia (KH)" => "Cambodia (KH)",
        "Cameroon (CM)" => "Cameroon (CM)",
        "Canada (CA)" => "Canada (CA)",
        "Canary Islands (IC)" => "Canary Islands (IC)",
        "Cayman Islands (KY)" => "Cayman Islands (KY)",
        "Chile (CL)" => "Chile (CL)",
        "China (CN)" => "China (CN)",
        "Colombia (CO)" => "Colombia (CO)",
        "Costa Rica (CR)" => "Costa Rica (CR)",
        "Cote D'ivoire (CI)" => "Cote D'ivoire (CI)",
        "Croatia (HR)" => "Croatia (HR)",
        "Cuba (CU)" => "Cuba (CU)",
        "Cyprus (CY)" => "Cyprus (CY)",
        "Czech Republic (CZ)" => "Czech Republic (CZ)",
        "Denmark (DK)" => "Denmark (DK)",
        "Dominica (DM)" => "Dominica (DM)",
        "Dominican Republic (DO)" => "Dominican Republic (DO)",
        "Ecuador (EC)" => "Ecuador (EC)",
        "Egypt (EG)" => "Egypt (EG)",
        "El Salvador (SV)" => "El Salvador (SV)",
        "Estonia (EE)" => "Estonia (EE)",
        "Faroe Islands (FO)" => "Faroe Islands (FO)",
        "Finland (FI)" => "Finland (FI)",
        "France (FR)" => "France (FR)",
        "French Guiana (GF)" => "French Guiana (GF)",
        "French Polynesia (PF)" => "French Polynesia (PF)",
        "Gabon (GA)" => "Gabon (GA)",
        "Georgia (GE)" => "Georgia (GE)",
        "Germany (DE)" => "Germany (DE)",
        "Ghana (GH)" => "Ghana (GH)",
        "Gibraltar (GI)" => "Gibraltar (GI)",
        "Greece (GR)" => "Greece (GR)",
        "Greenland (GL)" => "Greenland (GL)",
        "Guadeloupe (GP)" => "Guadeloupe (GP)",
        "Guatemala (GT)" => "Guatemala (GT)",
        "Guernsey (GG)" => "Guernsey (GG)",
        "Honduras (HN)" => "Honduras (HN)",
        "Hong Kong (HK)" => "Hong Kong (HK)",
        "Hungary (HU)" => "Hungary (HU)",
        "Iceland (IS)" => "Iceland (IS)",
        "India (IN)" => "India (IN)",
        "Indonesia (ID)" => "Indonesia (ID)",
        "Ireland (IE)" => "Ireland (IE)",
        "Isle of Man (IM)" => "Isle of Man (IM)",
        "Israel (IL)" => "Israel (IL)",
        "Italy (IT)" => "Italy (IT)",
        "Jamaica (JM)" => "Jamaica (JM)",
        "Japan (JP)" => "Japan (JP)",
        "Jersey (JE)" => "Jersey (JE)",
        "Jordan (JO)" => "Jordan (JO)",
        "Kazakhstan (KZ)" => "Kazakhstan (KZ)",
        "Kenya (KE)" => "Kenya (KE)",
        "Korea, Republic of (KR)" => "Korea, Republic of (KR)",
        "Kuwait (KW)" => "Kuwait (KW)",
        "Latvia (LV)" => "Latvia (LV)",
        "Lebanon (LB)" => "Lebanon (LB)",
        "Lithuania (LT)" => "Lithuania (LT)",
        "Luxembourg (LU)" => "Luxembourg (LU)",
        "Macau (MO)" => "Macau (MO)",
        "Macedonia, Republic of (MK)" => "Macedonia, Republic of (MK)",
        "Madagascar (MG)" => "Madagascar (MG)",
        "Malawi (MW)" => "Malawi (MW)",
        "Malaysia (MY)" => "Malaysia (MY)",
        "Maldives (MV)" => "Maldives (MV)",
        "Malta (MT)" => "Malta (MT)",
        "Marshall Islands (MH)" => "Marshall Islands (MH)",
        "Martinique (MQ)" => "Martinique (MQ)",
        "Mauritius (MU)" => "Mauritius (MU)",
        "Mexico (MX)" => "Mexico (MX)",
        "Moldova, Republic of (MD)" => "Moldova, Republic of (MD)",
        "Monaco (MC)" => "Monaco (MC)",
        "Mongolia (MN)" => "Mongolia (MN)",
        "Montenegro (ME)" => "Montenegro (ME)",
        "Morocco (MA)" => "Morocco (MA)",
        "Netherlands (NL)" => "Netherlands (NL)",
        "Netherlands Antilles (AN)" => "Netherlands Antilles (AN)",
        "New Zealand (NZ)" => "New Zealand (NZ)",
        "Nicaragua (NI)" => "Nicaragua (NI)",
        "Nigeria (NG)" => "Nigeria (NG)",
        "Norway (NO)" => "Norway (NO)",
        "Pakistan (PK)" => "Pakistan (PK)",
        "Panama (PA)" => "Panama (PA)",
        "Papua New Guinea (PG)" => "Papua New Guinea (PG)",
        "Paraguay (PY)" => "Paraguay (PY)",
        "Peru (PE)" => "Peru (PE)",
        "Philippines (PH)" => "Philippines (PH)",
        "Poland (PL)" => "Poland (PL)",
        "Portugal (PT)" => "Portugal (PT)",
        "Puerto Rico (PR)" => "Puerto Rico (PR)",
        "Qatar (QA)" => "Qatar (QA)",
        "Reunion (RE)" => "Reunion (RE)",
        "Romania (RO)" => "Romania (RO)",
        "Russian Federation (RU)" => "Russian Federation (RU)",
        "Rwanda (RW)" => "Rwanda (RW)",
        "Saint Vincent and the Grenadines (VC)" => "Saint Vincent and the Grenadines (VC)",
        "San Marino (SM)" => "San Marino (SM)",
        "Saudi Arabia (SA)" => "Saudi Arabia (SA)",
        "Senegal (SN)" => "Senegal (SN)",
        "Serbia (RS)" => "Serbia (RS)",
        "Singapore (SG)" => "Singapore (SG)",
        "Slovak Republic (SK)" => "Slovak Republic (SK)",
        "Slovenia (SI)" => "Slovenia (SI)",
        "South Africa (ZA)" => "South Africa (ZA)",
        "Spain (ES)" => "Spain (ES)",
        "Sri Lanka (LK)" => "Sri Lanka (LK)",
        "Sweden (SE)" => "Sweden (SE)",
        "Switzerland (CH)" => "Switzerland (CH)",
        "Taiwan (TW)" => "Taiwan (TW)",
        "Tanzania, United Republic of (TZ)" => "Tanzania, United Republic of (TZ)",
        "Thailand (TH)" => "Thailand (TH)",
        "Timor-Leste (TL)" => "Timor-Leste (TL)",
        "Trinidad and Tobago (TT)" => "Trinidad and Tobago (TT)",
        "Turkey (TR)" => "Turkey (TR)",
        "Turkmenistan (TM)" => "Turkmenistan (TM)",
        "Uganda (UG)" => "Uganda (UG)",
        "Ukraine (UA)" => "Ukraine (UA)",
        "United Arab Emirates (AE)" => "United Arab Emirates (AE)",
        "United Kingdom (GB)" => "United Kingdom (GB)",
        "United States (US)" => "United States (US)",
        "Uruguay (UY)" => "Uruguay (UY)",
        "Venezuela (VE)" => "Venezuela (VE)",
        "Vietnam (VN)" => "Vietnam (VN)",
        "Virgin Islands, British (VG)" => "Virgin Islands, British (VG)",
        "Virgin Islands, U.S. (VI)" => "Virgin Islands, U.S. (VI)"
    ];
    return $countries;
}