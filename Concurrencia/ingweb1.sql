create database ingweb
go
use ingweb
go
create table control(
	folio int default 0,
	carrera varchar(15) not null
)
go
insert into control values(0,'ISC')
insert into control values(0,'IGE')
insert into control values(0,'ITIC')
insert into control values(0,'IB')
insert into control values(0,'IER')
insert into control values(0,'IMECATR')
insert into control values(0,'IMECAN')
insert into control values(0,'IEL')
insert into control values(0,'II')

go
select * from control
go
drop proc updateControl
go
go
create proc updateControl
	@carrera varchar(15),
	@folio_out int output
as
begin
	begin tran
		declare @folio int
		select @folio_out = folio+1 from control with (rowlock, holdlock) where carrera=@carrera 
		update control set folio=@folio_out where carrera=@carrera
		commit
end

go
declare @folio_out int 
exec updateControl 'ISC', @folio_out OUTPUT
select @folio_out
select * from control