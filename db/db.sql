drop database if exists anwesenheit;

create database anwesenheit;

use anwesenheit;

create table user
(
    id     int primary key auto_increment,
    fname  varchar(255),
    lname  varchar(255),
    email  varchar(255),
    pwhash varchar(255),
    role   varchar(255)
);

create table teilnehmer
(
    id           int primary key auto_increment,
    user_id      int,
    fachrichtung varchar(255),
    team         varchar(255),
    foreign key (user_id) references user (id)

);

create table anwesenheit
(
    id            int primary key auto_increment,
    dozenten_id   int,
    teilnehmer_id int,
    datum         date,
    status        varchar(255),
    foreign key (dozenten_id) references user (id),
    foreign key (teilnehmer_id) references teilnehmer (id)
);

# SELECT u.*,
#        t.fachrichtung,
#        t.team,
#        t.user_id,
#        t.id
# FROM user u  left join teilnehmer t on u.id = t.user_id
# where team is not null ;
#
#
# SELECT count(id)  FROM user where role='teilnehmer';
#
# SELECT * FROM anwesenheit where teilnehmer_id=6 and month(datum) = 1;
