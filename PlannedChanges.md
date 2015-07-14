## Modular comparison tests ##

Extract current tests from Comparison class, make them each their own test class. This would allow people to add their own tests and making writing new ones much easier!

## Diff export ##

Create a .sql file based on differences. Structure changes to perform statements like CREATE TABLE, ALTER TABLE. Data changes to run INSERT and UPDATE if there is a primary key.

### Things to consider ###
  * How do we keep this abstract for database type?
  * Various options for export, i.e. only add new rows, only perform updates
  * Whether we make it possible to dump data diff without schema, i.e. it may try to add data to a column that doesn't exist