
# WTC Custom Import Module Test

Magento Customer import from CLI

WTC => Wunderman Thompson Commerce

# Manual Installation
Download the module code from git https://github.com/rrameshh90/customerimport 

create the module under app/code/WTC/CustomerImport and move the above code to this location

Execute the Deployment Commands and verify the functionality 

# Console Command
customer:import:sample-csv    Import Customer ProfileCSV

customer:import:sample-json   Import Customer ProfileJSON

Create the sample files "sample.csv" and "sample.json" and execute the below command 

php bin/magento customer:import:sample-csv  sample.csv

php bin/magento customer:import:sample-json sample.json

# Supported
Tested on Magento 2.4.2-p2 to 2.4.3 with php 7.4

# Note: 
For composer require wtc/module-customerimport command i'm facing some issue.


                                                                                                                                                                                        