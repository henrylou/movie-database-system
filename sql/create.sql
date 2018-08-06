CREATE TABLE Movie(
	id  INT AUTO_INCREMENT,
    -- Movie ID
    title VARCHAR(100) NOT NULL,
    -- Movie Title
    year INT NOT NULL,
    -- Release year
    rating VARCHAR(10),
    -- MPAA rating
    company VARCHAR(50),
	-- Production company
    PRIMARY KEY(id),
    -- Unique Movie ID
    CHECK (id >= 0 AND year >= 0) 
    -- Movie id and release year must be nonnegative
) ENGINE=InnoDB;

CREATE TABLE Actor(
	id INT AUTO_INCREMENT,
    -- Actor ID
    last VARCHAR(20) NOT NULL,
    -- Last name
    first VARCHAR(20) NOT NULL,
    -- First name
    sex VARCHAR(6) NOT NULL,
    -- Sex of the actor
    dob DATE NOT NULL,
    -- Date of birth
    dod DATE,
    -- Date of death
    PRIMARY KEY(id),
    -- Unique Actor ID
    CHECK (id >= 0) 
    -- Actor's id must be nonnegative
) ENGINE=InnoDB;

CREATE TABLE Director(
	id INT,
    -- Director ID
    last VARCHAR(20) NOT NULL,
    -- Last name
    first VARCHAR(20) NOT NULL,
    -- First name
    sex VARCHAR(6) NOT NULL,
    -- Sex of the actor
    dob DATE NOT NULL,
    -- Date of birth
    dod DATE,
    -- Date of death
    PRIMARY KEY(id),
    -- Unique Director ID
    CHECK (id >= 0) 
    -- Director's id must be nonnegative
) ENGINE=InnoDB;

CREATE TABLE MovieGenre(
	mid INT,
    -- Moive ID
    genre VARCHAR(20),
    -- Movie genre
    PRIMARY KEY(mid),
    -- Unique Movie ID
    FOREIGN KEY(mid) REFERENCES Movie(id)
    -- This ID must be in Movie Table
) ENGINE=InnoDB;

CREATE TABLE MovieDirector(
	mid INT,
    -- Moive ID
    did INT,
    -- Director ID
    PRIMARY KEY(mid),
    -- Unique Movie ID
    FOREIGN KEY(mid) REFERENCES Movie(id),
    -- This ID must be in Movie Table
    FOREIGN KEY(did) REFERENCES Director(id)
    -- This Director ID must be in Director Table
) ENGINE=InnoDB;

CREATE TABLE MovieActor(
	mid INT,
    -- Moive ID
    aid INT,
    -- Actor ID
    role VARCHAR(50),
    -- Actor role in movie
    PRIMARY KEY(mid,aid),
    -- The Actor ID and Movie ID form the unique key
    FOREIGN KEY(mid) REFERENCES Movie(id),
    -- This ID must be in Movie Table
    FOREIGN KEY(aid) REFERENCES Actor(id)
    -- This Actor ID must be in Movie Table
) ENGINE=InnoDB;

CREATE TABLE Review(
	name VARCHAR(20),
    -- Reviewer name
    time TIMESTAMP,
    -- Review time
    mid INT NOT NULL,
    -- Movie ID
    rating INT,
    -- Review rating
    comment VARCHAR(500),
    -- Reviewer comment
    PRIMARY KEY(name,time,mid),
    -- Unique for each review
    FOREIGN KEY(mid) REFERENCES Movie(id)
    -- The mid must be one ID of Movie Table
) ENGINE=InnoDB;

CREATE TABLE MaxPersonID(
	id INT,
    -- Max ID assigned to all persons
    PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE MaxMovieID(
	id INT,
    -- Max ID assigned to all movies
    PRIMARY KEY(id)
) ENGINE=InnoDB;