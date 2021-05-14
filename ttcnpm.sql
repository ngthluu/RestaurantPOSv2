create table `Customers` (
    `id` int primary key not null auto_increment,
    `phone` varchar(10) not null unique,
    `password` varchar(64) not null,
    `email` varchar(256) not null unique,
    `name` varchar(256) default null,
    `avatar` text default null,
    `gender` int(1) default 0,
    `birthday` date default null,
    `address` text null default null,
    `status` int(1) default 0,
    `create_time` datetime default current_timestamp()
);

create table `Staffs` (
    `id` int primary key not null auto_increment,
    `phone` varchar(10) not null unique,
    `password` varchar(64) not null,
    `email` varchar(256) not null unique,
    `name` varchar(256) default null,
    `avatar` text default null,
    `gender` int(1) default 0,
    `birthday` date default null,
    `address` text null default null,
    `branch` int not null,
    `role` varchar(10) not null,
    `create_time` datetime default current_timestamp(),
    `create_by` int default 1
);

create table `Branches` (
    `id` int primary key not null auto_increment,
    `name` varchar(256) not null,
    `address` text not null,
    `manager` int not null  
);

create table `Tables` (
    `id` int primary key not null auto_increment,
    `branch` int not null,
    `name` varchar(256) not null
);

create table `Menu` (
    `id` int primary key not null auto_increment,
    `name` varchar(256) not null,
    `branch` int not null,
    `description` text null default null,
    `price` int not null,
    `status` int default 1
);

create table `MenuImages` (
    `id` int primary key not null auto_increment,
    `menu` int not null,
    `image` text not null,
    `is_avatar` int(1) default 0
);

create table `MenuRatings` (
    `id` int primary key not null auto_increment,
    `menu` int not null,
    `customer` int not null,
    `rating` int(1) default 5,
    `comment` text null default null,
    `comment_time` datetime default current_timestamp()
);

create table `Orders` (
    `id` int primary key not null auto_increment,
    `order_code` varchar(30) not null unique,
    `order_time` datetime default current_timestamp(),
    `customer` int not null,
    `branch` int not null,
    `table` int not null,
    `status` int(1) default 0
    
);

create table `OrderDetails` (
    `id` int primary key not null auto_increment,
    `order` int not null,
    `menu` int not null,
    `quantity` int default 1
);

alter table `Staffs` add foreign key (`branch`) references `Branches`(`id`);
alter table `Staffs` add foreign key (`create_by`) references `Staffs`(`id`);
alter table `Branches` add foreign key (`manager`) references `Staffs`(`id`);
alter table `Tables` add foreign key (`branch`) references `Branches`(`id`);
alter table `Menu` add foreign key (`branch`) references `Branches`(`id`);
alter table `MenuImages` add foreign key (`menu`) references `Menu`(`id`) on delete cascade;
alter table `MenuRatings` add foreign key (`customer`) references `Customers`(`id`) on delete cascade;
alter table `MenuRatings` add foreign key (`menu`) references `Menu`(`id`) on delete cascade;
alter table `Orders` add foreign key (`customer`) references `Customers`(`id`);
alter table `Orders` add foreign key (`branch`) references `Branches`(`id`);
alter table `Orders` add foreign key (`table`) references `Tables`(`id`);
alter table `OrderDetails` add foreign key (`order`) references `Orders`(`id`) on delete cascade;
alter table `OrderDetails` add foreign key (`menu`) references `Menu`(`id`);