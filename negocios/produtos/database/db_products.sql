use db_products
go

create table tb_person(
	
	idPerson int identity,
	name varchar(30) not null,
	email varchar(50) not null unique,
	dtregister datetime default getdate()

)	
go

alter table tb_person
add constraint FK_PERSON
primary key (idPerson)
go

insert into tb_person (name, email) values ('admin', 'heitorhenriquedias@gmail.com')
go

select idPerson, name, email, dtregister from tb_person
go

