drop table if exists book;
drop table if exists book_category;
drop table if exists user;
create table if not exists user (
  email nvarchar(60) primary key comment 'primary key, used as username',
  password nvarchar(64) not null comment 'password, at least 6 char long stored with sha-256',
  name nvarchar(60) not null comment 'name of the user'
) comment 'Users of the application for the second web programming submission';

insert into user (email, password, name) value ('admin@admin.com', 'admin', 'admin');

drop table if exists book_category;
create table if not exists book_category (
  id int(10) primary key not null auto_increment comment 'primary key',
  name nvarchar(60) unique not null comment 'name of the category'
) comment 'Categories of books';

insert into book_category (name) values ('fantasy');

drop table if exists book;
create table if not exists book (
  id int(10) primary key not null auto_increment comment 'primary key',
  owner nvarchar(60) not null comment 'owner of the book',
  author nvarchar(60) not null comment 'author of the book',
  title nvarchar(60) not null comment 'title of the book',
  page int(10) comment 'current page',
  category int(10) comment 'category of the book',
  isbn int(13) comment 'isbn number',
  is_read boolean comment 'is the book read by the user or not',
  foreign key (owner) references user(email),
  foreign key (category) references book_category(id),
  unique (owner, author, title) comment 'one owner can only own a book once'
) comment 'Books for the library appliations';

insert into book (owner, author, title, category)
  value ('admin@admin.com', 'jesus', 'bible', (select id from book_category where name = 'fantasy'));
insert into book (owner, author, title, category)
  value ('admin@admin.com', 'J. R. R. Tolkien', 'Lord of the rings', (select id from book_category where name = 'fantasy'));

commit;