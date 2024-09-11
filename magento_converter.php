<?php
# Convert Magento2 hashes to the $argon2id format
# Usage: php magento_converter.php inputfile outputfile
# Author: Plum

if (count($argv) != 3) {
	echo "Usage: php $argv[0] inputfile outputfile";
	die();
}

$input = $argv[1];
$output = $argv[2];
$invalidformat = 0;
$invalidoptions = 0;
$valid = 0;

# Read input file line by line
$openfile = fopen($input, "r");
echo "Processing hashes...";
while (($line = fgets($openfile)) !== false) {
	$parse = explode(":", $line);
	if (count($parse) != 3) {
		$invalidformat++;
	} else {
		# Set hash, salt, and options vars to be processed
		$hexdigest = $parse[0];
		$salt = $parse[1];
		$options = $parse[2];

		# Convert options to argon2id format
		$options = explode("_", $options);
		if (count($options) != 4) {
			$invalidoptions++;
		} else {
			# Set each option to a var
			$t = $options[2];
			$m = $options[3] / 1024;
			$p = 1;
			$v = 19;

			# Convert salt to argon2id format
			# SODIUM_CRYPTO_PWHASH_SALTBYTES is default to 16 so the salt must be substr'd
			$salt = substr($salt, 0, 16);
			$salt = sodium_bin2base64($salt, SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING);

			# Convert hash hex digest to argon2id format
			$hexdigest = sodium_bin2base64(hex2bin($hexdigest), SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING);

			# Final argon2id format output
			$final = "\$argon2id\$v=$v\$m=$m,t=$t,p=$p\$$salt\$$hexdigest\n";
			if (file_put_contents($output, $final, FILE_APPEND) == FALSE) {
				echo "Failed to write to $output";
				die();
			} else {
				$valid++;
			}
		}
	}
}
$total = $valid + $invalidformat + $invalidoptions;
echo "\n\n$total Total lines processed.\n";
echo "$valid Valid hashes.\n";
echo "$invalidformat Invalid hash format.\n";
echo "$invalidoptions Invalid options.";
?>
