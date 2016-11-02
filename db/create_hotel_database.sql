CREATE DATABASE hotels_booking_db;

use hotels_booking_db;                           

CREATE TABLE IF NOT EXISTS roles
(
  id int auto_increment not null primary key,
  role varchar(10),
  description varchar(100),
  sortOrder int,
  active char(1),
  createdDate datetime,
  updatedDate datetime
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;

CREATE TABLE IF NOT EXISTS positions
(
  id int auto_increment not null primary key,
  position varchar(100),
  description varchar(256),
  sortOrder int,
  active char(1),
  createdDate datetime,
  updatedDate datetime
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS users
(
  id int auto_increment not null primary key,
  email varchar(100),
  firstname varchar(100),
  lastname varchar(100),
  addressline1 varchar(100),
  addressline2 varchar(100),
  city varchar(100),
  state varchar(50),
  zipcode varchar(11),
  country varchar(100),	
  mimetype varchar(1),
  roleid int,
  positionID int,
  password varchar(70),
  passwordhash varchar(256),
  homePhone varchar(50),
  cellPhone varchar(50),
  gender char(1),
  createdDate datetime,
  updatedDate datetime,
  index (roleid),
  index (positionID),
  FOREIGN KEY (roleid) REFERENCES roles(id),
  FOREIGN KEY (positionID) REFERENCES positions(id)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS hotels
(
   id int auto_increment not null primary key,
   code varchar(50),
   name varchar(100),
   address varchar(256),
   address2 varchar(256),
   city varchar(100),
   state varchar(50),
   zipcode varchar(20),
   mainPhone varchar(30),
   secondPhone varchar(30),
   tollFree varchar(30),
   fax varchar(30),
   mailingAddress varchar(256),
   email varchar(100),
   websiteAddress varchar(100),
   logoFlePath varchar(150),
   createdDate datetime,
   updatedDate datetime
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS reservation_agents
(
   id int auto_increment not null primary key,
   staffID int,
   type varchar(100),
   createdDate datetime,
   updatedDate datetime,
   index (staffID),
   FOREIGN KEY (staffID) REFERENCES users(id)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS booking_status
(
   id int auto_increment not null primary key,
   status varchar(50),
   description varchar(256),
   sortOrder int,
   active char(1),
   createdDate datetime,
   updatedDate datetime
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin; 

CREATE TABLE IF NOT EXISTS bookings
(
   id int auto_increment not null primary key,
   hotelID int,
   customerID int,
   reservationAgentID int,
   dateFrom datetime,
   dateTo datetime,
   roomCount int,
   bookingStatusID int,
   createdDate datetime,
   updatedDate datetime,
   index (hotelID),
   index (customerID),
   index (reservationAgentID),
   index (bookingStatusID),
   FOREIGN KEY (hotelID) REFERENCES hotels(id),
   FOREIGN KEY (customerID) REFERENCES users(id),
   FOREIGN KEY (reservationAgentID) REFERENCES reservation_agents(id),
   FOREIGN KEY (bookingStatusID) REFERENCES booking_status(id)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS rooms_type
(
   id int auto_increment not null primary key,
   type varchar(100),
   description varchar(256),
   sortOrder int,
   active char(1),
   createdDate datetime,
   updatedDate datetime
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS beds_type
(
   id int auto_increment not null primary key,
   type varchar(100), 
   description varchar(256),
   sortOrder int,
   active char(1),
   createdDate datetime,
   updatedDate datetime
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS rooms_status
(
   id int auto_increment not null primary key,
   status varchar(100),
   description varchar(256),
   sortOrder int,
   active char(1),
   createdDate datetime,
   updatedDate datetime
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS rooms
(
   id int auto_increment not null primary key,
   hotelID int,
   floorNumber varchar(6),
   roomTypeID int,
   bedTypeID int,
   bedsCount int,
   roomNumber varchar(6),
   roomStatusID int,
   createdDate datetime,
   updatedDate datetime,
   index (hotelID),
   index (roomTypeID),
   index (bedTypeID),
   index (roomStatusID),
   FOREIGN KEY (hotelID) REFERENCES hotels(id),
   FOREIGN KEY (roomTypeID) REFERENCES rooms_type(id),
   FOREIGN KEY (bedTypeID) REFERENCES beds_type(id),
   FOREIGN KEY (roomStatusID) REFERENCES rooms_status(id)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS payments_type
(
    id int auto_increment not null primary key,
    type varchar(100),
    description varchar(256),
    sortOrder int,
    active char(1),
    createdDate datetime,
    updatedDate datetime
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS payments_status
(
   id int auto_increment not null primary key,
   status varchar(100),
   description varchar(256),
   sortOrder int,
   active char(1),
   createdDate datetime,
   updatedDate datetime
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS rates_type
(
   id int auto_increment not null primary key,
   type varchar(100),
   description varchar(256),
   sortOrder int,
   active char(1),
   createdDate datetime,
   updatedDate datetime
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS payments
(
   id int auto_increment not null primary key,
   payment decimal(13,4),
   paymentDate datetime, 
   paymentTypeID int,
   paymentStatusID int,
   roomID int,
   createdDate datetime,
   updatedDate datetime,
   index (paymentTypeID),
   index (paymentStatusID),
   index (roomID),
   FOREIGN KEY (paymentTypeID) REFERENCES payments_type(id),
   FOREIGN KEY (paymentStatusID) REFERENCES payments_status(id),
   FOREIGN KEY (roomID) REFERENCES rooms(id)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS rates
(
   id int auto_increment not null primary key,
   rate decimal(13,4),
   roomID int,
   rateDate datetime,
   fromDate datetime,
   toDate datetime,
   rateTypeID int,
   createdDate datetime,
   updatedDate datetime,
   index (roomID),
   index (rateTypeID),
   FOREIGN KEY (roomID) REFERENCES rooms(id),
   FOREIGN KEY (rateTypeID) REFERENCES rates_type(id)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS staffs_rooms
(
   id int auto_increment not null primary key,
   roomID int,
   staffID int,
   workDate datetime,
   createdDate datetime,
   updatedDate datetime,
   index (roomID),
   index (staffID),
   FOREIGN KEY (roomID) REFERENCES rooms(id),
   FOREIGN KEY (staffID) REFERENCES users(id)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;















