-- Actor id should be in MovieActor Table with the mid which has a title "Die Another Day".
SELECT CONCAT(A.last, ' ',A.first) AS name
FROM Movie M, MovieActor MA, Actor A 
WHERE M.title='Die Another Day' AND M.id=MA.mid AND MA.aid=A.id; 



-- Find the num of distinct actors
SELECT count(*) AS num
FROM Actor A 
WHERE A.id in(
	SELECT A.id
    FROM MovieActor MA1 INNER JOIN Actor A
    ON MA1.aid=A.id
	GROUP BY A.id
    HAVING count(A.id)>=2
    -- First find all the actor id which has showed in at least two movies
);


-- find all kinds of genre the first 30 actors  have participated in
SELECT DISTINCT genre
FROM MovieGenre MG, MovieActor MA
WHERE MG.mid=MA.mid AND MA.aid<30;



