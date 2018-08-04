# IMDb Movie Database System

This is an IMDB-like movie website.

##### Four input pages:

- Page I1: A page that lets users to add actor and/or director information. Here are some name examples: X.M.L Smith, J'son Lee, etc.
- Page I2: A page that lets users to add movie information.
- Page I3: A page that lets users to add comments to movies. i.e. This movie was terrible.
- Page I4: A page that lets users to add "actor to movie" relation(s). i.e. Henry Lou stars in Alice in Wonderland.
- Page I5: A page that lets users to add "director to movie" relation(s). i.e. David Xu directs Alice in Wonderland.

##### Two browsing pages:

- Page B1: A page that shows actor information. It shows links to the movies that the actor was in.
- Page B2: A page that shows movie information. It shows Title, Producer, MPAA Rating, Director, Genre of this movie, links to the actors/actresses that were in this movie and the average score of the movie based on user feedbacks. It shows all user comments. "Add Comment" button is contained, which links to Page I3 where users can add comments.

##### One search page:
- Page S1: A page that lets users search for an actor/actress/movie through a keyword search interface.
(For actor/actress, we examine first/last name, and for movie, we examine title.) The search page supports multi-word search, such as "Tom Hanks". For multi-word search, interpret space as "AND" relation. That is, return all items that contain both words, "Tom" and "Hanks". Since the search page is for actor/actress/movie, so if there was a movie named "I love Tom Hanks!", it is returned. As for the output, I sort them in a way that users could find an item easily.

