-- Active: 1727770097132@@127.0.0.1@3306@penzion

DROP DATABASE penzion;

CREATE DATABASE penzion DEFAULT CHARSET utf8mb4;

SHOW TABLES;

CREATE TABLE stranka (
    id VARCHAR(255) PRIMARY KEY,
    titulek VARCHAR(255),
    menu VARCHAR(255),
    obrazek VARCHAR(255),
    obsah TEXT,
    poradi INT UNSIGNED
);

DESC stranka;

INSERT INTO stranka SET id="kocka", titulek="mnau",
menu="cici", obsah="mnau mnau mnau!";

SELECT * FROM stranka;

DELETE FROM stranka WHERE id = "";