create database gestione_vacanze;
use gestione_vacanze;

drop table if exists utente;
create table utente(
    email varchar(150) primary key,
    nome varchar(40) not null,
    cognome varchar(40) not null,
    numero_telefono varchar(15) not null,
    ore_lavoro float(3,1),
    tipo varchar(14) not null,
    verificato tinyint(1) not null,
    password varchar(100) not null,
    verifica_email tinyint(1) not null,
    hash_mail varchar(32) not null
);

drop table if exists giorno;
create table giorno(
    giorno date primary key
);

drop table if exists lezione;
create table lezione(
    id integer AUTO_INCREMENT primary key,
    nome varchar(40) not null,
    ora_inizio time not null,
    ora_fine time not null,
    giorno date,
    foreign key (giorno) references giorno(giorno)
);

drop table if exists aggiunge;
create table aggiunge(
    email varchar(150), 
    giorno date,
    foreign key (email) references utente(email),
    foreign key (giorno) references giorno(giorno),
    primary key(email,giorno)
);

drop table if exists assegna;
create table assegna(
    email varchar(150),
    id_lezione integer,
    foreign key (email) references utente(email),
    foreign key (id_lezione) references lezione(id),
    primary key (email,id_lezione)
);