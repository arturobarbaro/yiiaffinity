--db/load.sh
DROP TABLE IF EXISTS generos CASCADE;

CREATE TABLE generos
(
    id     BIGSERIAL    PRIMARY KEY
  , genero VARCHAR(255) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS peliculas CASCADE;

CREATE TABLE peliculas
(
    id          BIGSERIAL    PRIMARY KEY
  , titulo      VARCHAR(255) NOT NULL
  , anyo        NUMERIC(4)
  , sinopsis    TEXT
  , duracion    SMALLINT     DEFAULT 0
                             CONSTRAINT ck_peliculas_duracion_positiva
                             CHECK (coalesce(duracion, 0) >= 0)
  , precio     NUMERIC(5,2)  CONSTRAINT ck_peliculas_precio_positiv0
                             CHECK (coalesce(precio, 0) >= 0)
  , created_at TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
  , genero_id  BIGINT        NOT NULL
                             REFERENCES generos (id)
                             ON DELETE NO ACTION
                             ON UPDATE CASCADE
);

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id       BIGSERIAL   PRIMARY KEY
  , login    VARCHAR(50) NOT NULL UNIQUE
                         CONSTRAINT ck_login_sin_espacios
                         CHECK (login NOT LIKE '% %')
  , password VARCHAR(60) NOT NULL
);

DROP TABLE IF EXISTS personas CASCADE;

CREATE TABLE personas
(
    id       BIGSERIAL    PRIMARY KEY
  , nombre   VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS papeles CASCADE;

CREATE TABLE papeles
(
    id       BIGSERIAL    PRIMARY KEY
  , papel    VARCHAR(255) NOT NULL UNIQUE
);

--Combinancion ternaria papeles, personas, peliculas
DROP TABLE IF EXISTS participaciones CASCADE;

CREATE TABLE participaciones
(
    pelicula_id   BIGINT   REFERENCES peliculas (id)
  , persona_id    BIGINT   REFERENCES personas (id)
  , papel_id      BIGINT   REFERENCES papeles (id)
  , PRIMARY KEY(pelicula_id,persona_id,papel_id)
);

-- INSERT

INSERT INTO usuarios (login, password)
VALUES ('pepe', crypt('pepe', gen_salt('bf', 10)))
     , ('admin', crypt('admin', gen_salt('bf', 10)));

INSERT INTO generos (genero)
VALUES ('Comedia')
     , ('Terror')
     , ('Ciencia-Ficción')
     , ('Drama')
     , ('Aventuras');

INSERT INTO peliculas (titulo, anyo, sinopsis, duracion, precio, genero_id)
VALUES ('Los últimos Jedi', 2017, 'Va uno y se cae...', 204, 35, 3)
     , ('Los Goonies', 1985, 'Unos niños encuentran un tesoro', 120, 10.50, 5)
     , ('Aquí llega Condemor', 1996, 'Mejor no cuento nada...', 90, 12, 1);

INSERT INTO personas (nombre)
VALUES ('Will Smith')
     , ('James P')
     , ('Julia Roberts');

INSERT INTO papeles (papel)
VALUES ('Actor')
     , ('Director')
     , ('Productor')
     , ('Guionista');

INSERT INTO participaciones (pelicula_id,persona_id,papel_id)
VALUES (1,1,1)
     , (1,2,3)
     , (1,1,3)
     , (1,2,2)
     , (2,2,1)
     , (3,1,3);
