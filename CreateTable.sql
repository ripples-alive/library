drop table Power;
create table Power
(
    Level int not null,
    PName varchar(10),
    CBN int, #能借书数
    TLW int, #借阅期限权值
    Cnt int,
    primary key (Level)
);

drop table User;
create table User
(
    SID char(5) not null,
    Account varchar(20) not null,
    Password char(32) not null,
    Salt datetime not null,
    TitleDate datetime, #封号截止时间
    SName varchar(8),
    EmailAdd varchar(30),
    BBN int, #已借书数
    Level int not null,
    primary key (SID),
    foreign key (Level) references Power(Level)
);

drop table Book;
create table Book
(
    BID varchar(18) not null,
    BName varchar(30),
    Author varchar(30),
    Publisher varchar(30),
    PubTime date,
    Type varchar(20),
    Location char(10),
    SumNum int,
    BroNum int,
    CBTime int, #基础借阅天数
    Cover varchar(30),
    primary key (BID)
);

#假设一个人不会在同一时间借多本相同的书
drop table UBB;
create table UBB
(
    SID char(5) not null,
    BID varchar(18) not null,
    Renew int not null default 0,
    Deadline date,
    primary key (SID, BID),
    foreign key (SID) references User(SID),
    foreign key (BID) references Book(BID)
);

drop table UCB;
create table UCB
(
    SID char(5) not null,
    BID varchar(18) not null,
    Time datetime not null,
    Content varchar(512),
    primary key (SID, BID, Time),
    foreign key (SID) references User(SID),
    foreign key (BID) references Book(BID)
);

#一天内多次借还同一本书只记一次记录
drop table History;
create table History
(
    SID char(5) not null,
    BID varchar(18) not null,
    LentTime date not null,
    ReturnTime date,
    primary key (SID, BID, LentTime),
    foreign key (SID) references User(SID),
    foreign key (BID) references Book(BID)
);