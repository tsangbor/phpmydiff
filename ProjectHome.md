A standalone PHP application to view differences between two MySQL databases. Compare the schema, data or both.

In development is the ability to create a .sql file of the differences to apply.

Built on the Zend Framework.

## Please note ##

phpmydiff is in very early stages of development. Please be patient and submit any bugs to us using the Issues tab above.

Current features include:
  * Compare schema of two databases
  * Compare data between two databases

Features we are planning to add shortly:
  * Create a diff.sql file based on the differences
  * Compare other types of database (i.e. any type supported by Zend\_Db)
  * Hash the data for comparison in MySQL, reducing memory required