insert into category (ID_category, Name) values
                                           (null,'Доски и лыжи'),
                                           (null,'крепления'),
                                           (null,'ботинки'), (null,'одежда'),
                                           (null,'инструменты'), (null,'разное');
insert into user values(
                         Null,
                         '2002-12-28',
                         'emailoffool@gmail.com',
                         'Fool',
                         'NGINIF34fa',
                         'img/user.jpg',
                         ''),
                       (
                         Null,
                         '2020-05-06',
                         'emailofsun@gmail.com',
                         'Sun',
                         'JNFIHF23j',
                         'img/user.jpg',
                         ''
                       ),(
                         Null,
                         '2015-05-06',
                         'emailoftower@gmail.com',
                         'Tower',
                         'JNFIHF23j',
                         'img/user.jpg',
                         ''
                       );
insert into announcement values(
                                 NULL,
                                 1,
                                 1,
                                 2,
                                 '2021-01-01 11:00:00',
                                 '2014 Rossignol District Snowboard',
                                 'Just nice Snowboard',
                                 'img/lot-1.jpg',
                                 10999,
                                 '2021-01-03 09:29:07',
                                 500
                                ),
                               (
                                NULL,
                                1,
                                1,
                                null,
                                '2022-01-01 12:00:00',
                                'DC Ply Mens 2016/2017 Snowboard',
                                'Just nice Snowboard',
                                'img/lot-2.jpg',
                                159999,
                                null,
                                1000
                                ),
                               (
                                 NULL,
                                 2,
                                 2,
                                 null,
                                 '2022-01-01 12:00:00',
                                 'Крепления Union Contact Pro 2015 года размер L/XL',
                                 'Крепления размера XL/L',
                                 'img/lot-3.jpg',
                                 8000,
                                 null,
                                 400
                               ),
                               (
                                 NULL,
                                 3,
                                 2,
                                 null,
                                 '2022-01-01 12:00:00',
                                 'Ботинки для сноуборда DC Mutiny Charocal',
                                 'Ботинки',
                                 'img/lot-4.jpg',
                                 10999,
                                 null,
                                 500
                               ),
                               (
                                 NULL,
                                 4,
                                 2,
                                 null,
                                 '2022-01-01 12:00:00',
                                 'Куртка для сноуборда DC Mutiny Charocal',
                                 'Куртка',
                                 'img/lot-5.jpg',
                                 7500,
                                 null,
                                 450
                               ), (
                                 NULL,
                                 6,
                                 1,
                                 null,
                                 '2022-01-01 12:00:00',
                                 'Маска Oakley Canopy',
                                 'Маска',
                                 'img/lot-6.jpg',
                                 5400,
                                 null,
                                 350
                               );
  insert into bet values(
  null,
  1,
  2,
  '2021-01-02 09:30:00',
  500
  ),
  (
  null,
  1,
  3,
  '2021-01-03 09:20:32',
  500
  ),
  (
  null,
  5,
  3,
  '2021-01-03 09:20:32',
  1000
  ),(
  null,
  5,
  2,
  '2021-01-03 09:20:32',
  1000
  );



#Начало запросов


select * from category;
select a.Name,
       Start_cost,
       Image,
       (sum(b.Sum)+a.Start_cost)Последняя_ставка,
       count(b.Sum)Количество_ставок,
       c.Name,
       ID_winner
from announcement as a
       left join bet b
                 on a.ID_announcements = b.ID_announcement
       inner join category c on a.ID_category = c.ID_category
group by a.Name, Start_cost, Image,Date_of_creating,ID_winner
having ISNULL(ID_winner)
order by Date_of_creating desc;
select * from announcement inner join category c on announcement.ID_category = c.ID_category
where ID_announcements=1;
select * from bet inner join announcement a on bet.ID_announcement = a.ID_announcements
where ID_announcements = 1;
