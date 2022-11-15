USE competition;

drop table if exists `users`;
create table if not exists `users`
(
  `id` int(32) auto_increment,
  `login_id` varchar(255) not null,
  `password` varchar(255) not null,
  `name` varchar(255) not null,
  primary key(`id`)
) engine=innodb default charset=utf8mb4;

insert into users(login_id, password, name) 
  values
    ('user1', 'Kagoshima2022', '鹿児島　太郎'),
    ('user2', 'K@goshima2022', '鹿児島　太郎'),
    ('user3', 'Kagoshim@2022', '鹿児島　太郎'),
    ('user4', 'K@goshim@2022', '鹿児島　太郎'),
    ('user5', 'KagoShima2022', '鹿児島　太郎'),
    ('user6', 'kagoshima2022', '鹿児島　太郎'),
    ('user7', 'KaGoshima2022', '鹿児島　太郎'),
    ('user8', 'KagosHima2022', '鹿児島　太郎'),
    ('user9', 'KAgoshima2022', '鹿児島　太郎'),
    ('user10', 'KagOshima2022', '鹿児島　太郎'),
    ('user11', 'Kag0shima2022', '鹿児島　太郎'),
    ('user12', 'KagoshIma2022', '鹿児島　太郎'),
    ('user13', 'KagoshiMa2022', '鹿児島　太郎'),
    ('user14', 'KagoshiMA2022', '鹿児島　太郎'),
    ('user15', 'KagoSHima2022', '鹿児島　太郎'),
    ('user16', 'KaGOshima2022', '鹿児島　太郎'),
    ('user17', 'Kagoshima2023', '鹿児島　太郎'),
    ('user18', 'Kagoshima2024', '鹿児島　太郎');

drop table if exists `admins`;
create table if not exists `admins`
(
  `id` int(32) auto_increment,
  `login_id` varchar(255) not null,
  `password` varchar(255) not null,
  `secret` varchar(255) not null,
  primary key(`id`)
) engine=innodb default charset=utf8mb4;

insert into admins(login_id, password, secret) values('ctfadmin', 'KagoshimaAdministrator', 'look at "/tmp/flag" !!!');


drop table if exists `books`;
create table if not exists `books`
(
  `id` int(32) auto_increment,
  `name` varchar(255) not null,
  `summary` varchar(255) not null,
  `owner_id` int(32) not null,
  primary key(`id`)
) engine=innodb default charset=utf8mb4;

insert into books(name, summary, owner_id) 
  values
    ('鹿児島観光案内2021', '鹿児島の観光はこの一冊でOK！', 1),
    ('鹿児島グルメNo1', '鹿児島の食はこの一冊でOK！', 1),
    ('The鹿児島高専', '鹿児島高専のことがこの一冊でまるわかり', 1);
