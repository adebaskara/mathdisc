drop table "artist" cascade constraints;
drop table "category" cascade constraints;
drop table "categoryPenalty" cascade constraints;
drop table "disc" cascade constraints;
drop table "discPrice" cascade constraints;
drop table "event" cascade constraints;
drop table "genre" cascade constraints;
drop table "item" cascade constraints;
drop table "movie" cascade constraints;
drop table "movieArtist" cascade constraints;
drop table "movieGenre" cascade constraints;
drop table "password" cascade constraints;
drop table "penalty" cascade constraints;
drop table "problem" cascade constraints;
drop table "transaction" cascade constraints;
drop table "user" cascade constraints;
drop table "log" cascade constraints;

drop sequence "artistID";
drop sequence "categoryID";
drop sequence "categoryPenaltyID";
drop sequence "discID";
drop sequence "eventID";
drop sequence "genreID";
drop sequence "movieID";
drop sequence "itemID";
drop sequence "penaltyID";
drop sequence "problemID";
drop sequence "transactionID";
drop sequence "userID";
drop sequence "logID";

create table "artist"  (
   "artistID"             INTEGER                         not null,
   "artistName"           VARCHAR(100)                    not null,
   "artistSex"            CHAR                            not null,
   "artistRole"           CHAR                            not null,
   constraint PK_ARTIST primary key ("artistID")
);

CREATE sequence "artistID";

CREATE OR REPLACE TRIGGER "artistID" 
BEFORE INSERT ON "artist" 
FOR EACH ROW

BEGIN
  SELECT "artistID".NEXTVAL
  INTO   :new."artistID"
  FROM   dual;
END;
/

create table "category"  (
   "categoryID"           INTEGER                         not null,
   "categoryName"         VARCHAR(50)                     not null,
   "categoryPrice"        INTEGER                         not null,
   constraint PK_CATEGORY primary key ("categoryID")
);

CREATE sequence "categoryID";

CREATE OR REPLACE TRIGGER "categoryID" 
BEFORE INSERT ON "category" 
FOR EACH ROW

BEGIN
  SELECT "categoryID".NEXTVAL
  INTO   :new."categoryID"
  FROM   dual;
END;
/

create table "disc"  (
   "discID"               INTEGER                         not null,
   "discType"             CHAR                            not null,
   "discStatus"           CHAR                            not null,
   "discTotal"            INTEGER                         not null,
   "categoryID"           INTEGER                         not null,
   "movieID"              INTEGER                         not null,
   constraint PK_DISC primary key ("discID")
);

CREATE sequence "discID";

CREATE OR REPLACE TRIGGER "discID" 
BEFORE INSERT ON "disc" 
FOR EACH ROW

BEGIN
  SELECT "discID".NEXTVAL
  INTO   :new."discID"
  FROM   dual;
END;
/

create table "discPrice"  (
   "discType"             CHAR                            not null,
   "priceMultiplier"      NUMERIC(4, 2)                   not null,
   constraint PK_DISCPRICE primary key ("discType")
);

create table "event"  (
   "eventID"              INTEGER                         not null,
   "eventName"            VARCHAR(100)                    not null,
   "eventDescription"     VARCHAR(300),
   "eventStartDate"       DATE                            not null,
   "eventEndDate"         DATE                            not null,
   "eventDiscount"        INTEGER                         not null,
   constraint PK_EVENT primary key ("eventID")
);

CREATE sequence "eventID";

CREATE OR REPLACE TRIGGER "eventID" 
BEFORE INSERT ON "event" 
FOR EACH ROW

BEGIN
  SELECT "eventID".NEXTVAL
  INTO   :new."eventID"
  FROM   dual;
END;
/

create table "genre"  (
   "genreID"              INTEGER                         not null,
   "genreName"            VARCHAR(50)                     not null,
   "genreDescription"     VARCHAR(300),
   constraint PK_GENRE primary key ("genreID")
);

CREATE sequence "genreID";

CREATE OR REPLACE TRIGGER "genreID" 
BEFORE INSERT ON "genre" 
FOR EACH ROW

BEGIN
  SELECT "genreID".NEXTVAL
  INTO   :new."genreID"
  FROM   dual;
END;
/

create table "item"  (
   "itemID"               INTEGER                         not null,
   "transactionID"        INTEGER,
   "discID"               INTEGER                         not null,
   "mustReturnTime"       DATE                        not null,
   "returnTime"           DATE,
   "itemPrice"            INTEGER                         not null,
   constraint PK_ITEM primary key ("itemID")
);

CREATE sequence "itemID";

CREATE OR REPLACE TRIGGER "itemID" 
BEFORE INSERT ON "item" 
FOR EACH ROW

BEGIN
  SELECT "itemID".NEXTVAL
  INTO   :new."itemID"
  FROM   dual;
END;
/

create table "movie"  (
   "movieID"              INTEGER                         not null,
   "movieTitle"           VARCHAR(200)                    not null,
   "movieReleaseDate"     DATE                            not null,
   "movieSynopsis"        VARCHAR(1024),
   "movieCoverURL"        VARCHAR(200),
   "movieRating"          INTEGER,
   constraint PK_MOVIE primary key ("movieID")
);

CREATE sequence "movieID";

CREATE OR REPLACE TRIGGER "movieID" 
BEFORE INSERT ON "movie" 
FOR EACH ROW

BEGIN
  SELECT "movieID".NEXTVAL
  INTO   :new."movieID"
  FROM   dual;
END;
/

create table "movieArtist"  (
   "movieID"              INTEGER                         not null,
   "artistID"             INTEGER                         not null,
   constraint PK_MOVIEARTIST primary key ("movieID", "artistID")
);

create table "movieGenre"  (
   "movieID"              INTEGER                         not null,
   "genreID"              INTEGER                         not null,
   constraint PK_MOVIEGENRE primary key ("movieID", "genreID")
);

create table "password"  (
   "userID"               INTEGER                         not null,
   "password"             VARCHAR(32)                     not null,
   constraint PK_PASSWORD primary key ("userID")
);

create table "penalty"  (
   "penaltyID"            INTEGER                         not null,
   "penaltyName"          VARCHAR(50)                     not null,
   "penaltyFine"          INTEGER                         not null,
   constraint PK_PENALTY primary key ("penaltyID")
);

CREATE sequence "penaltyID";

CREATE OR REPLACE TRIGGER "penaltyID" 
BEFORE INSERT ON "penalty" 
FOR EACH ROW

BEGIN
  SELECT "penaltyID".NEXTVAL
  INTO   :new."penaltyID"
  FROM   dual;
END;
/

create table "categoryPenalty"  (
   "categoryPenaltyID"    INTEGER                         not null,
   "categoryID"           INTEGER                         not null,
   "penaltyID"            INTEGER                         not null,
   constraint PK_CATEGORYPENALTY primary key ("categoryPenaltyID")
);

CREATE sequence "categoryPenaltyID";

CREATE OR REPLACE TRIGGER "categoryPenaltyID" 
BEFORE INSERT ON "categoryPenalty" 
FOR EACH ROW

BEGIN
  SELECT "categoryPenaltyID".NEXTVAL
  INTO   :new."categoryPenaltyID"
  FROM   dual;
END;
/

create table "problem"  (
   "problemID"            INTEGER                         not null,
   "problemName"          VARCHAR(100)                    not null,
   "problemDescription"   VARCHAR(300),
   "userID"               INTEGER                         not null,
   "transactionID"        INTEGER                         not null,
   constraint PK_PROBLEM primary key ("problemID")
);

CREATE sequence "problemID";

CREATE OR REPLACE TRIGGER "problemID" 
BEFORE INSERT ON "problem" 
FOR EACH ROW

BEGIN
  SELECT "problemID".NEXTVAL
  INTO   :new."problemID"
  FROM   dual;
END;
/

create table "transaction"  (
   "transactionID"        INTEGER                         not null,
   "transactionDate"      DATE                            not null,
   "cashierID"            INTEGER                         not null,
   "customerID"           INTEGER                         not null,
   "eventID"              INTEGER                         not null,
   constraint PK_TRANSACTION primary key ("transactionID")
);

CREATE sequence "transactionID";

CREATE OR REPLACE TRIGGER "transactionID" 
BEFORE INSERT ON "transaction" 
FOR EACH ROW

BEGIN
  SELECT "transactionID".NEXTVAL
  INTO   :new."transactionID"
  FROM   dual;
END;
/

create table "user"  (
   "userID"               INTEGER                         not null,
   "fullname"             VARCHAR(100)                    not null,
   "idCardNumber"         VARCHAR(50)                     not null,
   "birthDate"            DATE                            not null,
   "address"              VARCHAR(200)                    not null,
   "phoneNumber"          VARCHAR(15)                     not null,
   "sex"                  CHAR                            not null,
   "accessLevel"          CHAR                            not null,
   "email"                VARCHAR(100),
   constraint PK_USER primary key ("userID")
);

CREATE sequence "userID";

CREATE OR REPLACE TRIGGER "userID" 
BEFORE INSERT ON "user" 
FOR EACH ROW

BEGIN
  SELECT "userID".NEXTVAL
  INTO   :new."userID"
  FROM   dual;
END;
/

create index FK_CATEGORYPENALTY_CATEGORYID ON "categoryPenalty" ("categoryID");

alter table "categoryPenalty"
   add constraint FK_CATEGORY_REFERENCE_CATEGORY foreign key ("categoryID")
      references "category" ("categoryID");

create index FK_CATEGORYPENALTY_PENALTYID ON  "categoryPenalty"  ("penaltyID");
	  
alter table "categoryPenalty"
   add constraint FK_CATEGORY_REFERENCE_PENALTY foreign key ("penaltyID")
      references "penalty" ("penaltyID");

create unique index FK_DISC_CATEGORYID ON "disc" ("categoryID");

alter table "disc"
   add constraint FK_DISC_REFERENCE_CATEGORY foreign key ("categoryID")
      references "category" ("categoryID");

alter table "disc"
   add constraint FK_DISC_REFERENCE_DISCPRIC foreign key ("discType")
      references "discPrice" ("discType");
	  
create unique index FK_DISC_MOVIEID ON "disc" ("movieID");
	  
alter table "disc"
   add constraint FK_DISC_REFERENCE_MOVIE foreign key ("movieID")
      references "movie" ("movieID");

create unique index FK_ITEM_TRANSACTIONID ON "item" ("transactionID");
	  
alter table "item"
   add constraint FK_ITEM_REFERENCE_TRANSACT foreign key ("transactionID")
      references "transaction" ("transactionID");

create unique index FK_ITEM_DISCID ON "item" ("discID");
	  
alter table "item"
   add constraint FK_ITEM_REFERENCE_DISC foreign key ("discID")
      references "disc" ("discID");

create unique index FK_MOVIEARTIST_MOVIEID ON "movieArtist" ("movieID");
	  
alter table "movieArtist"
   add constraint FK_MOVIEART_REFERENCE_MOVIE foreign key ("movieID")
      references "movie" ("movieID");

create unique index FK_MOVIEARTIST_ARTISTID ON "movieArtist" ("artistID");
	  
alter table "movieArtist"
   add constraint FK_MOVIEART_REFERENCE_ARTIST foreign key ("artistID")
      references "artist" ("artistID");

create unique index FK_MOVIEGENRE_MOVIEID ON "movieGenre" ("movieID");
	  
alter table "movieGenre"
   add constraint FK_MOVIEGEN_REFERENCE_MOVIE foreign key ("movieID")
      references "movie" ("movieID");

create unique index FK_MOVIEGENRE_GENREID ON "movieGenre" ("genreID");
	  
alter table "movieGenre"
   add constraint FK_MOVIEGEN_REFERENCE_GENRE foreign key ("genreID")
      references "genre" ("genreID");
	  
alter table "password"
   add constraint FK_PASSWORD_REFERENCE_USER foreign key ("userID")
      references "user" ("userID");

create unique index FK_PROBLEM_USERID ON "problem" ("userID");
	  
alter table "problem"
   add constraint FK_PROBLEM_REFERENCE_USER foreign key ("userID")
      references "user" ("userID");

create unique index FK_PROBLEM_TRANSACTIONID ON "problem" ("transactionID");
	  
alter table "problem"
   add constraint FK_PROBLEM_REFERENCE_TRANSACT foreign key ("transactionID")
      references "transaction" ("transactionID");

create unique index FK_TRANSACTION_CASHIERID ON "transaction" ("cashierID");
	  
alter table "transaction"
   add constraint FK_TRANS_REF_USER_CASHIER foreign key ("cashierID")
      references "user" ("userID");

create unique index FK_TRANSACTION_CUSTOMERID ON "transaction" ("customerID");
	  
alter table "transaction"
   add constraint FK_TRANS_REF_USER_CUSTOMER foreign key ("customerID")
      references "user" ("userID");

create unique index FK_TRANSACTION_EVENTID ON "transaction" ("eventID");
	  
alter table "transaction"
   add constraint FK_TRANSACT_REFERENCE_EVENT foreign key ("eventID")
      references "event" ("eventID");

	  
create table "imdb" (
	"imdbID" varchar(12) primary key,
	"title" varchar(400), 
	"year" varchar(4), 
	"rated" varchar(20), 
	"released" varchar(20), 
	"runtime" varchar(20), 
	"genre" varchar(200), 
	"director" varchar(300), 
	"writer" varchar(300), 
	"actors" varchar(300), 
	"plot" varchar(2000), 
	"poster" varchar(400), 
	"imdbRating" number(4,2), 
	"imdbVotes" varchar(15), 
	"type" varchar(20), 
	"response" varchar(20)
);

create table "log" (
	"logID" integer not null primary key
);

CREATE sequence "logID";

CREATE OR REPLACE TRIGGER "logID" 
BEFORE INSERT ON "log" 
FOR EACH ROW

BEGIN
  SELECT "logID".NEXTVAL
  INTO   :new."logID"
  FROM   dual;
END;
/

INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Ifan', 'M', 'D');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Iqbal', 'M', 'W');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Ifan Iqbal', 'M', 'S');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Iqbal Ifan', 'M', 'S');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Ade', 'M', 'D');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Baskara', 'M', 'W');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Ade Baskara', 'M', 'S');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Baskara Ade', 'M', 'S');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Rossa', 'F', 'D');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Rossalina', 'F', 'W');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Rossa Lina Susanti', 'F', 'S');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Susan Puteri', 'F', 'S');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Jenny Sutrisno', 'F', 'S');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Siti Maimunah', 'F', 'S');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Jamaludin Akhirat', 'M', 'S');
INSERT INTO "bdl"."artist" ("artistName", "artistSex", "artistRole") VALUES ('Putra Andro', 'M', 'S');


INSERT INTO "bdl"."penalty" ("penaltyName", "penaltyFine") VALUES ('Rusak', '10');
INSERT INTO "bdl"."penalty" ("penaltyName", "penaltyFine") VALUES ('Lecet', '3');
INSERT INTO "bdl"."penalty" ("penaltyName", "penaltyFine") VALUES ('Hilang', '10');
INSERT INTO "bdl"."penalty" ("penaltyName", "penaltyFine") VALUES ('Rusak New Release', '15');
INSERT INTO "bdl"."penalty" ("penaltyName", "penaltyFine") VALUES ('Lecet New Release', '10');
INSERT INTO "bdl"."penalty" ("penaltyName", "penaltyFine") VALUES ('Hilang New Release', '15');


INSERT INTO "bdl"."category" ("categoryName", "categoryPrice") VALUES ('New Release', '6000');
INSERT INTO "bdl"."category" ("categoryName", "categoryPrice") VALUES ('Family', '4000');
INSERT INTO "bdl"."category" ("categoryName", "categoryPrice") VALUES ('Action', '4000');
INSERT INTO "bdl"."category" ("categoryName", "categoryPrice") VALUES ('Cartoon', '3500');
INSERT INTO "bdl"."category" ("categoryName", "categoryPrice") VALUES ('West', '4000');
INSERT INTO "bdl"."category" ("categoryName", "categoryPrice") VALUES ('Asia', '4000');


UPDATE "bdl"."penalty" SET "penaltyName" = 'Rusak Baru' WHERE "penaltyID" = 4;
UPDATE "bdl"."penalty" SET "penaltyName" = 'Lecet Baru' WHERE "penaltyID" = 5;
UPDATE "bdl"."penalty" SET "penaltyName" = 'Hilang Baru' WHERE "penaltyID" = 6;

INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('1', '4');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('1', '5');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('1', '6');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('2', '1');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('2', '2');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('2', '3');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('3', '1');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('3', '2');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('3', '3');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('4', '1');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('4', '2');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('4', '3');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('5', '1');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('5', '2');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('5', '3');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('6', '1');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('6', '2');
INSERT INTO "bdl"."categoryPenalty" ("categoryID", "penaltyID") VALUES ('6', '3');

INSERT INTO "bdl"."discPrice" ("discType", "priceMultiplier") VALUES ('V', '1');
INSERT INTO "bdl"."discPrice" ("discType", "priceMultiplier") VALUES ('D', '1.5');
INSERT INTO "bdl"."discPrice" ("discType", "priceMultiplier") VALUES ('B', '3');

INSERT INTO "bdl"."event" ("eventName", "eventDescription", "eventStartDate", "eventEndDate", "eventDiscount") VALUES ('Tahun Baru 2014', 'Diskon Tahun Baru 2014', TO_DATE('30-DEC-13', 'DD-MON-RR'), TO_DATE('01-JAN-14', 'DD-MON-RR'), '30');
INSERT INTO "bdl"."event" ("eventName", "eventDescription", "eventStartDate", "eventEndDate", "eventDiscount") VALUES ('Hari Kemerdekaan RI 2014', 'Diskon Hari Kemerdekaan RI 2014', TO_DATE('17-AUG-14', 'DD-MON-RR'), TO_DATE('17-AUG-14', 'DD-MON-RR'), '30');


INSERT INTO "bdl"."movie" ("movieTitle", "movieReleaseDate", "movieRating") VALUES ('Legenda Programmer TC', TO_DATE('01-NOV-2013', 'DD-MON-RR'), '90');
INSERT INTO "bdl"."movie" ("movieTitle", "movieReleaseDate", "movieRating") VALUES ('Ada Apa Dengan TCinta', TO_DATE('02-NOV-2013', 'DD-MON-RR'), '80');
INSERT INTO "bdl"."movie" ("movieTitle", "movieReleaseDate", "movieRating") VALUES ('Misteri Lantai 4', TO_DATE('13-NOV-2013', 'DD-MON-RR'), '95');
INSERT INTO "bdl"."movie" ("movieTitle", "movieReleaseDate", "movieRating") VALUES ('Tutorial Basis Data', TO_DATE('30-AUG-2013', 'DD-MON-RR'), '50');


INSERT INTO "bdl"."genre" ("genreName", "genreDescription") VALUES ('Misteri', 'Serem ngageti');
INSERT INTO "bdl"."genre" ("genreName", "genreDescription") VALUES ('Tutorial', 'Penuh edukasi');
INSERT INTO "bdl"."genre" ("genreName", "genreDescription") VALUES ('Aksi', 'Seru sekali');


