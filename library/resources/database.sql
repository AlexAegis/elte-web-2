drop table if exists book;
drop table if exists bookcategory;
drop table if exists user;
create table if not exists user (
  id int(10) primary key not null auto_increment comment 'primary key, needed for proper database control',
  email nvarchar(60) unique key comment 'unique key, email, used as username',
  password nvarchar(64) not null comment 'password, at least 6 char long stored with sha-256',
  name nvarchar(60) not null comment 'name of the user'
) comment 'Users of the application for the second web programming submission';

insert into user (email, password, name) value ('admin@admin.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin');

drop table if exists bookcategory;
create table if not exists bookcategory (
  id int(10) primary key not null auto_increment comment 'primary key',
  name nvarchar(60) unique not null comment 'name of the category'
) comment 'Categories of books';

insert into bookcategory (name) values ('fantasy');

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
  foreign key (category) references bookcategory(id),
  unique (owner, author, title) comment 'one owner can only own a book once'
) comment 'Books for the library appliations';

insert into book (owner, author, title, category)
  value ((select id from user where email = 'admin@admin.com'), 'jesus', 'bible', (select id from bookcategory where name = 'fantasy'));
insert into book (owner, author, title, category)
  value ((select id from user where email = 'admin@admin.com'), 'J. R. R. Tolkien', 'Lord of the rings', (select id from bookcategory where name = 'fantasy'));

commit;
