drop database `ttcnpm`; 
create database `ttcnpm`;
use `ttcnpm`;

create table `Customers` (
    `id` int primary key not null auto_increment,
    `phone` varchar(10) not null unique,
    `password` varchar(64) not null,
    `email` varchar(256) not null unique,
    `name` varchar(256) default null,
    `avatar` text default null,
    `gender` int(1) default 0,
    `birthday` date default null,
    `address` text,
    `status` int(1) default 0,
    `create_time` datetime default current_timestamp()
);

create table `Staffs` (
    `id` int primary key not null auto_increment,
    `phone` varchar(10) not null unique,
    `password` varchar(64) not null,
    `email` varchar(256) not null unique,
    `name` varchar(256) default null,
    `idc` varchar(20) not null unique,
    `avatar` text default null,
    `gender` int(1) default 0,
    `birthday` date default null,
    `address` text,
    `branch` int,
    `role` varchar(10) not null,
    `create_time` datetime default current_timestamp(),
    `create_by` int,
    `status` int default 0
);

create table `Branches` (
    `id` int primary key not null auto_increment,
    `name` varchar(256) not null,
    `address` text not null,
    `tables_num` int not null,
    `manager` int,
    `status` int default 0
);

create table `Menu` (
    `id` int primary key not null auto_increment,
    `image` text default null,
    `name` varchar(256) not null,
    `branch` int,
    `description` text,
    `price` int not null,
    `status` int default 0,
    `status_date` int default 0
);

create table `MenuRatings` (
    `id` int primary key not null auto_increment,
    `menu` int not null,
    `customer` int not null,
    `rating` int(1) default 5,
    `comment` text,
    `comment_time` datetime default current_timestamp()
);

create table `Orders` (
    `id` int primary key not null auto_increment,
    `order_code` varchar(30) not null unique,
    `order_time` datetime default current_timestamp(),
    `customer` int,
    `branch` int,
    `table` int not null,
    `status` int(1) default 0
    
);

create table `OrderDetails` (
    `id` int primary key not null auto_increment,
    `order` int not null,
    `menu` int,
    `quantity` int default 1
);

INSERT INTO `branches` (`id`, `name`, `address`, `tables_num`, `manager`, `status`) VALUES
(1, 'Chi nhánh Kon Tum', 'Khối 6 thị trấn Đak Tô, huyện Đak Tô, tỉnh Kon Tum', 15, 2, 1);

INSERT INTO `staffs` (`id`, `phone`, `password`, `email`, `name`, `idc`, `avatar`, `gender`, `birthday`, `address`, `branch`, `role`, `create_time`, `create_by`, `status`) VALUES
(1, '1234567890', 'f657536db476b2dd5cb480c841890e1fad37edcdc3e69cdc12b96a4dec1eb91e', 'admin@pos.v2', 'Super admin', '', NULL, 0, NULL, NULL, NULL, 'admin', '2021-05-18 21:28:38', NULL, 1),
(2, '0383477379', 'f657536db476b2dd5cb480c841890e1fad37edcdc3e69cdc12b96a4dec1eb91e', 'manager180521002@pos.v2', 'John Wick', '233298447', '3ac8ef44d4393d6df1a4bafa9c056dac.jpg', 1, '2000-01-21', NULL, 1, 'manager', '2021-05-18 21:40:27', 1, 1),
(3, '2314121111', 'f657536db476b2dd5cb480c841890e1fad37edcdc3e69cdc12b96a4dec1eb91e', 'chef190521003@pos.v2', 'Gordon Ramsay', '123', NULL, 1, '2021-05-09', NULL, 1, 'chef', '2021-05-19 07:56:16', 1, 1);

alter table `Staffs` add foreign key (`branch`) references `Branches`(`id`) on delete set null;
alter table `Staffs` add foreign key (`create_by`) references `Staffs`(`id`) on delete set null;
alter table `Branches` add foreign key (`manager`) references `Staffs`(`id`) on delete set null;
alter table `Menu` add foreign key (`branch`) references `Branches`(`id`) on delete set null;
alter table `MenuRatings` add foreign key (`customer`) references `Customers`(`id`) on delete cascade;
alter table `MenuRatings` add foreign key (`menu`) references `Menu`(`id`) on delete cascade;
alter table `Orders` add foreign key (`customer`) references `Customers`(`id`) on delete set null;
alter table `Orders` add foreign key (`branch`) references `Branches`(`id`) on delete set null;
alter table `OrderDetails` add foreign key (`order`) references `Orders`(`id`) on delete cascade;
alter table `OrderDetails` add foreign key (`menu`) references `Menu`(`id`) on delete set null;