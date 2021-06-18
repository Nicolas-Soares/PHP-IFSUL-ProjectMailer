CREATE DATABASE teste_bd;
USE teste_bd;               
set global event_scheduler= ON;

CREATE TABLE usuarios (
	id int primary key not null auto_increment,
    nome varchar(65) not null,
    idade int not null,
    email varchar(65) not null unique,
    senha varchar(65) not null,
    verificacaotabela varchar(65)
);

/*
drop table usuarios;
SELECT * FROM usuarios;
SHOW EVENTS;
drop event myevent;
DELETE FROM usuarios where id;
*/