create table category
(
  ID_category int PRIMARY key AUTO_INCREMENT,
  Name varchar(20) UNIQUE not null
);
insert into category (ID_category, Name) values
                                           (null,'Доски и лыжи'),
                                           (null,'крепления'),
                                           (null,'ботинки'), (null,'одежда'),
                                           (null,'инструменты'), (null,'разное');
create table announcement(
                           ID_announcements int PRIMARY KEY AUTO_INCREMENT,
                           ID_category int not null,
                           ID_creator int not null,
                           ID_winner int not null,
                           Date_of_creating datetime not null,
                           Name varchar(50) not null,
                           Description  varchar(100) not null,
                           Image varchar(75) not null unique,
                           Start_cost int not null,
                           Date_of_ending datetime not null,
                           Bet_step int not null
);
create table Bet(
                  ID_bet int PRIMARY KEY AUTO_INCREMENT,
                  ID_user int not null,
                  ID_announcement int not null,
                  Date_of_accommodation datetime not null,
                  Sum int not null
);
create table User(
                   ID_user int primary key AUTO_INCREMENT,
                   ID_announcement int not null,
                   ID_bet int not null,
                   Date_of_registration datetime not null,
                   Email varchar(50) not null unique,
                   User_name varchar(50) not null unique,
                   Password varchar(150) not null,
                   Avatar varchar(75) not null,
                   Contacts text not null
);
alter table announcement
  add foreign key (ID_category) references category(ID_category) ON DELETE CASCADE ON UPDATE CASCADE,
    add foreign key (ID_creator) references User(ID_user) ON DELETE CASCADE ON UPDATE CASCADE,
    add foreign key (ID_winner) references  User(ID_user) ON DELETE CASCADE ON UPDATE CASCADE;
alter table bet
  add foreign key (ID_user) references User(ID_user) ON DELETE CASCADE ON UPDATE CASCADE,
    add foreign key (ID_announcement) references announcement(ID_announcements) ON DELETE CASCADE ON UPDATE CASCADE
alter table user
  add foreign key (ID_announcement) references announcement(ID_announcements) ON DELETE CASCADE ON UPDATE CASCADE,
    add foreign key (ID_bet) references bet(ID_bet)ON DELETE CASCADE ON UPDATE CASCADE
