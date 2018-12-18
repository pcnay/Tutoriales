/* Listado de operaciones CRUD de Mexflix */
/* 
MOVIESERIES:
  Crear peliculas y series
  Eliminar peliculas y series
  Actualizar peliculas y series
  Buscar todas las peliculas y series 
  Buscar un pelicula o serie por personas, titulos, genero.
  Buscar una pelicula o serie por Categoría
  Buscar una pelicula o serie por Estatus
ESTATUS
  Crear estatus 
  Eliminar estatus 
  Actualizar estatus 
  Buscar un estatus 
  Buscar por ID de estatus_id
USERS
  Crear user
  Eliminar uesr
  Actualizar user 
    Datos generales
    Password (Es raro que se realize esta operación)
  Buscar un user por:
    user
    email
    role

CREAR EL CRUD ANTERIOR UTILIZANDO CODIGO DE "SQL"
MovieSeries:
  Crear peliculas y series:

    INSERT INTO movieseries SET 
      imdb_id = 'tt3749900',
      title = 'Gotam',
      plot = '',
      author = '',
      actors = '',
      country ='',
      premiere = '2014',
      trailer = '',
      poster = '',
      rating = 8.0,
      genres = 'Crime Drama Thriller',
      category = 'Serie',
      status = 3;

  Actualizar MovieSeries:
    
    UPDATE movieseries SET 
      title = 'Gotham',
      plot = 'ns dna dnm adsnm a dam dna dsn and a dands kjadakjsdkjadnjandkjandkjnsadkjnakdjnaskjdnkjankjnakjdnakjsdnkjandskjansj nakjnsdkjnasndaksjndkajndskjanskjdnaskjdnakjsdnkjasndkjansdkjnakjs ndkjandskjna d Bruce\'s ASDASDASDASD ASDA',
      author = 'Autor Dinamark ',
      actors = 'Actor Bruces',
      country = 'Pais EUA',
      trailer = 'Trailer ..sadadsadsadsadsadsadsadsasda' 
      WHERE imdb_id = 'tt3749900';

  Eliminar MovieSeries:
    DELETE FROM movieseries WHERE imdb_id = 'tt3749900';

  Listar todas las peliculas:
    
    SELECT ms.imdb_id,ms.title,s.status
    FROM movieseries AS ms
    INNER JOIN estatus AS s
    ON ms.estatus = s.estatus_id;

  Buscar una movieseries por titulos, persona, generos

    SELECT ms.imdb_id,ms.title,s.status
    FROM movieseries AS ms
    INNER JOIN estatus AS s
    ON ms.estatus = s.estatus_id
    WHERE MATCH (ms.title,ms.author,ms.actors,ms.genres)
    AGAINST ('drama ' IN BOOLEAN MODE);

  Buscar por categoría 

    SELECT ms.imdb_id,ms.title,s.status
    FROM movieseries AS ms
    INNER JOIN estatus AS s
    ON ms.estatus = s.estatus_id
    WHERE ms.category = 'Movie';

Buscar por estatus 

    SELECT ms.imdb_id,ms.title,s.status
    FROM movieseries AS ms
    INNER JOIN estatus AS s
    ON ms.estatus = s.estatus_id
    WHERE ms.estatus = 1;

......................
Para las demas tablas es similar.


*/