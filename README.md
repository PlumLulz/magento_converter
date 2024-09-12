# magento_converter
Convert Magento2 hashes to the $argon2id format.

Usage: php magento_converter.php input.txt output.txt

Before converting:\
ab5ebf8d273b085b6a60336198e0a5a2090fdc3e0606a678315c7274ab06e046:5PiKJRn28bBKoFMopMaaKuV47aJ6GzVg:3_32_2_67108864

After converting:\
$argon2id$v=19$m=65536,t=2,p=1$NVBpS0pSbjI4YkJLb0ZNbw$q16\/jSc7CFtqYDNhmOClogkP3D4GBqZ4MVxydKsG4EY


<img width="595" src="https://github.com/user-attachments/assets/eaa85380-be35-4234-a2fe-0168e86b094d">

