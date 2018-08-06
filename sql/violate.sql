-- Primary key:
-- Duplicate key violation:
INSERT INTO Movie VALUES(2,'Huh',2016,'PG','HUAYI'); 
-- ID 2 exists in Table Movie and the duplicate id will cause a conflict.
-- ERROR 1062 (23000): Duplicate entry '2' for key 'PRIMARY'

INSERT INTO Actor VALUES(99,'Xu','Yanzhe','Male',19930906,NULL); 
-- ID 99 exists in Table Actor and the duplicate id will cause a conflict.
-- ERROR 1062 (23000): Duplicate entry '99' for key 'PRIMARY'

INSERT INTO Director VALUES(76,'Xu','Yanzhe',19930906,NULL); 
-- ID 76 exists in Table Director and the duplicate id will cause a conflict.
-- ERROR 1062 (23000): Duplicate entry '76' for key 'PRIMARY'


-- Foreign key:
-- Non existence foreign key violation:
INSERT INTO MovieGenre VALUES(10,'Comedy');
-- There is no tuple with 'id=10' in the Movie table. This will cause a conflict.
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

INSERT INTO MovieDirector VALUES(10,55); 
-- There is no tuple with 'id=10'('id=55') in the Movie(Director) table.  This will cause a conflict.
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

INSERT INTO MovieActor VALUES(10,66,'Wilde');
-- There is no tuple with 'id=10'('id=66') in the Movie(Actor) table.  This will cause a conflict.
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

INSERT INTO Review VALUES('Yanzhe',NULL,10, NULL,'it is an amazing movie.');
-- There is no tuple with 'id=10' in the Movie table. This will cause a conflict.
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`Review`, CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

-- Not NULL violation:
INSERT INTO Movie VALUES(3,NULL,NULL,NULL,NULL);
-- Movie title shouldn't be NULL.
-- ERROR 1048 (23000): Column 'title' cannot be null

INSERT INTO Actor VALUES(1,NULL,NULL,'Male',NULL,NULL);
-- Actor name shouldn't be NULL.
-- ERROR 1048 (23000): Column 'last' cannot be null

INSERT INTO Director VALUES(1,NULL,NULL,'Male',NULL,NULL);
-- Director name shouldn't be NULL.
-- ERROR 1048 (23000): Column 'last' cannot be null

-- Check constraints:
INSERT INTO Movie VALUES(-1,'Huh',-2016,'PG','HUAYI'); 
-- This will fail because 'id' and 'year' must be nonnegative integers

INSERT INTO Actor VALUES(-1,'Xu','Yanzhe','Male',19930906,NULL); 
-- This will fail because 'id' must be a nonnegative integer

INSERT INTO Director VALUES(-5,'Xu','Yanzhe',19930906,NULL); 
-- This will fail because 'id' must be a nonnegative integer