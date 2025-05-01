#Installation Instructions
This Magento 2 module is a test for Crimson Agility

##Requirements
Magento 2.4.x
PHP 8.3 or higher

The recommended way to install the module is using Composer.
Navigate to your Magento 2 project root:cd /path/to/your/magento2

##Install the module using Composer
composer require crimson-agility/module-products-in-range

Enable the module:bin/magento module:enable CrimsonAgility_ProductsInRange
Run the upgrade scripts:bin/magento setup:upgrade
Compile the code (recommended for production)
bin/magento setup:di:compile
Clear the cache:
bin/magento cache:clean
