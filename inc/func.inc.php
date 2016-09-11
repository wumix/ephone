<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 2/26/2015
 * Time: 1:32 PM
 */

$demo                               =   false;

$countryArray = array(  'AE' => 'United Arab Emirates', 'AF' => 'Afghanistan', 'AG' => 'Antigua and Barbuda',
    'AL' => 'Albania', 'AM' => 'Armenia', 'AO' => 'Angola', 'AR' => 'Argentia',
    'AT' => 'Austria', 'AU' => 'Australia', 'AZ' => 'Azerbaijan', 'BA' => 'Bosnia and Herzegovina',
    'BB' => 'Barbados', 'BD' => 'Bangladesh', 'BE' => 'Belgium', 'BF' => 'Burkina Faso',
    'BG' => 'Bulgaria', 'BI' => 'Burundi', 'BJ' => 'Benin', 'BN' => 'Brunei Darussalam',
    'BO' => 'Bolivia', 'BR' => 'Brazil', 'BS' => 'Bahamas', 'BT' => 'Bhutan',
    'BW' => 'Botswana', 'BY' => 'Belarus', 'BZ' => 'Belize', 'CA' => 'Canada',
    'CD' => 'Congo', 'CF' => 'Central African Republic', 'CG' => 'Congo', 'CH' => 'Switzerland',
    'CI' => "Cote d'Ivoire", 'CL' => 'Chile', 'CM' => 'Cameroon', 'CN' => 'China', 'CO' => 'Colombia',
    'CR' => 'Costa Rica', 'CU' => 'Cuba', 'CV' => 'Cape Verde', 'CY' => 'Cyprus',
    'CZ' => 'Czech Republic', 'DE' => 'Germany', 'DJ' => 'Djibouti', 'DK' => 'Denmark',
    'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'DZ' => 'Algeria', 'EC' => 'Ecuador',
    'EE' => 'Estonia', 'EG' => 'Egypt', 'ER' => 'Eritrea', 'ES' => 'Spain', 'ET' => 'Ethiopia',
    'FI' => 'Finland', 'FJ' => 'Fiji', 'FK' => 'Falkland Islands', 'FR' => 'France', 'GA' => 'Gabon',
    'GB' => 'United Kingdom', 'GD' => 'Grenada', 'GE' => 'Georgia', 'GF' => 'French Guiana',
    'GH' => 'Ghana', 'GL' => 'Greenland', 'GM' => 'Gambia', 'GN' => 'Guinea', 'GQ' => 'Equatorial Guinea',
    'GR' => 'Greece', 'GT' => 'Guatemala', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HN' => 'Honduras',
    'HR' => 'Croatia', 'HT' => 'Haiti', 'HU' => 'Hungary', 'ID' => 'Indonesia', 'IE' => 'Ireland',
    'IL' => 'Israel', 'IN' => 'India', 'IQ' => 'Iraq', 'IR' => 'Iran', 'IS' => 'Iceland',
    'IT' => 'Italy', 'JM' => 'Jamaica', 'JO' => 'Jordan', 'JP' => 'Japan', 'KE' => 'Kenya',
    'KG' => 'Kyrgyz Republic', 'KH' => 'Cambodia', 'KM' => 'Comoros', 'KN' => 'Saint Kitts and Nevis',
    'KP' => 'North Korea', 'KR' => 'South Korea', 'KW' => 'Kuwait', 'KZ' => 'Kazakhstan',
    'LA' => "Lao People's Democratic Republic", 'LB' => 'Lebanon', 'LC' => 'Saint Lucia',
    'LK' => 'Sri Lanka', 'LR' => 'Liberia', 'LS' => 'Lesotho', 'LT' => 'Lithuania', 'LV' => 'Latvia',
    'LY' => 'Libya', 'MA' => 'Morocco', 'MD' => 'Moldova', 'MG' => 'Madagascar', 'MK' => 'Macedonia',
    'ML' => 'Mali', 'MM' => 'Myanmar', 'MN' => 'Mongolia', 'MR' => 'Mauritania', 'MT' => 'Malta',
    'MU' => 'Mauritius', 'MV' => 'Maldives', 'MW' => 'Malawi', 'MX' => 'Mexico', 'MY' => 'Malaysia',
    'MZ' => 'Mozambique', 'NA' => 'Namibia', 'NC' => 'New Caledonia', 'NE' => 'Niger',
    'NG' => 'Nigeria', 'NI' => 'Nicaragua', 'NL' => 'Netherlands', 'NO' => 'Norway', 'NP' => 'Nepal',
    'NZ' => 'New Zealand', 'OM' => 'Oman', 'PA' => 'Panama', 'PE' => 'Peru', 'PF' => 'French Polynesia',
    'PG' => 'Papua New Guinea', 'PH' => 'Philippines', 'PK' => 'Pakistan', 'PL' => 'Poland',
    'PT' => 'Portugal', 'PY' => 'Paraguay', 'QA' => 'Qatar', 'RE' => 'Reunion', 'RO' => 'Romania',
    'RS' => 'Serbia', 'RU' => 'Russian FederationÃŸ', 'RW' => 'Rwanda', 'SA' => 'Saudi Arabia',
    'SB' => 'Solomon Islands', 'SC' => 'Seychelles', 'SD' => 'Sudan', 'SE' => 'Sweden',
    'SI' => 'Slovenia', 'SK' => 'Slovakia', 'SL' => 'Sierra Leone', 'SN' => 'Senegal',
    'SO' => 'Somalia', 'SR' => 'Suriname', 'ST' => 'Sao Tome and Principe', 'SV' => 'El Salvador',
    'SY' => 'Syrian Arab Republic', 'SZ' => 'Swaziland', 'TD' => 'Chad', 'TG' => 'Togo',
    'TH' => 'Thailand', 'TJ' => 'Tajikistan', 'TL' => 'Timor-Leste', 'TM' => 'Turkmenistan',
    'TN' => 'Tunisia', 'TR' => 'Turkey', 'TT' => 'Trinidad and Tobago', 'TW' => 'Taiwan',
    'TZ' => 'Tanzania', 'UA' => 'Ukraine', 'UG' => 'Uganda', 'US' => 'United States of America',
    'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VE' => 'Venezuela', 'VN' => 'Vietnam', 'VU' => 'Vanuatu',
    'YE' => 'Yemen', 'ZA' => 'South Africa', 'ZM' => 'Zambia','ZW' => 'Zimbabwe'
);

function secure( $data, $isPass = false )
{
    $data = htmlspecialchars(trim($data));
    $data = $isPass ? hash( 'sha512', $data . 'NATITTAHC' ) : $data;
    return $data;
}

function get_extension($file_name)
{
    $ext = explode('.', $file_name);
    $ext = array_pop($ext);
    return strtolower($ext);
}

function isReady( $dataArray, $checkArray )
{
    foreach( $checkArray as $key )
    {
        if(isset($dataArray[$key]) && !empty($dataArray[$key]))
        {
            continue;
        }
        else
        {
            return false;
        }
    }
    return true;
}

function get_random_string( $length,  $onlyLetters    =    false )
{
    if( $onlyLetters ){
        $valid_chars   =   "abcdefghijklmnopqrstuvwxyz";
    }else{
        $valid_chars   =   "ABCDEFGHIJLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789";
    }

    // start with an empty random string
    $random_string = "";

    // count the number of chars in the valid chars string so we know how many choices we have
    $num_valid_chars = strlen($valid_chars);

    // repeat the steps until we've created a string of the right length
    for ($i = 0; $i < $length; $i++)
    {
        // pick a random number from 1 up to the number of valid chars
        $random_pick = mt_rand(1, $num_valid_chars);

        // take the random character out of the string of valid chars
        // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
        $random_char = $valid_chars[$random_pick-1];

        // add the randomly-chosen char onto the end of our string so far
        $random_string .= $random_char;
    }

    // return our finished random string
    return $random_string;
}

function checkHex($hex){
    return preg_match( '/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $hex );
}

function dj($arr = array()){
    @header( 'Content-Type: application/json; charset=utf-8' );
    die(json_encode($arr));
}

function get_user(){
    global $db;

    if(!isset($_SESSION['loggedin'])){
        return false;
    }

    $userQuery                  =   $db->prepare("SELECT * FROM users WHERE id = :uid");
    $userQuery->execute(array(
        ":uid"                  =>  $_SESSION['uid']
    ));

    if($userQuery->rowCount() === 0){
        return false;
    }

    return $userQuery->fetch(PDO::FETCH_ASSOC);
}

function get_params(){
    return json_decode(file_get_contents('php://input'), true);
}

function create_zip($files = array(),$destination = '',$overwrite = false) {
    $user                       =   get_user();

    //if the zip file already exists and overwrite is false, return false
    if(file_exists($destination) && !$overwrite) { return false; }
    //vars
    $valid_files = array();
    //if files were passed in...
    if(is_array($files)) {
        //cycle through each file
        foreach($files as $file) {
            //make sure the file exists
            if(file_exists( $file)) {
                $valid_files[] = $file;
            }
        }
    }
    //if we have good files...
    if(count($valid_files)) {
        //create the archive
        $zip = new ZipArchive();
        if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
            return false;
        }
        //add the files
        foreach($valid_files as $file) {
            $zip->addFile($file,basename($file));
        }
        //debug
        //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

        //close the zip -- done!
        $zip->close();

        //check to make sure the file exists
        return file_exists($destination);
    }
    else
    {
        return false;
    }
}

function cyr2lat($text){
    $transliterationTable = array(
        'á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a',
        'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE',
        'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c',
        'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D',
        'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E',
        'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E',
        'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G',
        'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I',
        'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I',
        'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L',
        'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N',
        'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O',
        'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O',
        'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R',
        'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's',
        'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't',
        'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U',
        'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue',
        'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y',
        'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z',
        'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g',
        'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z',
        'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n',
        'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't',
        'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh',
        'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e',
        'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja',
        // Greek
        'Α' => 'A', 'α' => 'a', 'Β' => 'B', 'β' => 'b', 'Γ' => 'C', 'γ' => 'c', 'Δ' => 'D', 'δ' => 'd', 'Ε' => 'E', 'ε' => 'e',
        'Ζ' => 'F', 'ζ' => 'f', 'Η' => 'H', 'η' => 'h', 'Θ' => '', 'θ' => '', 'Ι' => 'I', 'ι' => 'i', 'Κ' => 'K', 'κ' => 'k',
        'Μ' => 'M', 'μ' => 'm', 'Ν' => 'N', 'ν' => 'n', 'Ξ' => 'Z', 'ξ' => 'z', 'Π' => '', 'π' => '', 'Σ' => 'Q', 'σ' => 'q',
        'ς' => '', 'υ' => 'y', 'Φ' => 'R', 'φ' => 'r', 'χ' => 'x', 'Ψ' => 'y', 'ψ' => 'y', 'Ω' => 'W', 'ω' => 'w',
        'a' => 'a', 'λ' => 'n', 'τ' => 't', 'έ' => 'e', 'ύ' => 'u', 'ή' => 'n', 'ώ' => 'w',
    );
    return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $text);
}


function create_slug( $t ){
    $slug                       =   str_replace(array("?", "(", ")"), "", cyr2lat($t));
    $slug                       =   urlencode(strtolower(str_replace(" ", "-", $slug)));
    return $slug;
}

function makeLinks($str, $target='_blank')
{
    if ($target)
    {
        $target = ' target="'.$target.'"';
    }
    else
    {
        $target = '';
    }
    // find and replace link
    $str = preg_replace('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', '<a href="$1" '.$target.'>$1</a>', $str);
    // add "http://" if not set
    $str = preg_replace('/<a\s[^>]*href\s*=\s*"((?!https?:\/\/)[^"]*)"[^>]*>/i', '<a href="http://$1" '.$target.'>', $str);
    return $str;
}


function get_numerics ($str) {
    preg_match_all('/\d+/', $str, $matches);
    return $matches[0];
}
