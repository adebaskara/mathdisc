/* 5 movie paling laris di bulan November 2013 */
select movietitle, total_pinjam from (
  select disc.movieid, movie.movietitle, count(*) as total_pinjam from disc 
	join item on disc.discid = item.discid
    join "transaction" on item.transactionid = "transaction".transactionid
    join movie on disc.movieid = movie.movieid
  where "transaction".transactionDate >= to_date('01-NOV-2013', 'DD-MON-YYYY') and
    "transaction".transactionDate <= to_date('30-NOV-2013', 'DD-MON-YYYY')
  group by disc.movieid, movie.movietitle
  order by total_pinjam desc
) where rownum <= 5;


/* 10 penyewa paling banyak menyewa di tahun 2012 */
select fullname, total_pinjam from (
  select "user".fullname, count(*) as total_pinjam from disc 
	join item on disc.discid = item.discid
    join "transaction" on item.transactionid = "transaction".transactionid
    join "user" on "transaction".customerid = "user".userid
  where to_char("transaction".transactionDate, 'YYYY') = '2012'
  group by "user".fullname
  order by total_pinjam desc
) where rownum <= 10;


/* 7 movie yang paling sering disewa di hari minggu */
select movietitle, total_pinjam from (
  select disc.movieid, movie.movietitle, count(*) as total_pinjam from disc 
	join item on disc.discid = item.discid
    join "transaction" on item.transactionid = "transaction".transactionid
    join movie on disc.movieid = movie.movieid
  where to_char("transaction".transactionDate, 'day') = 'sunday'
  group by disc.movieid, movie.movietitle
  order by total_pinjam desc
) where rownum <= 7;


/* 3 genre yang paling sering disewa di akhir pekan */
select genrename, total_pinjam from (
  select genre.genrename, count(*) as total_pinjam from disc 
    join item on disc.discid = item.discid
    join "transaction" on item.transactionid = "transaction".transactionid
    join movie on disc.movieid = movie.movieid
    join moviegenre on moviegenre.movieid = movie.movieid
    join genre on genre.genreid = moviegenre.genreid
  where to_char("transaction".transactionDate, 'day') in ('saturday', 'sunday')
  group by genre.genrename
  order by total_pinjam desc
) where rownum <= 3;


/* 11 movie beserta omsetnya yang menghasilkan omset paling banyak selam 3 bulan terakhir */
select movietitle, omset from (
  select movie.movieid, movie.movietitle, sum(item.itemprice) as omset from disc 
    join item on disc.discid = item.discid
    join "transaction" on item.transactionid = "transaction".transactionid
    join movie on disc.movieid = movie.movieid
  where to_number(to_char("transaction".transactionDate, 'mm')) <= 
		to_number(to_char(sysdate, 'mm'))
    and to_number(to_char("transaction".transactionDate, 'mm')) >= 
		to_number(to_char(sysdate, 'mm')) - 3
  group by movie.movieid, movie.movietitle
  order by omset desc
) where rownum <= 7;