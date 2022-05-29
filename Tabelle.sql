create database homework;
use homework;

create table utenti(
	user_id integer primary key auto_increment,
    username varchar(30) not null unique,
	nome varchar(60) not null,
    cognome varchar(60) not null,
    email varchar(255) not null unique,
    password varchar(30) not null
)Engine = InnoDB;

create table contents(
	id integer primary key auto_increment,
    title varchar(255) not null,
	img varchar(255) not null,
    p varchar(255) not null
)Engine = InnoDB;

create table comments(
	user_id integer not null,
	post_id integer primary key auto_increment,
    username varchar(255) not null,
	commento varchar(500) not null,
    n_like integer not null,
    index ind_user_id(user_id),
    foreign key(user_id) references utenti(user_id) on delete cascade on update cascade
)Engine = InnoDB;

create table likes(
    user integer not null,
	comment integer not null,
    index ind_user_id(user),
	index ind_comment(comment),
    foreign key(user) references utenti(user_id) on delete cascade on update cascade,
    foreign key(comment) references comments(post_id) on delete cascade on update cascade,
    primary key(user, comment)
)Engine = InnoDB;

INSERT INTO CONTENTS (title,img,p) VALUES('Sezione Articoli','https://sport.periodicodaily.com/wp-content/uploads/2021/11/ufc-news-768x512-1.png','Leggi le ultime notizie sul mondo della lotta...');
INSERT INTO CONTENTS (title,img,p) VALUES('Sezione Merchandising','https://library.sportingnews.com/styles/twitter_card_120x120/s3/2022-03/everlast%20boxing%20gloves.jpg?itok=keHm65Sb',"Scopri l'attrezzatura usata dai campioni...");
INSERT INTO CONTENTS (title,img,p) VALUES('Sezione Classifiche','https://s3.eu-central-1.amazonaws.com/gitalia.cdn/wp-content/uploads/2016/05/16132840/taglio-del-peso-ufc.jpg','Tutti i risultati dei combattimenti...');
//Trigger

DELIMITER //
CREATE TRIGGER comment_trigger
AFTER INSERT ON likes
FOR EACH ROW
BEGIN
UPDATE comments 
SET n_like = n_like + 1
WHERE post_id = new.comment;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER unlikes_trigger
AFTER DELETE ON likes
FOR EACH ROW
BEGIN
UPDATE comments
SET n_like = n_like - 1
WHERE post_id = old.comment;
END //
DELIMITER ;
