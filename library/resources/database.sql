drop table if exists book;
drop table if exists category;
drop table if exists user;
create table if not exists user (
  id int(10) primary key not null auto_increment comment 'primary key, needed for proper database control',
  email nvarchar(60) unique key comment 'unique key, email, used as username',
  password nvarchar(64) not null comment 'password, at least 6 char long stored with sha-256',
  name nvarchar(60) not null comment 'name of the user'
) comment 'Users of the application for the second web programming submission';

insert into user (email, password, name) value ('admin@admin.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin');
insert into user (email, password, name) value ('adminbak@admin.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'adminbak');

drop table if exists category;
create table if not exists category (
  id int(10) primary key not null auto_increment comment 'primary key',
  owner int(10) not null comment 'owner of the category',
  name nvarchar(60) not null comment 'name of the category',
  foreign key (owner) references user(id),
  unique (owner, name) comment 'one owner can only have one category once'
) comment 'Categories of books';

insert into category (owner, name) values ((select id from user where email = 'admin@admin.com'), 'Action');
insert into category (owner, name) values ((select id from user where email = 'admin@admin.com'), 'Fantasy');
insert into category (owner, name) values ((select id from user where email = 'admin@admin.com'), 'Adventure');

drop table if exists book;
create table if not exists book (
  id int(10) primary key not null auto_increment comment 'primary key',
  owner int(10) not null comment 'owner of the book',
  author nvarchar(60) not null comment 'author of the book',
  title nvarchar(60) not null comment 'title of the book',
  page int(10) comment 'current page',
  category int(10) comment 'category of the book',
  isbn int(13) comment 'isbn number',
  is_read boolean comment 'is the book read by the user or not',
  foreign key (owner) references user(id),
  foreign key (category) references category(id),
  unique (owner, author, title) comment 'one owner can only own a book once'
) comment 'Books for the library appliations';

insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'Jesus', 'The Bible', (select id from category where name = 'Fantasy'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'J. R. R. Tolkien', 'Lord of the rings', (select id from category where name = 'Fantasy'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'aaaa', 'aaaa', (select id from category where name = 'Aantasy'));
insert into book (owner, author, title, category) value ((select id from user where email = 'adminbak@admin.com'), 'aabb', 'aabb', (select id from category where name = 'Adventure'));
insert into book (owner, author, title, category) value ((select id from user where email = 'adminbak@admin.com'), 'aabc', 'aabc', (select id from category where name = 'Adventure'));
insert into book (owner, author, title, category) value ((select id from user where email = 'adminbak@admin.com'), 'aabd', 'aabd', (select id from category where name = 'Action'));
insert into book (owner, author, title, category) value ((select id from user where email = 'adminbak@admin.com'), 'aabe', 'aabe', (select id from category where name = 'Fantasy'));
insert into book (owner, author, title, category) value ((select id from user where email = 'adminbak@admin.com'), 'aabf', 'aabf', (select id from category where name = 'Adventure'));
insert into book (owner, author, title, category) value ((select id from user where email = 'adminbak@admin.com'), 'aabg', 'aabg', (select id from category where name = 'Fantasy'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'aabh', 'aabh', (select id from category where name = 'Action'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'aabi', 'aabi', (select id from category where name = 'Fantasy'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'aabj', 'aabj', (select id from category where name = 'Action'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'aabk', 'aabk', (select id from category where name = 'Fantasy'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'aabl', 'aabl', (select id from category where name = 'Fantasy'));
insert into book (owner, author, title, category) value ((select id from user where email = 'adminbak@admin.com'), 'aabm', 'aabm', (select id from category where name = 'Adventure'));
insert into book (owner, author, title, category) value ((select id from user where email = 'adminbak@admin.com'), 'baaa', 'baaa', (select id from category where name = 'Fantasy'));
insert into book (owner, author, title, category) value ((select id from user where email = 'adminbak@admin.com'), 'babb', 'babb', (select id from category where name = 'Fantasy'));
insert into book (owner, author, title, category) value ((select id from user where email = 'adminbak@admin.com'), 'babc', 'babc', (select id from category where name = 'Fantasy'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'babd', 'babd', (select id from category where name = 'Adventure'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'babe', 'babe', (select id from category where name = 'Fantasy'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'babf', 'babf', (select id from category where name = 'Action'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'babg', 'babg', (select id from category where name = 'Fantasy'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'babh', 'babh', (select id from category where name = 'Adventure'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'babi', 'babi', (select id from category where name = 'Adventure'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'babj', 'babj', (select id from category where name = 'Action'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'babk', 'babk', (select id from category where name = 'Action'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'babl', 'babl', (select id from category where name = 'Fantasy'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'babm', 'babm', (select id from category where name = 'Adventure'));
insert into book (owner, author, title, category) value ((select id from user where email = 'admin@admin.com'), 'babn', 'babn', (select id from category where name = 'Action'));

commit;
