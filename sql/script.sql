
CREATE TABLE DEPARTAMENT (
    id_departament INT AUTO_INCREMENT PRIMARY KEY,
    nom_departament VARCHAR(100) NOT NULL
);

CREATE TABLE TECNIC (
    id_tecnic INT AUTO_INCREMENT PRIMARY KEY,
    nom_tecnic VARCHAR(200) NOT NULL,
    especialitat VARCHAR(50)
);

CREATE TABLE TIPUS (
    id_tipus INT AUTO_INCREMENT PRIMARY KEY,
    nom_tipus VARCHAR(200) NOT NULL
);

CREATE TABLE INCIDENCIA (
    id_incidencia INT AUTO_INCREMENT PRIMARY KEY,
    descripcio VARCHAR(2000),
    data_inici DATETIME DEFAULT CURRENT_TIMESTAMP, 
    data_final DATETIME NULL,                       
    prioritat ENUM('Alta', 'Mitja', 'Baixa'),
    resolta BOOLEAN DEFAULT FALSE,
    id_departament INT,
    id_tecnic INT,
    id_tipus INT,
    FOREIGN KEY (id_departament) REFERENCES DEPARTAMENT(id_departament),
    FOREIGN KEY (id_tecnic) REFERENCES TECNIC(id_tecnic),
    FOREIGN KEY (id_tipus) REFERENCES TIPUS(id_tipus)
);

CREATE TABLE ACTUACIONS (
    id_actuacio INT AUTO_INCREMENT PRIMARY KEY,
    id_incidencia INT,
    data_actuacio DATETIME DEFAULT CURRENT_TIMESTAMP,
    descripcio_detallada TEXT,
    temps_minuts INT,
    visible_usuari BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (id_incidencia) REFERENCES INCIDENCIA(id_incidencia)
);